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

// BASE_PATH fallback for pages that use url_path() without deploy config.
if (!defined('BASE_PATH')) define('BASE_PATH', '/OPilot');

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