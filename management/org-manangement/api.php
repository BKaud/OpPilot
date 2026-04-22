<?php
/**
 * management/org-manangement/api.php
 *
 * AJAX endpoint for loading and saving organization settings.
 * Only accessible to the organization owner.
 *
 * GET  ?action=load              → JSON org object
 * POST ?action=save_name  body:JSON {org_name}   → {ok:true}
 * POST ?action=save_pic   multipart file "pic"   → {ok:true, url:"…"}
 * POST ?action=save_color body:JSON {org_color}  → {ok:true, org_color:"#RRGGBB"}
 */

require_once __DIR__ . '/../../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json');

$username = $_SESSION['user'] ?? null;
if (!$username) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

if (!isset($mysqli) || !$mysqli) {
    http_response_code(503);
    echo json_encode(['error' => 'Database unavailable']);
    exit;
}

// Get the organization ID from query parameter or from user's account
$org_id = $_GET['org_id'] ?? $_POST['org_id'] ?? null;
if (!$org_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Organization ID is required']);
    exit;
}

// Verify the user is the owner of this organization
$stmt = $mysqli->prepare(
    'SELECT o.org_id FROM organization o
     WHERE o.org_id = ? AND o.org_owner = (
        SELECT a.account_id FROM account a WHERE a.username = ?
     )'
);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
    exit;
}
$stmt->bind_param('is', $org_id, $username);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    http_response_code(403);
    echo json_encode(['error' => 'You do not have permission to manage this organization']);
    $stmt->close();
    exit;
}
$stmt->close();

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// ── LOAD ──────────────────────────────────────────────────────────────────────
if ($action === 'load') {
    $stmt = $mysqli->prepare(
        'SELECT o.org_id, o.org_name, o.org_color, o.org_profile_pic,
                a.acc_name as org_owner_name
         FROM organization o
         LEFT JOIN account a ON a.account_id = o.org_owner
         WHERE o.org_id = ?'
    );

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
        exit;
    }

    $stmt->bind_param('i', $org_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if (!$row) {
        http_response_code(404);
        echo json_encode(['error' => 'Organization not found']);
        exit;
    }

    $pic_url = null;
    if (!empty($row['org_profile_pic'])) {
        $pic_url = url_path($row['org_profile_pic']);
    }

    echo json_encode([
        'org_id'           => $row['org_id'],
        'org_name'         => $row['org_name'],
        'org_owner_name'   => $row['org_owner_name'],
        'org_profile_pic'  => $pic_url,
        'org_color'        => $row['org_color'] ?? '#1a8f7a',
    ]);
    exit;
}

// ── SAVE NAME ─────────────────────────────────────────────────────────────────
if ($action === 'save_name' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    $name = isset($body['org_name']) ? trim((string)$body['org_name']) : '';

    if ($name === '' || mb_strlen($name) > 200) {
        http_response_code(400);
        echo json_encode(['error' => 'Organization name must be 1–200 characters']);
        exit;
    }

    $stmt = $mysqli->prepare('UPDATE organization SET org_name = ? WHERE org_id = ?');
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
        exit;
    }
    $stmt->bind_param('si', $name, $org_id);
    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode(['ok' => $ok]);
    exit;
}

// ── SAVE PROFILE PICTURE ───────────────────────────────────────────────────────
if ($action === 'save_pic' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['pic'])) {
        http_response_code(400);
        echo json_encode(['error' => 'No file uploaded']);
        exit;
    }

    $file = $_FILES['pic'];
    $filename = $file['name'];
    $tmp_path = $file['tmp_name'];
    $file_size = $file['size'];

    // Validate file
    if ($file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['error' => 'File upload error: ' . $file['error']]);
        exit;
    }

    if ($file_size > 5 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['error' => 'File must be under 5MB']);
        exit;
    }

    // Check MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tmp_path);
    finfo_close($finfo);

    $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowed_mimes)) {
        http_response_code(400);
        echo json_encode(['error' => 'Only image files (JPG, PNG, GIF, WebP) are allowed']);
        exit;
    }

    // Create upload directory if needed
    $upload_dir = APP_ROOT . '/assets/images/org-profiles/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Generate safe filename
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    $safe_filename = 'org_' . $org_id . '_' . time() . '.' . $file_ext;
    $upload_path = $upload_dir . $safe_filename;
    $relative_path = '/assets/images/org-profiles/' . $safe_filename;

    // Move uploaded file
    if (!move_uploaded_file($tmp_path, $upload_path)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save file']);
        exit;
    }

    // Delete old profile picture if it exists
    $stmt = $mysqli->prepare('SELECT org_profile_pic FROM organization WHERE org_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $org_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();

        if ($row && !empty($row['org_profile_pic'])) {
            $old_file = APP_ROOT . $row['org_profile_pic'];
            if (file_exists($old_file) && strpos($old_file, '/org-profiles/') !== false) {
                unlink($old_file);
            }
        }
    }

    // Update database
    $stmt = $mysqli->prepare('UPDATE organization SET org_profile_pic = ? WHERE org_id = ?');
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
        exit;
    }
    $stmt->bind_param('si', $relative_path, $org_id);
    $ok = $stmt->execute();
    $stmt->close();

    if ($ok) {
        echo json_encode([
            'ok' => true,
            'url' => url_path($relative_path)
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update database']);
    }
    exit;
}

// ── SAVE COLOR ─────────────────────────────────────────────────────────────────
if ($action === 'save_color' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    $color = isset($body['org_color']) ? strtoupper(trim((string)$body['org_color'])) : '';

    if (!preg_match('/^#[0-9A-F]{6}$/', $color)) {
        http_response_code(400);
        echo json_encode(['error' => 'Color must be a valid hex value like #1A8F7A']);
        exit;
    }

    $stmt = $mysqli->prepare('UPDATE organization SET org_color = ? WHERE org_id = ?');
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
        exit;
    }
    $stmt->bind_param('si', $color, $org_id);
    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode(['ok' => $ok, 'org_color' => $color]);
    exit;
}

// Default response
http_response_code(400);
echo json_encode(['error' => 'Invalid action']);
