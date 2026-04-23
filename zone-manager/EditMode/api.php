<?php
/**
 * API for OPPilot Rotation Management
 * Works with existing oppilot database schema
 * 
 * Tables: zone, ride, position, account, ride_pos, zone_ride
 */

header('Content-Type: application/json');
session_start();

if (empty($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit;
}

require_once '../../DBfiles/db_config.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'getZoneData':
        getZoneData();
        break;
    case 'saveLayout':
        saveLayout();
        break;
    case 'getAvailableOperators':
        getAvailableOperators();
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
}

/**
 * Get all data for a specific zone
 * 
 * Queries tables: zone_ride, ride, ride_pos, position, account
 * Returns: List of rides with their positions and assigned operators
 */
function getZoneData() {
    $conn = getDbConnection();
    $zoneId = $_GET['zone_id'] ?? 1;
    
    // First check if zone exists
    $checkZone = $conn->query("SELECT COUNT(*) as count FROM zone WHERE zone_id = $zoneId");
    $zoneExists = $checkZone->fetch_assoc()['count'] > 0;
    
    if (!$zoneExists) {
        // Return empty data with helpful message
        echo json_encode([
            'success' => true,
            'attractions' => [],
            'message' => 'No zone found. Please run migration.sql and sample_data.sql first.'
        ]);
        $conn->close();
        return;
    }
    
    // Complex query to get all rides with their positions and assigned operators
    $sql = "
        SELECT 
            r.ride_id,
            r.ride_name,
            r.ride_image_url,
            r.ride_main_pos_id,
            COALESCE(r.ride_is_placed_on_canvas, 0) as is_placed_on_canvas,
            COALESCE(r.ride_canvas_order, 0) as canvas_order,
            p.pos_id,
            p.pos_name,
            COALESCE(p.pos_order, 1) as pos_order,
            rp.ride_pos_posholder as operator_id,
            a.acc_name as operator_name,
            COALESCE(a.acc_tier, 'Tier 1') as operator_tier
        FROM zone_ride zr
        INNER JOIN ride r ON zr.zone_ride_ride_id = r.ride_id
        LEFT JOIN ride_pos rp ON r.ride_id = rp.ride_pos_ride_id
        LEFT JOIN position p ON rp.ride_pos_pos_id = p.pos_id
        LEFT JOIN account a ON rp.ride_pos_posholder = a.account_id
        WHERE zr.zone_ride_zone_id = ?
        ORDER BY r.ride_id, COALESCE(p.pos_order, 1)
    ";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Query preparation failed: ' . $conn->error]);
        $conn->close();
        return;
    }
    
    $stmt->bind_param('i', $zoneId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Organize data into attractions array
    $attractions = [];
    while ($row = $result->fetch_assoc()) {
        $rideId = $row['ride_id'];
        
        if (!isset($attractions[$rideId])) {
            $attractions[$rideId] = [
                'id' => 'ride' . $rideId,
                'name' => $row['ride_name'],
                'imageUrl' => $row['ride_image_url'] ?? '',
                'mainPosId' => $row['ride_main_pos_id'],
                'isPlaced' => (bool)$row['is_placed_on_canvas'],
                'positions' => []
            ];
        }
        
        // Only add position if it exists
        if ($row['pos_id']) {
            // Check if this position is already added (due to JOIN duplicates)
            $positionExists = false;
            foreach ($attractions[$rideId]['positions'] as $existingPos) {
                if ($existingPos['id'] == $row['pos_id']) {
                    $positionExists = true;
                    break;
                }
            }
            
            if (!$positionExists) {
                $attractions[$rideId]['positions'][] = [
                    'id' => $row['pos_id'],
                    'name' => $row['pos_name'],
                    'order' => $row['pos_order'],
                    'operator' => $row['operator_name'] ?? '',
                    'operatorId' => $row['operator_id'],
                    'operatorTier' => $row['operator_tier']
                ];
            }
        }
    }
    
    // Sort positions by order
    foreach ($attractions as &$attraction) {
        usort($attraction['positions'], function($a, $b) {
            return $a['order'] - $b['order'];
        });
    }
    
    // Get all available positions from database
    $allPositionsResult = $conn->query("SELECT pos_id, pos_name FROM position ORDER BY pos_name");
    $allPositions = [];
    while ($posRow = $allPositionsResult->fetch_assoc()) {
        $allPositions[] = [
            'id' => $posRow['pos_id'],
            'name' => $posRow['pos_name']
        ];
    }
    
    $stmt->close();
    $conn->close();
    
    echo json_encode([
        'success' => true,
        'attractions' => array_values($attractions),
        'allPositions' => $allPositions
    ]);
}

/**
 * Save the current rotation layout
 * 
 * Updates: ride.ride_is_placed_on_canvas and ride_pos.ride_pos_posholder
 */
function saveLayout() {
    $conn = getDbConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    error_log('[saveLayout] Received data: ' . json_encode($data));
    
    if (!$data || !isset($data['attractions'])) {
        error_log('[saveLayout] ERROR: Invalid data format');
        echo json_encode(['success' => false, 'error' => 'Invalid data']);
        return;
    }
    
    $zoneId = $data['zone_id'] ?? 1;
    error_log('[saveLayout] Processing zone_id: ' . $zoneId);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Reset all rides in this zone to not placed
        $sql = "
            UPDATE ride r
            INNER JOIN zone_ride zr ON r.ride_id = zr.zone_ride_ride_id
            SET r.ride_is_placed_on_canvas = 0
            WHERE zr.zone_ride_zone_id = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $zoneId);
        $stmt->execute();
        $stmt->close();
        
        // Clear all operator assignments for this zone
        $sql = "
            UPDATE ride_pos rp
            INNER JOIN zone_ride zr ON rp.ride_pos_ride_id = zr.zone_ride_ride_id
            SET rp.ride_pos_posholder = NULL
            WHERE zr.zone_ride_zone_id = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $zoneId);
        $stmt->execute();
        $stmt->close();
        
        // Update placed rides and operator assignments
        foreach ($data['attractions'] as $attraction) {
            $rideId = intval(str_replace('ride', '', $attraction['id']));
            $rideName = trim($attraction['name'] ?? '');
            
            // Mark ride as placed and update the name if provided
            if ($rideName !== '') {
                $sql = "UPDATE ride SET ride_name = ?, ride_is_placed_on_canvas = 1 WHERE ride_id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('si', $rideName, $rideId);
                    $stmt->execute();
                    $stmt->close();
                }
            } else {
                $sql = "UPDATE ride SET ride_is_placed_on_canvas = 1 WHERE ride_id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('i', $rideId);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            
            // Update operator assignments
            foreach ($attraction['positions'] as $position) {
                if (!empty($position['operatorId'])) {
                    $sql = "
                        UPDATE ride_pos 
                        SET ride_pos_posholder = ?
                        WHERE ride_pos_pos_id = ? AND ride_pos_ride_id = ?
                    ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('iii', $position['operatorId'], $position['id'], $rideId);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
        
        $conn->commit();
        error_log('[saveLayout] SUCCESS: Layout saved for ' . count($data['attractions']) . ' attractions');
        echo json_encode(['success' => true, 'message' => 'Layout saved successfully']);
        
    } catch (Exception $e) {
        $conn->rollback();
        error_log('[saveLayout] ERROR: ' . $e->getMessage());
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    
    $conn->close();
}

/**
 * Get all operators (account table records)
 * 
 * Returns: List of active accounts that can be assigned as operators
 */
function getAvailableOperators() {
    $conn = getDbConnection();
    $zoneId = $_GET['zone_id'] ?? 1;
    
    // Get all active accounts that could be operators
    // Note: You may want to filter this based on org_acc or specific criteria
    $sql = "
        SELECT DISTINCT
            a.account_id,
            a.acc_name,
            COALESCE(a.acc_tier, 'Tier 1') as acc_tier
        FROM account a
        WHERE COALESCE(a.acc_is_active, 1) = 1
        ORDER BY a.acc_name
    ";
    
    $result = $conn->query($sql);
    
    $operators = [];
    while ($row = $result->fetch_assoc()) {
        $operators[] = [
            'id' => $row['account_id'],
            'name' => $row['acc_name'],
            'tier' => $row['acc_tier']
        ];
    }
    
    $conn->close();
    
    echo json_encode([
        'success' => true,
        'operators' => $operators
    ]);
}
?>
