<?php
/**
 * management/account-management/api.php
 *
 * Actions (GET ?action=…):
 *   load          → accounts + positions + permGroups for this org
 *
 * Actions (POST body JSON, ?action=…):
 *   createPosition   { name, default_permtier_id }
 *   deletePosition   { pos_id }
 *   updatePosition   { pos_id, name, default_permtier_id }
 *   saveUserPosition { account_id, job_position_id }
 *   saveUserPermtier { account_id, permtier_id }   (null = clear override)
 */

require_once __DIR__ . '/../../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json');

// ── Auth ──────────────────────────────────────────────────────────────────────
if (empty($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Not authenticated']);
    exit;
}

if (!isset($mysqli) || !$mysqli) {
    http_response_code(503);
    echo json_encode(['ok' => false, 'error' => 'Database unavailable']);
    exit;
}

// Resolve org_id from session
$orgId = (int)($_SESSION['org_id'] ?? 0);
if (!$orgId) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'No organization in session']);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'load':           actionLoad();           break;
    case 'createPosition': actionCreatePosition(); break;
    case 'deletePosition': actionDeletePosition(); break;
    case 'updatePosition': actionUpdatePosition(); break;
    case 'saveUserPosition': actionSaveUserPosition(); break;
    case 'saveUserPermtier': actionSaveUserPermtier(); break;
    default:
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Unknown action']);
}

// ── Helpers ───────────────────────────────────────────────────────────────────
function readJson(): array {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

// ═════════════════════════════════════════════════════════════════════════════
// LOAD – returns accounts, positions, permGroups
// ═════════════════════════════════════════════════════════════════════════════
function actionLoad(): void {
    global $mysqli, $orgId;

    // ── Permission groups for this org ────────────────────────────────────────
    $permGroups = [];
    $stmt = $mysqli->prepare(
        'SELECT pt.permtier_id, pt.permtier_name
         FROM permtier pt
         JOIN org_permtier opt2 ON opt2.org_permtier_permtier_id = pt.permtier_id
         WHERE opt2.org_permtier_org_id = ?
         ORDER BY pt.permtier_name'
    );
    if ($stmt) {
        $stmt->bind_param('i', $orgId);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($r = $res->fetch_assoc()) $permGroups[] = $r;
        $stmt->close();
    }

    // ── Job positions for this org ─────────────────────────────────────────────
    $positions = [];
    $stmt = $mysqli->prepare(
        'SELECT ojp.ojp_id, ojp.ojp_name, ojp.ojp_default_permtier_id,
                pt.permtier_name AS default_permtier_name
         FROM org_job_position ojp
         LEFT JOIN permtier pt ON pt.permtier_id = ojp.ojp_default_permtier_id
         WHERE ojp.ojp_org_id = ?
         ORDER BY ojp.ojp_name'
    );
    if ($stmt) {
        $stmt->bind_param('i', $orgId);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($r = $res->fetch_assoc()) $positions[] = $r;
        $stmt->close();
    }

    // ── Accounts in this org ──────────────────────────────────────────────────
    $accounts = [];
    $stmt = $mysqli->prepare(
        'SELECT
             a.account_id,
             a.username,
             a.acc_name,
             a.acc_profile_pic,
             a.acc_job_position_id,
             a.acc_permtier_id,
             ojp.ojp_name        AS position_name,
             ojp.ojp_default_permtier_id AS pos_default_permtier_id,
             pt_manual.permtier_name     AS manual_permtier_name,
             pt_default.permtier_name    AS pos_default_permtier_name
         FROM org_acc oa
         JOIN account a ON a.account_id = oa.org_acc_acc_id
         LEFT JOIN org_job_position ojp
               ON ojp.ojp_id = a.acc_job_position_id
              AND ojp.ojp_org_id = ?
         LEFT JOIN permtier pt_manual  ON pt_manual.permtier_id  = a.acc_permtier_id
         LEFT JOIN permtier pt_default ON pt_default.permtier_id = ojp.ojp_default_permtier_id
         WHERE oa.org_acc_org_id = ?
         ORDER BY a.acc_name'
    );
    if ($stmt) {
        $stmt->bind_param('ii', $orgId, $orgId);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($r = $res->fetch_assoc()) $accounts[] = $r;
        $stmt->close();
    }

    echo json_encode([
        'ok'         => true,
        'accounts'   => $accounts,
        'positions'  => $positions,
        'permGroups' => $permGroups,
    ]);
}

// ═════════════════════════════════════════════════════════════════════════════
// CREATE POSITION
// ═════════════════════════════════════════════════════════════════════════════
function actionCreatePosition(): void {
    global $mysqli, $orgId;
    $body = readJson();

    $name = trim($body['name'] ?? '');
    if ($name === '') {
        echo json_encode(['ok' => false, 'error' => 'Position name is required']);
        return;
    }
    if (mb_strlen($name) > 100) {
        echo json_encode(['ok' => false, 'error' => 'Position name too long (max 100 chars)']);
        return;
    }

    $defaultPermtierId = isset($body['default_permtier_id']) && $body['default_permtier_id'] !== ''
        ? (int)$body['default_permtier_id'] : null;

    $stmt = $mysqli->prepare(
        'INSERT INTO org_job_position (ojp_org_id, ojp_name, ojp_default_permtier_id)
         VALUES (?, ?, ?)'
    );
    if (!$stmt) {
        echo json_encode(['ok' => false, 'error' => 'DB error: ' . $mysqli->error]);
        return;
    }
    $stmt->bind_param('isi', $orgId, $name, $defaultPermtierId);
    if (!$stmt->execute()) {
        echo json_encode(['ok' => false, 'error' => 'Insert failed: ' . $stmt->error]);
        $stmt->close();
        return;
    }
    $newId = (int)$mysqli->insert_id;
    $stmt->close();

    // Fetch name of default permtier for response
    $permtierName = null;
    if ($defaultPermtierId) {
        $s2 = $mysqli->prepare('SELECT permtier_name FROM permtier WHERE permtier_id = ?');
        if ($s2) {
            $s2->bind_param('i', $defaultPermtierId);
            $s2->execute();
            $r = $s2->get_result()->fetch_assoc();
            $permtierName = $r['permtier_name'] ?? null;
            $s2->close();
        }
    }

    echo json_encode([
        'ok'       => true,
        'position' => [
            'ojp_id'                    => $newId,
            'ojp_name'                  => $name,
            'ojp_default_permtier_id'   => $defaultPermtierId,
            'default_permtier_name'     => $permtierName,
        ],
    ]);
}

// ═════════════════════════════════════════════════════════════════════════════
// DELETE POSITION
// ═════════════════════════════════════════════════════════════════════════════
function actionDeletePosition(): void {
    global $mysqli, $orgId;
    $body = readJson();

    $posId = (int)($body['pos_id'] ?? 0);
    if (!$posId) {
        echo json_encode(['ok' => false, 'error' => 'Invalid position ID']);
        return;
    }

    // Verify the position belongs to this org
    $stmt = $mysqli->prepare(
        'SELECT ojp_id FROM org_job_position WHERE ojp_id = ? AND ojp_org_id = ?'
    );
    if (!$stmt) {
        echo json_encode(['ok' => false, 'error' => 'DB error']);
        return;
    }
    $stmt->bind_param('ii', $posId, $orgId);
    $stmt->execute();
    if (!$stmt->get_result()->fetch_assoc()) {
        echo json_encode(['ok' => false, 'error' => 'Position not found']);
        $stmt->close();
        return;
    }
    $stmt->close();

    // Unlink accounts that had this position
    $stmt = $mysqli->prepare(
        'UPDATE account SET acc_job_position_id = NULL WHERE acc_job_position_id = ?'
    );
    if ($stmt) { $stmt->bind_param('i', $posId); $stmt->execute(); $stmt->close(); }

    $stmt = $mysqli->prepare('DELETE FROM org_job_position WHERE ojp_id = ? AND ojp_org_id = ?');
    if (!$stmt) {
        echo json_encode(['ok' => false, 'error' => 'DB error']);
        return;
    }
    $stmt->bind_param('ii', $posId, $orgId);
    if (!$stmt->execute()) {
        echo json_encode(['ok' => false, 'error' => 'Delete failed: ' . $stmt->error]);
        $stmt->close();
        return;
    }
    $stmt->close();

    echo json_encode(['ok' => true]);
}

// ═════════════════════════════════════════════════════════════════════════════
// UPDATE POSITION (name + default perm group)
// ═════════════════════════════════════════════════════════════════════════════
function actionUpdatePosition(): void {
    global $mysqli, $orgId;
    $body = readJson();

    $posId = (int)($body['pos_id'] ?? 0);
    $name  = trim($body['name'] ?? '');
    if (!$posId || $name === '') {
        echo json_encode(['ok' => false, 'error' => 'pos_id and name required']);
        return;
    }

    $defaultPermtierId = isset($body['default_permtier_id']) && $body['default_permtier_id'] !== ''
        ? (int)$body['default_permtier_id'] : null;

    $stmt = $mysqli->prepare(
        'UPDATE org_job_position
         SET ojp_name = ?, ojp_default_permtier_id = ?
         WHERE ojp_id = ? AND ojp_org_id = ?'
    );
    if (!$stmt) {
        echo json_encode(['ok' => false, 'error' => 'DB error: ' . $mysqli->error]);
        return;
    }
    $stmt->bind_param('siii', $name, $defaultPermtierId, $posId, $orgId);
    if (!$stmt->execute()) {
        echo json_encode(['ok' => false, 'error' => 'Update failed: ' . $stmt->error]);
        $stmt->close();
        return;
    }
    $stmt->close();

    echo json_encode(['ok' => true]);
}

// ═════════════════════════════════════════════════════════════════════════════
// SAVE USER JOB POSITION
// ═════════════════════════════════════════════════════════════════════════════
function actionSaveUserPosition(): void {
    global $mysqli, $orgId;
    $body = readJson();

    $accountId      = (int)($body['account_id'] ?? 0);
    $jobPositionId  = isset($body['job_position_id']) && $body['job_position_id'] !== ''
        ? (int)$body['job_position_id'] : null;

    if (!$accountId) {
        echo json_encode(['ok' => false, 'error' => 'Invalid account_id']);
        return;
    }

    // Verify account is in this org
    $stmt = $mysqli->prepare(
        'SELECT 1 FROM org_acc WHERE org_acc_org_id = ? AND org_acc_acc_id = ?'
    );
    if (!$stmt) { echo json_encode(['ok' => false, 'error' => 'DB error']); return; }
    $stmt->bind_param('ii', $orgId, $accountId);
    $stmt->execute();
    if (!$stmt->get_result()->fetch_assoc()) {
        echo json_encode(['ok' => false, 'error' => 'Account not in your organization']);
        $stmt->close();
        return;
    }
    $stmt->close();

    // If a position is provided, verify it belongs to this org
    if ($jobPositionId !== null) {
        $stmt = $mysqli->prepare(
            'SELECT 1 FROM org_job_position WHERE ojp_id = ? AND ojp_org_id = ?'
        );
        if (!$stmt) { echo json_encode(['ok' => false, 'error' => 'DB error']); return; }
        $stmt->bind_param('ii', $jobPositionId, $orgId);
        $stmt->execute();
        if (!$stmt->get_result()->fetch_assoc()) {
            echo json_encode(['ok' => false, 'error' => 'Position not found in your org']);
            $stmt->close();
            return;
        }
        $stmt->close();
    }

    $stmt = $mysqli->prepare(
        'UPDATE account SET acc_job_position_id = ? WHERE account_id = ?'
    );
    if (!$stmt) { echo json_encode(['ok' => false, 'error' => 'DB error']); return; }
    $stmt->bind_param('ii', $jobPositionId, $accountId);
    if (!$stmt->execute()) {
        echo json_encode(['ok' => false, 'error' => 'Save failed: ' . $stmt->error]);
        $stmt->close();
        return;
    }
    $stmt->close();

    // Return new effective permtier info
    $effective = getEffectivePermtier($accountId);

    echo json_encode(['ok' => true, 'effective' => $effective]);
}

// ═════════════════════════════════════════════════════════════════════════════
// SAVE USER PERMTIER (manual override; null = clear)
// ═════════════════════════════════════════════════════════════════════════════
function actionSaveUserPermtier(): void {
    global $mysqli, $orgId;
    $body = readJson();

    $accountId  = (int)($body['account_id'] ?? 0);
    $permtierId = isset($body['permtier_id']) && $body['permtier_id'] !== ''
        ? (int)$body['permtier_id'] : null;

    if (!$accountId) {
        echo json_encode(['ok' => false, 'error' => 'Invalid account_id']);
        return;
    }

    // Verify account is in this org
    $stmt = $mysqli->prepare(
        'SELECT 1 FROM org_acc WHERE org_acc_org_id = ? AND org_acc_acc_id = ?'
    );
    if (!$stmt) { echo json_encode(['ok' => false, 'error' => 'DB error']); return; }
    $stmt->bind_param('ii', $orgId, $accountId);
    $stmt->execute();
    if (!$stmt->get_result()->fetch_assoc()) {
        echo json_encode(['ok' => false, 'error' => 'Account not in your organization']);
        $stmt->close();
        return;
    }
    $stmt->close();

    $stmt = $mysqli->prepare(
        'UPDATE account SET acc_permtier_id = ? WHERE account_id = ?'
    );
    if (!$stmt) { echo json_encode(['ok' => false, 'error' => 'DB error']); return; }
    $stmt->bind_param('ii', $permtierId, $accountId);
    if (!$stmt->execute()) {
        echo json_encode(['ok' => false, 'error' => 'Save failed: ' . $stmt->error]);
        $stmt->close();
        return;
    }
    $stmt->close();

    echo json_encode(['ok' => true]);
}

// ── Returns effective permtier for display after a position change ─────────
function getEffectivePermtier(int $accountId): array {
    global $mysqli;
    $stmt = $mysqli->prepare(
        'SELECT a.acc_permtier_id,
                pt_m.permtier_name  AS manual_permtier_name,
                ojp.ojp_default_permtier_id AS pos_default_permtier_id,
                pt_d.permtier_name  AS pos_default_permtier_name
         FROM account a
         LEFT JOIN org_job_position ojp ON ojp.ojp_id = a.acc_job_position_id
         LEFT JOIN permtier pt_m ON pt_m.permtier_id = a.acc_permtier_id
         LEFT JOIN permtier pt_d ON pt_d.permtier_id = ojp.ojp_default_permtier_id
         WHERE a.account_id = ?'
    );
    if (!$stmt) return [];
    $stmt->bind_param('i', $accountId);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $r ?? [];
}
