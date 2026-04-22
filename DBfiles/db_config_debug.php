<?php
// DBfiles/db_config_debug.php
// Small local-only debug endpoint to verify DB config source and connectivity.

header('Content-Type: application/json; charset=utf-8');

$remoteAddr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$isLocal = in_array($remoteAddr, ['127.0.0.1', '::1'], true);
if (!$isLocal) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'error' => 'Debug endpoint is localhost-only.'
    ], JSON_PRETTY_PRINT);
    exit;
}

require_once __DIR__ . '/db_config.php';

$response = [
    'success' => true,
    'config_source' => defined('DB_CONFIG_SOURCE') ? DB_CONFIG_SOURCE : 'unknown',
    'db_host' => defined('DB_HOST') ? DB_HOST : null,
    'db_port' => defined('DB_PORT') ? (int)DB_PORT : null,
    'db_name' => defined('DB_NAME') ? DB_NAME : null,
    'timestamp' => date('c')
];

// Optional connection check: /DBfiles/db_config_debug.php?test=1
if (isset($_GET['test']) && $_GET['test'] === '1') {
    $conn = getDbConnection(false);
    $response['connection_ok'] = $conn instanceof mysqli && !$conn->connect_error;
    if ($response['connection_ok']) {
        $conn->close();
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
