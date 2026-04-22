<?php
// DBfiles/db_config_debug.php
// Small local-only debug endpoint to verify DB config source and connectivity.

@set_time_limit(10);
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
    'environment' => defined('DB_CONFIG_SOURCE') ? DB_CONFIG_SOURCE : 'unknown',
    'config_source' => defined('DB_CONFIG_SOURCE') ? DB_CONFIG_SOURCE : 'unknown',
    'db_host' => defined('DB_HOST') ? DB_HOST : null,
    'db_port' => defined('DB_PORT') ? (int)DB_PORT : null,
    'db_name' => defined('DB_NAME') ? DB_NAME : null,
    'server_addr' => $_SERVER['SERVER_ADDR'] ?? $_SERVER['LOCAL_ADDR'] ?? 'unknown',
    'http_host' => $_SERVER['HTTP_HOST'] ?? 'unknown',
    'timestamp' => date('c')
];

// Connection test runs by default. Use ?test=0 to skip.
$runTest = !isset($_GET['test']) || $_GET['test'] !== '0';
if ($runTest) {
    $connectTimeout = 10;
    $start = microtime(true);
    $conn = null;
    $connectError = null;

    try {
        $conn = mysqli_init();
        if ($conn) {
            $conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, $connectTimeout);
            $conn->real_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);
        }
    } catch (Throwable $e) {
        $connectError = $e->getMessage();
    }

    $connected = $conn instanceof mysqli && !$conn->connect_error;
    $elapsedMs = (int)round((microtime(true) - $start) * 1000);

    $response['connection_test'] = [
        'attempted' => true,
        'timeout_seconds' => $connectTimeout,
        'connected' => $connected,
        'elapsed_ms' => $elapsedMs,
        'error' => $connected
            ? null
            : ($connectError !== null ? $connectError : (($conn && $conn->connect_error) ? $conn->connect_error : 'Unknown connection error'))
    ];

    if ($conn instanceof mysqli) {
        $conn->close();
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
