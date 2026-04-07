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
    case 'getZoneSettings':
        getZoneSettings();
        break;
    case 'saveAttractionSettings':
        saveAttractionSettings();
        break;
    case 'saveZoneLock':
        saveZoneLock();
        break;
    case 'deleteAttraction':
        deleteAttraction();
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
    // Optionally handle an uploaded attraction image at creation time
    $imageUrlToReturn = '';
    if (isset($_FILES['attraction_image']) && $_FILES['attraction_image']['error'] === UPLOAD_ERR_OK) {
        $upload = $_FILES['attraction_image'];
        $tmp = $upload['tmp_name'];
        $mime = @mime_content_type($tmp);
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
        if ($tmp && isset($allowed[$mime])) {
            $ext = $allowed[$mime];
            $uploadDir = __DIR__ . '/../../assets/images/attractions';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $filename = 'ride_' . $nextRideId . '_' . time() . '.' . $ext;
            $destPath = $uploadDir . '/' . $filename;
            if (move_uploaded_file($tmp, $destPath)) {
                // Web-accessible URL (adjust if site root differs)
                $webUrl = '/OPilot/assets/images/attractions/' . $filename;
                $stmt = $conn->prepare("UPDATE ride SET ride_image_url = ? WHERE ride_id = ?");
                if ($stmt) {
                    $stmt->bind_param('si', $webUrl, $nextRideId);
                    $stmt->execute();
                    $stmt->close();
                    $imageUrlToReturn = $webUrl;
                }
            }
        }
    }

    $conn->close();

    $resp = [
        'success' => true,
        'ride_id' => $nextRideId,
        'ride_name' => $name,
        'zone_id' => $zoneId
    ];
    if (!empty($imageUrlToReturn)) $resp['ride_image_url'] = $imageUrlToReturn;

    echo json_encode($resp);
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
        SELECT r.ride_id, r.ride_name, r.ride_status, r.ride_image_url, r.ride_link_url
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

// saveAttractionSettings moved below to keep function definitions top-level

    // Get ride info (include required certs and main position)
    $stmt = $conn->prepare("SELECT ride_id, ride_name, ride_status, ride_is_placed_on_canvas, ride_canvas_order, ride_required_certs, ride_main_pos_id, ride_image_url, ride_link_url FROM ride WHERE ride_id = ?");
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

/**
 * Delete an attraction (ride) and clean up linked data
 * Expects POST: ride_id (int)
 */
function deleteAttraction() {
    $conn = getDbConnection();
    $rideId = intval($_POST['ride_id'] ?? 0);

    if ($rideId === 0) {
        echo json_encode(['success' => false, 'error' => 'ride_id is required']);
        $conn->close();
        return;
    }

    try {
        $conn->begin_transaction();

        // Collect position ids linked to this ride
        $stmt = $conn->prepare("SELECT ride_pos_pos_id FROM ride_pos WHERE ride_pos_ride_id = ?");
        $stmt->bind_param("i", $rideId);
        $stmt->execute();
        $res = $stmt->get_result();
        $posIds = [];
        while ($r = $res->fetch_assoc()) {
            $posIds[] = intval($r['ride_pos_pos_id']);
        }
        $stmt->close();

        // Delete ride_pos links for this ride
        $stmt = $conn->prepare("DELETE FROM ride_pos WHERE ride_pos_ride_id = ?");
        $stmt->bind_param("i", $rideId);
        $stmt->execute();
        $stmt->close();

        // For each position, delete if not linked to any other ride
        foreach ($posIds as $pid) {
            $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM ride_pos WHERE ride_pos_pos_id = ?");
            $stmt->bind_param("i", $pid);
            $stmt->execute();
            $cnt = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
            $stmt->close();

            if (intval($cnt) === 0) {
                $stmt = $conn->prepare("DELETE FROM position WHERE pos_id = ?");
                $stmt->bind_param("i", $pid);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Remove zone_ride links
        $stmt = $conn->prepare("DELETE FROM zone_ride WHERE zone_ride_ride_id = ?");
        $stmt->bind_param("i", $rideId);
        $stmt->execute();
        $stmt->close();

        // Remove the ride
        $stmt = $conn->prepare("DELETE FROM ride WHERE ride_id = ?");
        $stmt->bind_param("i", $rideId);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        echo json_encode(['success' => true, 'ride_id' => $rideId]);
        return;

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        return;
    } finally {
        $conn->close();
    }
}

/**
 * Save attraction (ride) settings
 * Expects POST: ride_id (int), ride_name (string), ride_status (string), ride_is_placed_on_canvas (0|1), positions (json), deleted_positions (json), main_position, required_certs
 */
function saveAttractionSettings() {
    $conn = getDbConnection();

    $rideId = intval($_POST['ride_id'] ?? 0);
    $name = trim($_POST['ride_name'] ?? '');
    $status = $_POST['ride_status'] ?? 'up';
    $isPlaced = intval($_POST['ride_is_placed_on_canvas'] ?? 0);

    $positions = json_decode($_POST['positions'] ?? '[]', true);
    $deleted = json_decode($_POST['deleted_positions'] ?? '[]', true);
    $mainPositionRaw = $_POST['main_position'] ?? '';
    $mainPosition = ($mainPositionRaw === '' ? null : intval($mainPositionRaw));
    $requiredCerts = $_POST['required_certs'] ?? '';
    $rideLink = $_POST['ride_link'] ?? '';

    if ($rideId === 0) {
        echo json_encode(['success' => false, 'error' => 'ride_id is required']);
        $conn->close();
        return;
    }

    try {
        $conn->begin_transaction();

        // Ensure ride has columns for required certs, main position and link
        $res = $conn->query("SHOW COLUMNS FROM ride LIKE 'ride_required_certs'");
        if ($res && $res->num_rows == 0) {
            $conn->query("ALTER TABLE ride ADD COLUMN ride_required_certs TEXT NULL");
        }
        $res = $conn->query("SHOW COLUMNS FROM ride LIKE 'ride_main_pos_id'");
        if ($res && $res->num_rows == 0) {
            $conn->query("ALTER TABLE ride ADD COLUMN ride_main_pos_id INT NULL");
        }
            // Ensure ride has column to store image URL
            $res = $conn->query("SHOW COLUMNS FROM ride LIKE 'ride_image_url'");
            if ($res && $res->num_rows == 0) {
                $conn->query("ALTER TABLE ride ADD COLUMN ride_image_url VARCHAR(255) NULL");
            }
            // Ensure ride has column to store link URL
            $res = $conn->query("SHOW COLUMNS FROM ride LIKE 'ride_link_url'");
            if ($res && $res->num_rows == 0) {
                $conn->query("ALTER TABLE ride ADD COLUMN ride_link_url VARCHAR(255) NULL");
            }

        // Update ride row (including newly ensured columns)
        $stmt = $conn->prepare("UPDATE ride SET ride_name = ?, ride_status = ?, ride_is_placed_on_canvas = ?, ride_required_certs = ?, ride_main_pos_id = ?, ride_link_url = ? WHERE ride_id = ?");
        if (!$stmt) throw new Exception('DB prepare failed for ride update');
        $stmt->bind_param("ssisisi", $name, $status, $isPlaced, $requiredCerts, $mainPosition, $rideLink, $rideId);
        if (!$stmt->execute()) throw new Exception('Failed to update ride: ' . $stmt->error);
        $stmt->close();

        // Handle deleted positions: unlink and remove
        if (is_array($deleted) && count($deleted) > 0) {
            foreach ($deleted as $did) {
                $did = intval($did);
                $stmt = $conn->prepare("DELETE FROM ride_pos WHERE ride_pos_pos_id = ? AND ride_pos_ride_id = ?");
                if ($stmt) {
                    $stmt->bind_param("ii", $did, $rideId);
                    $stmt->execute();
                    $stmt->close();
                }
                $stmt = $conn->prepare("DELETE FROM position WHERE pos_id = ?");
                if ($stmt) {
                    $stmt->bind_param("i", $did);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        // Handle positions: update existing, insert new and link
        if (is_array($positions)) {
            foreach ($positions as $pos) {
                $pid = intval($pos['pos_id'] ?? 0);
                $pname = trim($pos['pos_name'] ?? '');
                $porder = intval($pos['pos_order'] ?? 0);

                if ($pid > 0) {
                    $stmt = $conn->prepare("UPDATE position SET pos_name = ?, pos_order = ? WHERE pos_id = ?");
                    if ($stmt) {
                        $stmt->bind_param("sii", $pname, $porder, $pid);
                        $stmt->execute();
                        $stmt->close();
                    }

                    // Ensure link exists in ride_pos
                    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM ride_pos WHERE ride_pos_pos_id = ? AND ride_pos_ride_id = ?");
                    if ($stmt) {
                        $stmt->bind_param("ii", $pid, $rideId);
                        $stmt->execute();
                        $cnt = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
                        $stmt->close();
                        if (intval($cnt) === 0) {
                            $result = $conn->query("SELECT COALESCE(MAX(ride_pos_id),0)+1 AS next_id FROM ride_pos");
                            $nextRidePosId = $result->fetch_assoc()['next_id'];
                            $stmt = $conn->prepare("INSERT INTO ride_pos (ride_pos_id, ride_pos_pos_id, ride_pos_posholder, ride_pos_ride_id) VALUES (?, ?, NULL, ?)");
                            if ($stmt) {
                                $stmt->bind_param("iii", $nextRidePosId, $pid, $rideId);
                                $stmt->execute();
                                $stmt->close();
                            }
                        }
                    }

                } else {
                    // Insert new position (determine next pos_id)
                    $result = $conn->query("SELECT COALESCE(MAX(pos_id),0)+1 AS next_id FROM position");
                    $newPosId = $result->fetch_assoc()['next_id'];
                    $stmt = $conn->prepare("INSERT INTO position (pos_id, pos_name, pos_order) VALUES (?, ?, ?)");
                    if ($stmt) {
                        $stmt->bind_param("isi", $newPosId, $pname, $porder);
                        $stmt->execute();
                        $stmt->close();

                        // Link into ride_pos
                        $result2 = $conn->query("SELECT COALESCE(MAX(ride_pos_id),0)+1 AS next_id FROM ride_pos");
                        $nextRidePosId = $result2->fetch_assoc()['next_id'];
                        $stmt = $conn->prepare("INSERT INTO ride_pos (ride_pos_id, ride_pos_pos_id, ride_pos_posholder, ride_pos_ride_id) VALUES (?, ?, NULL, ?)");
                        if ($stmt) {
                            $stmt->bind_param("iii", $nextRidePosId, $newPosId, $rideId);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                }
            }
        }

        // Handle uploaded image file (if provided)
        if (isset($_FILES['attraction_image']) && $_FILES['attraction_image']['error'] === UPLOAD_ERR_OK) {
            $upload = $_FILES['attraction_image'];
            $tmp = $upload['tmp_name'];
            $origName = basename($upload['name']);
            $mime = mime_content_type($tmp);
            $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
            if (isset($allowed[$mime])) {
                $ext = $allowed[$mime];
                $uploadDir = __DIR__ . '/../../assets/images/attractions';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                $filename = 'ride_' . $rideId . '_' . time() . '.' . $ext;
                $destPath = $uploadDir . '/' . $filename;
                if (move_uploaded_file($tmp, $destPath)) {
                    // Create web-accessible URL (adjust if your site root differs)
                    $webUrl = '/OPilot/assets/images/attractions/' . $filename;
                    $stmt = $conn->prepare("UPDATE ride SET ride_image_url = ? WHERE ride_id = ?");
                    if ($stmt) {
                        $stmt->bind_param('si', $webUrl, $rideId);
                        $stmt->execute();
                        $stmt->close();
                    }
                    $imageUrlToReturn = $webUrl;
                }
            }
        }

        $conn->commit();
        $response = ['success' => true, 'ride_id' => $rideId, 'ride_name' => $name];
        if (!empty($imageUrlToReturn)) $response['ride_image_url'] = $imageUrlToReturn;
        echo json_encode($response);
        return;

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        return;
    } finally {
        $conn->close();
    }
}

/**
 * Get zone settings (currently only lock state)
 * Expects GET: zone_id (int)
 */
function getZoneSettings() {
    $conn = getDbConnection();
    $zoneId = intval($_GET['zone_id'] ?? 1);

    // Ensure column exists in zone table (non-fatal if it doesn't)
    try {
        $res = $conn->query("SHOW COLUMNS FROM zone LIKE 'zone_lock_during_maint'");
        if ($res && $res->num_rows == 0) {
            // Add column with default 0
            $conn->query("ALTER TABLE zone ADD COLUMN zone_lock_during_maint TINYINT(1) NULL DEFAULT 0");
        }
    } catch (Exception $e) {
        // ignore schema change errors
    }

    $stmt = $conn->prepare("SELECT zone_lock_during_maint FROM zone WHERE zone_id = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'DB prepare failed']);
        $conn->close();
        return;
    }
    $stmt->bind_param('i', $zoneId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $conn->close();

    $locked = ($row && isset($row['zone_lock_during_maint'])) ? intval($row['zone_lock_during_maint']) : 0;
    echo json_encode(['success' => true, 'zone_id' => $zoneId, 'zone_lock_during_maint' => $locked]);
}

/**
 * Save zone lock state
 * Expects POST: zone_id (int), locked (0|1)
 */
function saveZoneLock() {
    $conn = getDbConnection();
    $zoneId = intval($_POST['zone_id'] ?? 1);
    $locked = intval($_POST['locked'] ?? 0);

    try {
        // Ensure column exists
        $res = $conn->query("SHOW COLUMNS FROM zone LIKE 'zone_lock_during_maint'");
        if ($res && $res->num_rows == 0) {
            $conn->query("ALTER TABLE zone ADD COLUMN zone_lock_during_maint TINYINT(1) NULL DEFAULT 0");
        }

        $stmt = $conn->prepare("UPDATE zone SET zone_lock_during_maint = ? WHERE zone_id = ?");
        if (!$stmt) throw new Exception('DB prepare failed');
        $stmt->bind_param('ii', $locked, $zoneId);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        $conn->close();

        echo json_encode(['success' => true, 'zone_id' => $zoneId, 'zone_lock_during_maint' => $locked, 'affected' => $affected]);
        return;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        $conn->close();
        return;
    }
}
?>
 