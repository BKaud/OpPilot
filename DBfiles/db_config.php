<?php
// Database configuration for existing OPPilot schema
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');              
define('DB_USER', 'root');             
define('DB_PASS', 'password');          
define('DB_NAME', 'oppilot');         

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
