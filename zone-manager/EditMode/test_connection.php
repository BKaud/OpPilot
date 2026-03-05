<?php
/**
 * Database Connection Test Tool
 * Use this to verify your database connection is working
 * Access: http://localhost/OPilot/zone-manager/EditMode/test_connection.php
 */

require_once '../../DBfiles/db_config.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>OPilot - Database Connection Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #1a8f7a; margin-bottom: 20px; }
        .success { padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 4px; margin: 15px 0; }
        .error { padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 4px; margin: 15px 0; }
        .info { padding: 15px; background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; border-radius: 4px; margin: 15px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1a8f7a; color: white; }
        tr:hover { background: #f5f5f5; }
        .code { background: #f4f4f4; padding: 3px 6px; border-radius: 3px; font-family: monospace; }
        .section { margin: 30px 0; }
        .btn { background: #1a8f7a; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin: 10px 5px 10px 0; }
        .btn:hover { background: #22b09a; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔌 OPilot Database Connection Test</h1>";

// Test 1: Database Connection
echo "<div class='section'>
        <h2>1. Database Connection Test</h2>";

try {
    $conn = getDbConnection();
    echo "<div class='success'>✓ <strong>Connection Successful!</strong><br>";
    echo "Connected to database: <span class='code'>" . DB_NAME . "</span><br>";
    echo "Host: <span class='code'>" . DB_HOST . "</span><br>";
    echo "User: <span class='code'>" . DB_USER . "</span></div>";
    
    // Test 2: Check if tables exist
    echo "</div><div class='section'>
            <h2>2. Required Tables Check</h2>";
    
    $required_tables = ['zone', 'ride', 'position', 'account', 'ride_pos'];
    $existing_tables = [];
    
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_array()) {
        $existing_tables[] = $row[0];
    }
    
    echo "<table>
            <tr><th>Table Name</th><th>Status</th><th>Action</th></tr>";
    
    foreach ($required_tables as $table) {
        $exists = in_array($table, $existing_tables);
        if ($exists) {
            // Count rows in table
            $count_result = $conn->query("SELECT COUNT(*) as count FROM `$table`");
            $count = $count_result->fetch_assoc()['count'];
            echo "<tr><td><span class='code'>$table</span></td>
                      <td style='color: green;'>✓ Exists ($count rows)</td>
                      <td><a href='?view_table=$table' class='btn' style='padding: 5px 10px; font-size: 12px;'>View Data</a></td></tr>";
        } else {
            echo "<tr><td><span class='code'>$table</span></td>
                      <td style='color: red;'>✗ Missing</td>
                      <td style='color: #888;'>Needs to be created</td></tr>";
        }
    }
    echo "</table>";
    
    $missing_count = count(array_diff($required_tables, $existing_tables));
    
    if ($missing_count > 0) {
        echo "<div class='error'>⚠ <strong>$missing_count table(s) missing!</strong><br>
              You need to create these tables in your database. See the schema mapping guide below.</div>";
    } else {
        echo "<div class='success'>✓ All required tables exist!</div>";
    }
    
    // Test 3: Check table structure for attractions
    if (in_array('attractions', $existing_tables)) {
        echo "</div><div class='section'>
                <h2>3. Table Structure Check (attractions)</h2>";
        
        $columns_result = $conn->query("DESCRIBE attractions");
        $required_columns = ['attraction_id', 'zone_id', 'attraction_name', 'is_placed_on_canvas'];
        $existing_columns = [];
        
        echo "<table><tr><th>Column Name</th><th>Type</th><th>Status</th></tr>";
        
        while ($col = $columns_result->fetch_assoc()) {
            $col_name = $col['Field'];
            $existing_columns[] = $col_name;
            $is_required = in_array($col_name, $required_columns);
            $status = $is_required ? "✓ Required" : "Optional";
            $color = $is_required ? "green" : "#888";
            echo "<tr><td><span class='code'>$col_name</span></td>
                      <td>{$col['Type']}</td>
                      <td style='color: $color;'>$status</td></tr>";
        }
        echo "</table>";
        
        $missing_columns = array_diff($required_columns, $existing_columns);
        if (count($missing_columns) > 0) {
            echo "<div class='error'>⚠ Missing required columns: " . implode(', ', $missing_columns) . "</div>";
        } else {
            echo "<div class='success'>✓ All required columns exist in attractions table!</div>";
        }
    }
    
    // Test 4: Zone data test
    if (in_array('zones', $existing_tables) && in_array('attractions', $existing_tables)) {
        echo "</div><div class='section'>
                <h2>4. Sample Data Query</h2>";
        
        $zone_result = $conn->query("SELECT * FROM zones LIMIT 5");
        if ($zone_result && $zone_result->num_rows > 0) {
            echo "<h3>Zones:</h3><table><tr><th>ID</th><th>Name</th><th>Type</th></tr>";
            while ($zone = $zone_result->fetch_assoc()) {
                echo "<tr><td>{$zone['zone_id']}</td><td>{$zone['zone_name']}</td><td>" . ($zone['zone_type'] ?? 'N/A') . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='info'>ℹ No zones found in database. You'll need to add zone data.</div>";
        }
        
        $attr_result = $conn->query("SELECT * FROM attractions LIMIT 5");
        if ($attr_result && $attr_result->num_rows > 0) {
            echo "<h3>Attractions:</h3><table><tr><th>ID</th><th>Zone ID</th><th>Name</th><th>On Canvas</th></tr>";
            while ($attr = $attr_result->fetch_assoc()) {
                $on_canvas = isset($attr['is_placed_on_canvas']) ? ($attr['is_placed_on_canvas'] ? 'Yes' : 'No') : 'N/A';
                echo "<tr><td>{$attr['attraction_id']}</td><td>{$attr['zone_id']}</td><td>{$attr['attraction_name']}</td><td>$on_canvas</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='info'>ℹ No attractions found in database. You'll need to add attraction data.</div>";
        }
    }
    
    // View table data if requested
    if (isset($_GET['view_table']) && in_array($_GET['view_table'], $existing_tables)) {
        $table = $_GET['view_table'];
        echo "</div><div class='section'>
                <h2>5. Table Data: $table</h2>";
        
        $data_result = $conn->query("SELECT * FROM `$table` LIMIT 20");
        if ($data_result && $data_result->num_rows > 0) {
            echo "<table><tr>";
            $fields = $data_result->fetch_fields();
            foreach ($fields as $field) {
                echo "<th>{$field->name}</th>";
            }
            echo "</tr>";
            
            $data_result->data_seek(0);
            while ($row = $data_result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='info'>No data found in table.</div>";
        }
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<div class='error'><strong>✗ Connection Failed!</strong><br>";
    echo "Error: " . $e->getMessage() . "</div>";
    echo "<div class='info'><strong>Troubleshooting Tips:</strong><ul>
            <li>Check if XAMPP MySQL is running</li>
            <li>Verify database name in <span class='code'>db_config.php</span></li>
            <li>Check username and password</li>
            <li>Ensure the database exists in MySQL Workbench</li>
            </ul></div>";
}

echo "<div class='section'>
        <h2>Next Steps</h2>
        <div class='info'>
        <strong>Once connection is successful:</strong>
        <ol>
            <li>Review the schema mapping guide (see <span class='code'>SCHEMA_MAPPING.md</span>)</li>
            <li>Ensure your tables have the required columns</li>
            <li>Add sample data if needed</li>
            <li>Test the Edit Mode: <a href='editmode.php'>editmode.php</a></li>
        </ol>
        </div>
        <a href='test_connection.php' class='btn'>↻ Refresh Test</a>
        <a href='editmode.php' class='btn'>→ Go to Edit Mode</a>
      </div>
    </div>
</body>
</html>";
?>
