<?php
/**
 * acc-sets/profile-api.php
 *
 * AJAX endpoint for loading and saving the logged-in user's profile.
 *
 * GET  ?action=load              → JSON profile object
 * POST ?action=save_name  body:JSON {acc_name}   → {ok:true}
 * POST ?action=save_pic   multipart file "pic"   → {ok:true, url:"…"}
 */

require_once __DIR__ . '/../bootstrap.php';
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

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// ── LOAD ──────────────────────────────────────────────────────────────────────
if ($action === 'load') {
    // Try to fetch account row by username column.
    // If the column doesn't exist yet (pre-migration DB), prepare() returns false
    // and we gracefully fall back to session-only data.
    $stmt = $mysqli->prepare(
        'SELECT a.acc_name, a.acc_tier, a.acc_job_title, a.acc_profile_pic,
                ap.accperms_createdel_acc,  ap.accperms_createdel_zone,
                ap.accperms_createdel_ride, ap.accperms_createdel_event,
                ap.accperms_call_downtime_gen
         FROM   account a
         LEFT JOIN accpermissions ap ON ap.accperms_id = a.acc_permissions
         WHERE  a.username = ?'
    );

    if (!$stmt) {
        // Likely missing username column – return minimal session data
        echo json_encode([
            'acc_name'        => $username,
            'acc_tier'        => null,
            'acc_job_title'   => null,
            'acc_profile_pic' => null,
            'perms'           => [],
        ]);
        exit;
    }

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo json_encode([
            'acc_name'        => $username,
            'acc_tier'        => null,
            'acc_job_title'   => null,
            'acc_profile_pic' => null,
            'perms'           => [],
        ]);
        exit;
    }

    // Build named permission list
    $perms = [];
    $perm_labels = [
        'accperms_createdel_acc'      => 'Manage Accounts',
        'accperms_createdel_zone'     => 'Manage Zones',
        'accperms_createdel_ride'     => 'Manage Rides',
        'accperms_createdel_event'    => 'Manage Events',
        'accperms_call_downtime_gen'  => 'Call Downtime',
    ];
    foreach ($perm_labels as $col => $label) {
        if (!empty($row[$col])) $perms[] = $label;
    }

    $pic_url = null;
    if (!empty($row['acc_profile_pic'])) {
        $pic_url = url_path($row['acc_profile_pic']);
    }

    echo json_encode([
        'acc_name'        => $row['acc_name'] ?? $username,
        'acc_tier'        => $row['acc_tier'],
        'acc_job_title'   => $row['acc_job_title'],
        'acc_profile_pic' => $pic_url,
        'perms'           => $perms,
    ]);
    exit;
}

// ── SAVE NAME ─────────────────────────────────────────────────────────────────
if ($action === 'save_name' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    $name = isset($body['acc_name']) ? trim((string)$body['acc_name']) : '';

    if ($name === '' || mb_strlen($name) > 100) {
        http_response_code(400);
        echo json_encode(['error' => 'Name must be 1–100 characters']);
        exit;
    }

    $stmt = $mysqli->prepare('UPDATE account SET acc_name = ? WHERE username = ?');
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'DB error – migration may be needed']);
        exit;
    }
    $stmt->bind_param('ss', $name, $username);
    $ok = $stmt->execute();
    $stmt->close();

    echo json_encode(['ok' => $ok]);
    exit;
}

// ── SAVE PROFILE PICTURE ──────────────────────────────────────────────────────
if ($action === 'save_pic' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['pic']) || $_FILES['pic']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['error' => 'No file received or upload error']);
        exit;
    }

    $file = $_FILES['pic'];

    // Validate MIME type by inspecting file content (not trusting the browser header)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);

    if (!in_array($mime, $allowed_types, true)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid file type. Allowed: jpg, png, gif, webp']);
        exit;
    }

    // Max 2 MB
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

    $upload_dir = APP_ROOT . '/assets/images/profile-pics/';
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            http_response_code(500);
            echo json_encode(['error' => 'Cannot create upload directory']);
            exit;
        }
    }

    // Sanitised, unique filename
    $safe_user = preg_replace('/[^a-z0-9_-]/i', '_', $username);
    $filename  = 'prof_' . $safe_user . '_' . time() . '.' . $ext;
    $dest      = $upload_dir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save file']);
        exit;
    }

    $rel_path = 'assets/images/profile-pics/' . $filename;

    // Persist path – gracefully degrade if username column missing
    $stmt = $mysqli->prepare('UPDATE account SET acc_profile_pic = ? WHERE username = ?');
    if ($stmt) {
        $stmt->bind_param('ss', $rel_path, $username);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(['ok' => true, 'url' => url_path($rel_path)]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Unknown action']);
