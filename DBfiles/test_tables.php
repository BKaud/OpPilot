<?php
// Test script to check database tables
header('Content-Type: application/json');
require_once __DIR__ . '/db_config.php';

$response = [
    'success' => false,
    'config_source' => DB_CONFIG_SOURCE ?? 'unknown',
    'db_host' => DB_HOST,
    'db_port' => DB_PORT,
    'db_name' => DB_NAME,
    'tests' => []
];

$conn = getDbConnection(false);

if (!$conn) {
    $response['error'] = 'Database connection failed';
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

$response['success'] = true;
$response['connection'] = 'OK';

// Test 1: Check if organization table exists
$result = $conn->query("SHOW TABLES LIKE 'organization'");
$response['tests']['organization_table_exists'] = $result && $result->num_rows > 0;

// Test 2: Count organizations
if ($response['tests']['organization_table_exists']) {
    $result = $conn->query("SELECT COUNT(*) as count FROM organization");
    if ($result) {
        $row = $result->fetch_assoc();
        $response['tests']['organization_count'] = (int)$row['count'];
    }
    
    // Test 3: Get sample organization
    $result = $conn->query("SELECT org_id, org_code, org_name FROM organization LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $response['tests']['sample_org'] = $result->fetch_assoc();
    }
}

// Test 4: Check if account table exists
$result = $conn->query("SHOW TABLES LIKE 'account'");
$response['tests']['account_table_exists'] = $result && $result->num_rows > 0;

// Test 5: List all tables
$result = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}
$response['tests']['all_tables'] = $tables;

$conn->close();

echo json_encode($response, JSON_PRETTY_PRINT);
