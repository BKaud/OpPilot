<?php
/**
 * management/org-manangement/api.php
 *
 * AJAX endpoint for Organization Management.
 * All mutating actions require the session user to be the org owner.
 *
 * GET  ?action=load              → org data + member list + is_owner flag
 * POST ?action=save_info  JSON   → {org_name, org_code}
 * POST ?action=save_owner JSON   → {new_owner_account_id}
 * POST ?action=save_pic   multipart file "pic"
 */

header('Content-Type: application/json');
session_start();

if (empty($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

require_once __DIR__ . '/../../bootstrap.php';

if (!isset($mysqli) || !$mysqli) {
    http_response_code(503);
    echo json_encode(['error' => 'Database unavailable']);
    exit;
}

$orgId     = isset($_SESSION['org_id'])     ? intval($_SESSION['org_id'])     : 0;
$accountId = isset($_SESSION['account_id']) ? intval($_SESSION['account_id']) : 0;

if ($orgId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'No organization in session']);
    exit;
}

// Ensure org_picture column exists (added on first use)
ensureOrgPictureColumn($mysqli);

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// ── LOAD ──────────────────────────────────────────────────────────────────────
if ($action === 'load') {
    $stmt = $mysqli->prepare(
        'SELECT org_id, org_name, org_code, org_owner, org_picture
         FROM organization WHERE org_id = ? LIMIT 1'
    );
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Query preparation failed']);
        exit;
    }
    $stmt->bind_param('i', $orgId);
    $stmt->execute();
    $org = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$org) {
        http_response_code(404);
        echo json_encode(['error' => 'Organization not found']);
        exit;
    }

    // Get owner account name for display
    $ownerName = null;
    if (!empty($org['org_owner'])) {
        $os = $mysqli->prepare('SELECT acc_name, username FROM account WHERE account_id = ? LIMIT 1');
        if ($os) {
            $os->bind_param('i', $org['org_owner']);
            $os->execute();
            $or = $os->get_result()->fetch_assoc();
            $os->close();
            $ownerName = $or ? ($or['acc_name'] ?: $or['username']) : null;
        }
    }

    // All active members of this org (for owner dropdown)
    $members = [];
    $ms = $mysqli->prepare(
        'SELECT a.account_id, a.acc_name, a.username
         FROM org_acc oa
         JOIN account a ON a.account_id = oa.org_acc_acc_id
         WHERE oa.org_acc_org_id = ? AND COALESCE(a.acc_is_active, 1) = 1
         ORDER BY a.acc_name'
    );
    if ($ms) {
        $ms->bind_param('i', $orgId);
        $ms->execute();
        $res = $ms->get_result();
        while ($row = $res->fetch_assoc()) {
            $members[] = [
                'account_id' => (int)$row['account_id'],
                'display'    => $row['acc_name'] ?: $row['username'],
            ];
        }
        $ms->close();
    }

    $isOwner = ($accountId > 0 && intval($org['org_owner']) === $accountId);

    echo json_encode([
        'ok'         => true,
        'org'        => [
            'org_id'      => (int)$org['org_id'],
            'org_name'    => $org['org_name'] ?? '',
            'org_code'    => $org['org_code'] ?? '',
            'org_owner'   => (int)($org['org_owner'] ?? 0),
            'org_picture' => $org['org_picture'] ?? null,
        ],
        'owner_name' => $ownerName,
        'members'    => $members,
        'is_owner'   => $isOwner,
    ]);
    exit;
}

// ── SAVE INFO (name + code) ───────────────────────────────────────────────────
if ($action === 'save_info' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    requireOwner($mysqli, $orgId, $accountId);

    $body    = json_decode(file_get_contents('php://input'), true);
    $orgName = trim($body['org_name'] ?? '');
    $orgCode = strtoupper(trim($body['org_code'] ?? ''));

    if ($orgName === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Organization name is required']);
        exit;
    }
    if (!preg_match('/^[A-Z0-9_-]{3,30}$/', $orgCode)) {
        http_response_code(400);
        echo json_encode(['error' => 'Code must be 3–30 characters (letters, numbers, - _)']);
        exit;
    }

    // Ensure code is unique across other orgs
    $ck = $mysqli->prepare('SELECT org_id FROM organization WHERE org_code = ? AND org_id != ? LIMIT 1');
    $ck->bind_param('si', $orgCode, $orgId);
    $ck->execute();
    if ($ck->get_result()->num_rows > 0) {
        http_response_code(409);
        echo json_encode(['error' => 'That organization code is already in use']);
        exit;
    }
    $ck->close();

    $stmt = $mysqli->prepare('UPDATE organization SET org_name = ?, org_code = ? WHERE org_id = ?');
    $stmt->bind_param('ssi', $orgName, $orgCode, $orgId);
    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode(['ok' => $ok, 'org_name' => $orgName, 'org_code' => $orgCode]);
    exit;
}

// ── SAVE OWNER ────────────────────────────────────────────────────────────────
if ($action === 'save_owner' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    requireOwner($mysqli, $orgId, $accountId);

    $body       = json_decode(file_get_contents('php://input'), true);
    $newOwnerId = intval($body['new_owner_account_id'] ?? 0);

    if ($newOwnerId <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid account ID']);
        exit;
    }

    // New owner must be a member of this org
    $ck = $mysqli->prepare(
        'SELECT org_acc_id FROM org_acc WHERE org_acc_org_id = ? AND org_acc_acc_id = ? LIMIT 1'
    );
    $ck->bind_param('ii', $orgId, $newOwnerId);
    $ck->execute();
    if ($ck->get_result()->num_rows === 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Account is not a member of this organization']);
        exit;
    }
    $ck->close();

    $stmt = $mysqli->prepare('UPDATE organization SET org_owner = ? WHERE org_id = ?');
    $stmt->bind_param('ii', $newOwnerId, $orgId);
    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode(['ok' => $ok, 'new_owner_account_id' => $newOwnerId]);
    exit;
}

// ── SAVE PICTURE ──────────────────────────────────────────────────────────────
if ($action === 'save_pic' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    requireOwner($mysqli, $orgId, $accountId);

    if (!isset($_FILES['pic']) || $_FILES['pic']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['error' => 'No file received or upload error']);
        exit;
    }

    $file          = $_FILES['pic'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo         = new finfo(FILEINFO_MIME_TYPE);
    $mime          = $finfo->file($file['tmp_name']);

    if (!in_array($mime, $allowed_types, true)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid file type. Allowed: jpg, png, gif, webp']);
        exit;
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['error' => 'File too large (max 2 MB)']);
        exit;
    }

    $ext_map = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];
    $ext = $ext_map[$mime];

    $upload_dir = APP_ROOT . '/assets/images/org/';
    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0755, true)) {
        http_response_code(500);
        echo json_encode(['error' => 'Cannot create upload directory']);
        exit;
    }

    $filename = 'org_' . $orgId . '_' . time() . '.' . $ext;
    $dest     = $upload_dir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save file']);
        exit;
    }

    $rel_path = 'assets/images/org/' . $filename;

    $stmt = $mysqli->prepare('UPDATE organization SET org_picture = ? WHERE org_id = ?');
    if ($stmt) {
        $stmt->bind_param('si', $rel_path, $orgId);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(['ok' => true, 'url' => url_path($rel_path)]);
    exit;
}

// ── Helpers ───────────────────────────────────────────────────────────────────

/**
 * Abort with 403 if the session user is not the org owner.
 */
function requireOwner(mysqli $conn, int $orgId, int $accountId): void {
    if ($accountId <= 0) {
        http_response_code(401);
        echo json_encode(['error' => 'Not authenticated']);
        exit;
    }
    $st = $conn->prepare('SELECT org_owner FROM organization WHERE org_id = ? LIMIT 1');
    if (!$st) {
        http_response_code(500);
        echo json_encode(['error' => 'DB error']);
        exit;
    }
    $st->bind_param('i', $orgId);
    $st->execute();
    $row = $st->get_result()->fetch_assoc();
    $st->close();
    if (!$row || intval($row['org_owner']) !== $accountId) {
        http_response_code(403);
        echo json_encode(['error' => 'Only the organization owner can make this change']);
        exit;
    }
}

/**
 * Add org_picture column to organization table if it does not exist yet.
 */
function ensureOrgPictureColumn(mysqli $conn): void {
    $result = $conn->query("SHOW COLUMNS FROM `organization` LIKE 'org_picture'");
    if ($result && $result->num_rows === 0) {
        $conn->query("ALTER TABLE `organization` ADD COLUMN `org_picture` VARCHAR(255) DEFAULT NULL");
    }
}

http_response_code(400);
echo json_encode(['error' => 'Unknown action']);
