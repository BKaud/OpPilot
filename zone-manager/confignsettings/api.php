<?php
/**
* API for OPilot Settings Page
* Handles attraction (ride) creation and zone linking
*/

header('Content-Type: application/json');
require_once '../../DBfiles/db_config.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'addAttraction':
        addAttraction();
        break;
    case 'getZoneAttractions':
        getZoneAttractions();
        break;
    case 'getAttractionData':
        getAttractionData();
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
}

/**
* Add a new attraction (ride) and link it to a zone
* 
* Inserts into: ride, zone_ride
* Expects POST: name (string), zone_id (int, optional — defaults to 1)
*/
function addAttraction() {
    $conn = getDbConnection();

    $name = trim($_POST['name'] ?? '');
    $zoneId = intval($_POST['zone_id'] ?? 1);

    if ($name === '') {
        echo json_encode(['success' => false, 'error' => 'Attraction name is required']);
        $conn->close();
        return;
    }

    // Get next ride_id (table uses manual IDs, not auto-increment)
    $result = $conn->query("SELECT COALESCE(MAX(ride_id), 0) + 1 AS next_id FROM ride");
    $nextRideId = $result->fetch_assoc()['next_id'];

    // Insert the new ride
    $stmt = $conn->prepare("INSERT INTO ride (ride_id, ride_name, ride_status, ride_is_placed_on_canvas, ride_canvas_order, ride_create_date) VALUES (?, ?, 'up', 0, 0, NOW())");
    $stmt->bind_param("is", $nextRideId, $name);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => 'Failed to create attraction: ' . $stmt->error]);
        $stmt->close();
        $conn->close();
        return;
    }
    $stmt->close();

    // Get next zone_ride_id
    $result = $conn->query("SELECT COALESCE(MAX(zone_ride_id), 0) + 1 AS next_id FROM zone_ride");
    $nextZoneRideId = $result->fetch_assoc()['next_id'];

    // Link ride to zone
    $stmt = $conn->prepare("INSERT INTO zone_ride (zone_ride_id, zone_ride_zone_id, zone_ride_ride_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $nextZoneRideId, $zoneId, $nextRideId);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => 'Ride created but failed to link to zone: ' . $stmt->error]);
        $stmt->close();
        $conn->close();
        return;
    }
    $stmt->close();
    $conn->close();

    echo json_encode([
        'success' => true,
        'ride_id' => $nextRideId,
        'ride_name' => $name,
        'zone_id' => $zoneId
    ]);
}

/**
* Get all attractions (rides) for a zone
* 
* Queries: zone_ride + ride
* Expects GET: zone_id (int, defaults to 1)
*/
function getZoneAttractions() {
    $conn = getDbConnection();
    $zoneId = intval($_GET['zone_id'] ?? 1);

    $stmt = $conn->prepare("
        SELECT r.ride_id, r.ride_name, r.ride_status
        FROM zone_ride zr
        JOIN ride r ON r.ride_id = zr.zone_ride_ride_id
        WHERE zr.zone_ride_zone_id = ?
        ORDER BY r.ride_id
    ");
    $stmt->bind_param("i", $zoneId);
    $stmt->execute();
    $result = $stmt->get_result();

    $attractions = [];
    while ($row = $result->fetch_assoc()) {
        $attractions[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode(['success' => true, 'attractions' => $attractions]);
}

/**
* Get full data for a single attraction (ride) including its positions
* 
* Queries: ride, ride_pos, position, account
* Expects GET: ride_id (int)
*/
function getAttractionData() {
    $conn = getDbConnection();
    $rideId = intval($_GET['ride_id'] ?? 0);

    if ($rideId === 0) {
        echo json_encode(['success' => false, 'error' => 'ride_id is required']);
        $conn->close();
        return;
    }

    // Get ride info
    $stmt = $conn->prepare("SELECT ride_id, ride_name, ride_status, ride_is_placed_on_canvas, ride_canvas_order FROM ride WHERE ride_id = ?");
    $stmt->bind_param("i", $rideId);
    $stmt->execute();
    $ride = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$ride) {
        echo json_encode(['success' => false, 'error' => 'Ride not found']);
        $conn->close();
        return;
    }

    // Get positions linked to this ride
    $stmt = $conn->prepare("
        SELECT 
            rp.ride_pos_id,
            p.pos_id,
            p.pos_name,
            p.pos_desc,
            p.pos_order,
            a.account_id,
            a.acc_name,
            a.acc_tier
        FROM ride_pos rp
        JOIN position p ON p.pos_id = rp.ride_pos_pos_id
        LEFT JOIN account a ON a.account_id = rp.ride_pos_posholder
        WHERE rp.ride_pos_ride_id = ?
        ORDER BY p.pos_order, p.pos_id
    ");
    $stmt->bind_param("i", $rideId);
    $stmt->execute();
    $result = $stmt->get_result();

    $positions = [];
    while ($row = $result->fetch_assoc()) {
        $positions[] = $row;
    }
    $stmt->close();
    $conn->close();

    echo json_encode([
        'success' => true,
        'ride' => $ride,
        'positions' => $positions
    ]);
}
?>
 