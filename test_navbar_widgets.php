<?php
// Test script for navbar widgets integration
header('Content-Type: application/json');
require_once __DIR__ . '/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$response = [
    'success' => false,
    'tests' => []
];

// Test 1: Check if user is logged in
$response['tests']['session_user'] = [
    'exists' => isset($_SESSION['user']),
    'value' => $_SESSION['user'] ?? null
];

// Test 2: Check if database connection works
$response['tests']['mysqli_connection'] = [
    'connected' => isset($mysqli) && $mysqli instanceof mysqli && !$mysqli->connect_error
];

// Test 3: Check if navbar_prefs table is accessible
if (isset($mysqli) && $mysqli) {
    $result = $mysqli->query("SELECT COUNT(*) as count FROM navbar_prefs");
    if ($result) {
        $row = $result->fetch_assoc();
        $response['tests']['navbar_prefs_table'] = [
            'accessible' => true,
            'row_count' => (int)$row['count']
        ];
    } else {
        $response['tests']['navbar_prefs_table'] = [
            'accessible' => false,
            'error' => $mysqli->error
        ];
    }

    // Test 4: Check required tables for widgets
    $required_tables = ['zone', 'ride', 'organization', 'account'];
    foreach ($required_tables as $table) {
        $result = $mysqli->query("SHOW TABLES LIKE '$table'");
        $response['tests']["table_$table"] = [
            'exists' => $result && $result->num_rows > 0
        ];
    }

    // Test 5: Check if zone table has rotation columns
    $result = $mysqli->query("SHOW COLUMNS FROM zone LIKE 'zone_rotation%'");
    $rotation_cols = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rotation_cols[] = $row['Field'];
        }
    }
    $response['tests']['zone_rotation_columns'] = $rotation_cols;
}

// Test 6: Check if url_path function exists
$response['tests']['url_path_function'] = [
    'exists' => function_exists('url_path'),
    'base_path' => defined('BASE_PATH') ? BASE_PATH : null
];

// Test 7: Simulate widget API load call
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $stmt = $mysqli->prepare(
        'SELECT slot_index, widget_key, widget_config FROM navbar_prefs WHERE pref_username = ? ORDER BY slot_index'
    );
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $widgets = [];
        while ($row = $res->fetch_assoc()) {
            $widgets[] = $row;
        }
        $stmt->close();
        $response['tests']['widget_load'] = [
            'success' => true,
            'widget_count' => count($widgets),
            'widgets' => $widgets
        ];
    } else {
        $response['tests']['widget_load'] = [
            'success' => false,
            'error' => 'Failed to prepare statement'
        ];
    }
}

$response['success'] = true;
echo json_encode($response, JSON_PRETTY_PRINT);
