<?php
// Database configuration for existing OPPilot schema
define('DB_HOST', 'localhost');
define('DB_PORT', '3305');              // Your MySQL Workbench port
define('DB_USER', 'root');              // Change if different
define('DB_PASS', 'F4Gsr6R&bkk');                  // Add password if you have one
define('DB_NAME', 'oppilot');           // Your existing database

// Create connection
function getDbConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    
    if ($conn->connect_error) {
        die(json_encode([
            'success' => false,
            'error' => 'Database connection failed: ' . $conn->connect_error
        ]));
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
