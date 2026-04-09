<?php
// DBfiles/db_config.php
// Single source of truth for DB connection values and connection helpers.

// Resolve project root from this file location.
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

// Optional deploy-generated overrides.
$appConfig = APP_ROOT . '/DBfiles/app_config.php';
if (file_exists($appConfig)) {
    require_once $appConfig;
}

// Fallback defaults for local development.
if (!defined('BASE_PATH')) define('BASE_PATH', '');
if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
if (!defined('DB_PORT')) define('DB_PORT', 3306);
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', 'password');
if (!defined('DB_NAME')) define('DB_NAME', 'oppilot');

/**
 * Create a mysqli connection using shared config constants.
 */
function getDbConnection($exitOnError = true) {
    $conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);

    if (!$conn || $conn->connect_error) {
        $msg = 'Database connection failed';
        if ($conn && $conn->connect_error) {
            $msg .= ': ' . $conn->connect_error;
        }
        if ($exitOnError) {
            http_response_code(503);
            die(json_encode([
                'success' => false,
                'error' => $msg
            ]));
        }
        return null;
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}

// Test connection function (optional - for debugging)
function testConnection() {
    try {
        $conn = getDbConnection();
        return [
            'success' => true,
            'message' => 'Database connection successful!',
            'database' => DB_NAME,
            'port' => DB_PORT
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
?>
