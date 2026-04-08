<?php
/**
 * acc-sets/navbar-api.php
 *
 * AJAX endpoint for saving and loading navbar widget preferences.
 *
 * GET  ?action=load              → JSON array of 9 slots
 * POST ?action=save  body: JSON  → saves slots, returns {ok:true}
 */

require_once __DIR__ . '/../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json');

// Must be logged in
$username = $_SESSION['user'] ?? null;
if (!$username) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

// DB must be available
if (!isset($mysqli) || !$mysqli) {
    http_response_code(503);
    echo json_encode(['error' => 'Database unavailable']);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// ── LOAD ──────────────────────────────────────────────────────
if ($action === 'load') {
    $slots = array_fill(1, 9, ['slot_index' => 0, 'widget_key' => null, 'widget_config' => null]);

    $stmt = $mysqli->prepare(
        'SELECT slot_index, widget_key, widget_config FROM navbar_prefs WHERE pref_username = ? ORDER BY slot_index'
    );
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $idx = (int)$row['slot_index'];
            if ($idx >= 1 && $idx <= 9) {
                $slots[$idx] = [
                    'slot_index'    => $idx,
                    'widget_key'    => $row['widget_key'],
                    'widget_config' => $row['widget_config'] ? json_decode($row['widget_config'], true) : null,
                ];
            }
        }
        $stmt->close();
    }

    echo json_encode(array_values($slots));
    exit;
}

// ── SAVE ──────────────────────────────────────────────────────
if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);

    if (!is_array($data)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON body']);
        exit;
    }

    // Allowed widget keys (whitelist)
    $allowed_keys = [
        'current_time', 'current_date', 'current_user',
        'ride_status', 'open_rides',
        'zone_lead', 'zone_rotation',
        'org_name', 'quick_link',
    ];

    $stmt = $mysqli->prepare(
        'INSERT INTO navbar_prefs (pref_username, slot_index, widget_key, widget_config)
         VALUES (?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE widget_key = VALUES(widget_key), widget_config = VALUES(widget_config)'
    );

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'DB prepare failed']);
        exit;
    }

    $mysqli->begin_transaction();
    try {
        foreach ($data as $slot) {
            $idx = isset($slot['slot_index']) ? (int)$slot['slot_index'] : 0;
            if ($idx < 1 || $idx > 9) continue;

            $key = isset($slot['widget_key']) && in_array($slot['widget_key'], $allowed_keys, true)
                ? $slot['widget_key']
                : null;

            $cfg = null;
            if ($key && isset($slot['widget_config']) && is_array($slot['widget_config'])) {
                // Sanitise config values – only allow scalar values
                $clean = [];
                foreach ($slot['widget_config'] as $k => $v) {
                    if (is_scalar($v)) {
                        $clean[preg_replace('/[^a-z0-9_]/i', '', $k)] = $v;
                    }
                }
                $cfg = empty($clean) ? null : json_encode($clean);
            }

            $stmt->bind_param('siis', $username, $idx, $key, $cfg);
            $stmt->execute();
        }
        $mysqli->commit();
        echo json_encode(['ok' => true]);
    } catch (Exception $e) {
        $mysqli->rollback();
        http_response_code(500);
        echo json_encode(['error' => 'Save failed']);
    }

    $stmt->close();
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Unknown action']);
