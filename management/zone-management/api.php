<?php
header('Content-Type: application/json');
session_start();

require_once '../../DBfiles/db_config.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'getZoneManagementData':
        getZoneManagementData();
        break;
    case 'saveZone':
        saveZone();
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
}

function getZoneManagementData() {
    $conn = getDbConnection();

    try {
        ensureSchema($conn);

        $orgId = getCurrentOrgId($conn);
        $zones = fetchZones($conn, $orgId);
        $operators = fetchOperators($conn, $orgId);
        $permissionGroups = fetchPermissionGroups($conn, $orgId);

        echo json_encode([
            'success' => true,
            'organization_id' => $orgId,
            'zones' => $zones,
            'operators' => $operators,
            'permissionGroups' => $permissionGroups
        ]);
    } catch (Throwable $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    } finally {
        $conn->close();
    }
}

function saveZone() {
    $conn = getDbConnection();

    $zoneId = intval($_POST['zone_id'] ?? 0);
    $zoneName = trim($_POST['zone_name'] ?? '');
    $zoneLeadRaw = trim($_POST['zone_lead_account_id'] ?? '');
    $zonePermRaw = trim($_POST['zone_permtier_id'] ?? '');
    $zoneIcon = trim($_POST['zone_icon'] ?? 'map-pin');

    if ($zoneId <= 0) {
        echo json_encode(['success' => false, 'error' => 'zone_id is required']);
        $conn->close();
        return;
    }
    if ($zoneName === '') {
        echo json_encode(['success' => false, 'error' => 'Zone name is required']);
        $conn->close();
        return;
    }

    $allowedIcons = ['map-pin', 'ferris', 'coaster', 'water', 'family', 'star'];
    if (!in_array($zoneIcon, $allowedIcons, true)) {
        $zoneIcon = 'map-pin';
    }

    $zoneLead = ($zoneLeadRaw === '') ? null : intval($zoneLeadRaw);
    $zonePerm = ($zonePermRaw === '') ? null : intval($zonePermRaw);

    try {
        ensureSchema($conn);

        $stmt = $conn->prepare('UPDATE zone SET zone_name = ?, zone_lead_account_id = ?, zone_permtier_id = ?, zone_icon = ? WHERE zone_id = ?');
        if (!$stmt) {
            throw new Exception('Unable to prepare zone update');
        }

        $stmt->bind_param('siisi', $zoneName, $zoneLead, $zonePerm, $zoneIcon, $zoneId);
        if (!$stmt->execute()) {
            throw new Exception('Failed to save zone: ' . $stmt->error);
        }
        $stmt->close();

        echo json_encode([
            'success' => true,
            'zone_id' => $zoneId,
            'zone_name' => $zoneName,
            'zone_lead_account_id' => $zoneLead,
            'zone_permtier_id' => $zonePerm,
            'zone_icon' => $zoneIcon
        ]);
    } catch (Throwable $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    } finally {
        $conn->close();
    }
}

function ensureSchema(mysqli $conn) {
    ensureColumn($conn, 'zone', 'zone_lead_account_id', 'INT NULL');
    ensureColumn($conn, 'zone', 'zone_permtier_id', 'INT NULL');
    ensureColumn($conn, 'zone', "zone_icon", "VARCHAR(120) NOT NULL DEFAULT 'map-pin'");
    ensureColumn($conn, 'permtier', 'permtier_name', 'VARCHAR(120) NULL');

    // Backfill unnamed permission groups with readable labels.
    $conn->query("UPDATE permtier SET permtier_name = CONCAT('Tier ', permtier_id) WHERE permtier_name IS NULL OR permtier_name = ''");
}

function ensureColumn(mysqli $conn, $table, $column, $definition) {
    $tableSafe = $conn->real_escape_string($table);
    $columnSafe = $conn->real_escape_string($column);
    $result = $conn->query("SHOW COLUMNS FROM `{$tableSafe}` LIKE '{$columnSafe}'");

    if (!$result || $result->num_rows > 0) {
        return;
    }

    $sql = "ALTER TABLE `{$tableSafe}` ADD COLUMN `{$column}` {$definition}";
    if (!$conn->query($sql)) {
        throw new Exception('Schema update failed: ' . $conn->error);
    }
}

function getCurrentOrgId(mysqli $conn) {
    $sessionOrg = $_SESSION['org_id'] ?? null;
    if (is_numeric($sessionOrg) && intval($sessionOrg) > 0) {
        return intval($sessionOrg);
    }

    $result = $conn->query('SELECT org_id FROM organization ORDER BY org_id ASC LIMIT 1');
    if ($result && $row = $result->fetch_assoc()) {
        return intval($row['org_id']);
    }

    return null;
}

function fetchZones(mysqli $conn, $orgId) {
    $useOrgFilter = false;
    if ($orgId !== null) {
        $stmt = $conn->prepare('SELECT COUNT(*) AS c FROM org_zone WHERE org_zone_org_id = ?');
        $stmt->bind_param('i', $orgId);
        $stmt->execute();
        $count = intval(($stmt->get_result()->fetch_assoc()['c'] ?? 0));
        $stmt->close();
        $useOrgFilter = ($count > 0);
    }

    if ($useOrgFilter) {
        $sql = "
            SELECT z.zone_id, z.zone_name, z.zone_lead_account_id, z.zone_permtier_id, z.zone_icon,
                   COUNT(DISTINCT zr.zone_ride_ride_id) AS ride_count
            FROM org_zone oz
            JOIN zone z ON z.zone_id = oz.org_zone_zone_id
            LEFT JOIN zone_ride zr ON zr.zone_ride_zone_id = z.zone_id
            WHERE oz.org_zone_org_id = ?
            GROUP BY z.zone_id, z.zone_name, z.zone_lead_account_id, z.zone_permtier_id, z.zone_icon
            ORDER BY z.zone_id
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $orgId);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $sql = "
            SELECT z.zone_id, z.zone_name, z.zone_lead_account_id, z.zone_permtier_id, z.zone_icon,
                   COUNT(DISTINCT zr.zone_ride_ride_id) AS ride_count
            FROM zone z
            LEFT JOIN zone_ride zr ON zr.zone_ride_zone_id = z.zone_id
            GROUP BY z.zone_id, z.zone_name, z.zone_lead_account_id, z.zone_permtier_id, z.zone_icon
            ORDER BY z.zone_id
        ";
        $result = $conn->query($sql);
    }

    $zones = [];
    while ($row = $result->fetch_assoc()) {
        if (empty($row['zone_icon'])) {
            $row['zone_icon'] = 'map-pin';
        }
        $zones[] = $row;
    }

    if ($useOrgFilter) {
        $stmt->close();
    }

    return $zones;
}

function fetchOperators(mysqli $conn, $orgId) {
    $useOrgFilter = false;
    if ($orgId !== null) {
        $stmt = $conn->prepare('SELECT COUNT(*) AS c FROM org_acc WHERE org_acc_org_id = ?');
        $stmt->bind_param('i', $orgId);
        $stmt->execute();
        $count = intval(($stmt->get_result()->fetch_assoc()['c'] ?? 0));
        $stmt->close();
        $useOrgFilter = ($count > 0);
    }

    if ($useOrgFilter) {
        $sql = "
            SELECT DISTINCT a.account_id, a.acc_name
            FROM org_acc oa
            JOIN account a ON a.account_id = oa.org_acc_acc_id
            WHERE oa.org_acc_org_id = ? AND COALESCE(a.acc_is_active, 1) = 1
            ORDER BY a.acc_name
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $orgId);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT account_id, acc_name FROM account WHERE COALESCE(acc_is_active, 1) = 1 ORDER BY acc_name");
    }

    $operators = [];
    while ($row = $result->fetch_assoc()) {
        $operators[] = $row;
    }

    if ($useOrgFilter) {
        $stmt->close();
    }

    return $operators;
}

function fetchPermissionGroups(mysqli $conn, $orgId) {
    $useOrgFilter = false;
    if ($orgId !== null) {
        $stmt = $conn->prepare('SELECT COUNT(*) AS c FROM org_permtier WHERE org_permtier_org_id = ?');
        $stmt->bind_param('i', $orgId);
        $stmt->execute();
        $count = intval(($stmt->get_result()->fetch_assoc()['c'] ?? 0));
        $stmt->close();
        $useOrgFilter = ($count > 0);
    }

    if ($useOrgFilter) {
        $sql = "
            SELECT DISTINCT p.permtier_id, COALESCE(p.permtier_name, CONCAT('Tier ', p.permtier_id)) AS permtier_name
            FROM org_permtier op
            JOIN permtier p ON p.permtier_id = op.org_permtier_permtier_id
            WHERE op.org_permtier_org_id = ?
            ORDER BY p.permtier_id
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $orgId);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT permtier_id, COALESCE(permtier_name, CONCAT('Tier ', permtier_id)) AS permtier_name FROM permtier ORDER BY permtier_id");
    }

    $groups = [];
    while ($row = $result->fetch_assoc()) {
        $groups[] = $row;
    }

    if ($useOrgFilter) {
        $stmt->close();
    }

    return $groups;
}
