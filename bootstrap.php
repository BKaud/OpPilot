<?php
// bootstrap.php - application bootstrap (project root)
//
// Loads DB & app config from DBfiles/app_config.php when present
// Defines APP_ROOT, BASE_PATH, $currentPath, and creates $mysqli (or sets it to null on failure).

// Filesystem project root
define('APP_ROOT', __DIR__);

// Current request path for nav/active checks
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

// Try to load generated app config (created by CI/deploy)
$appConfig = APP_ROOT . '/DBfiles/app_config.php';
if (file_exists($appConfig)) {
    require_once $appConfig;
}

// Fallback defaults (safe for local dev)
if (!defined('BASE_PATH')) {
    // If your local dev serves at http://localhost/OPilot set '/OPilot', or '' if root.
    define('BASE_PATH', '/OPilot');
}
if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
if (!defined('DB_PORT')) define('DB_PORT', 3306);
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', 'password');
if (!defined('DB_NAME')) define('DB_NAME', 'oppilot');

// Create a single mysqli connection for the app (available as $mysqli)
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($mysqli && $mysqli->connect_errno) {
    // If connection fails, set $mysqli = null so downstream code can handle gracefully.
    error_log('DB connect failed: ' . $mysqli->connect_error);
    $mysqli = null;
} elseif ($mysqli) {
    $mysqli->set_charset('utf8mb4');
}

// Helper: build URLs with BASE_PATH
function url_path($path) {
    $base = rtrim(BASE_PATH, '/');
    $p = '/' . ltrim($path, '/');
    return $base . $p;
}