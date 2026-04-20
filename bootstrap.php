<?php
// bootstrap.php - application bootstrap (project root)
//
// Loads DB configuration through DBfiles/db_config.php and creates $mysqli.
// Defines APP_ROOT, BASE_PATH, and $currentPath.

// Filesystem project root
define('APP_ROOT', __DIR__);

// Current request path for nav/active checks
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

// Load shared DB config (which may load deploy-generated app_config.php).
require_once APP_ROOT . '/DBfiles/db_config.php';

// Fallback defaults (safe for local dev)
if (!defined('BASE_PATH')) {
    // If your local dev serves at http://localhost/OpPilot set '/OpPilot', or '' if root.
    define('BASE_PATH', '/OpPilot');
}
if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
if (!defined('DB_PORT')) define('DB_PORT', 3306);
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', 'password');
if (!defined('DB_NAME')) define('DB_NAME', 'oppilot');

// Create a single mysqli connection for the app (available as $mysqli).
$mysqli = getDbConnection(false);
if (!$mysqli) {
    // If connection fails, set $mysqli = null so downstream code can handle gracefully.
    error_log('DB connect failed in bootstrap');
}

// Helper: build URLs with BASE_PATH
function url_path($path) {
    $base = rtrim(BASE_PATH, '/');
    $p = '/' . ltrim($path, '/');
    return $base . $p;
}