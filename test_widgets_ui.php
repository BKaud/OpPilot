<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Navbar Widgets Test</title>
    <link rel="stylesheet" href="<?php echo url_path('assets/css/theme.css'); ?>">
    <style>
        body { font-family: 'Inter', sans-serif; padding: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
<?php
require_once __DIR__ . '/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo '<h1>⚠️ Not Logged In</h1>';
    echo '<p>Please <a href="' . url_path('login/') . '">log in</a> first.</p>';
    echo '<p>Test credentials:</p>';
    echo '<ul>';
    echo '<li><strong>Organization Code:</strong> DEMO</li>';
    echo '<li><strong>Username:</strong> admin</li>';
    echo '<li><strong>Password:</strong> password</li>';
    echo '</ul>';
    exit;
}

echo '<h1>✅ Navbar Widgets Test</h1>';
echo '<p>Logged in as: <strong>' . htmlspecialchars($_SESSION['user']) . '</strong></p>';

// Test 1: Check if navbar-widgets.php can be included
echo '<div class="test-section">';
echo '<h2>Test 1: Include navbar-widgets.php</h2>';
try {
    ob_start();
    include __DIR__ . '/partials/navbar-widgets.php';
    $output = ob_get_clean();
    if (empty($output)) {
        echo '<p class="success">✓ File included successfully (no widgets configured yet)</p>';
    } else {
        echo '<p class="success">✓ Widgets rendered:</p>';
        echo $output;
    }
} catch (Exception $e) {
    echo '<p class="error">✗ Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
echo '</div>';

// Test 2: Test navbar API - Load
echo '<div class="test-section">';
echo '<h2>Test 2: Navbar API - Load</h2>';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/OpPilot/acc-sets/navbar-api.php?action=load');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    echo '<p class="success">✓ API Load successful (HTTP 200)</p>';
    echo '<pre>' . htmlspecialchars($response) . '</pre>';
} else {
    echo '<p class="error">✗ API Load failed (HTTP ' . $httpCode . ')</p>';
    echo '<pre>' . htmlspecialchars($response) . '</pre>';
}
echo '</div>';

// Test 3: Test navbar API - Save (sample widget)
echo '<div class="test-section">';
echo '<h2>Test 3: Navbar API - Save (Test Widget)</h2>';
$testData = [
    [
        'slot_index' => 1,
        'widget_key' => 'current_user',
        'widget_config' => []
    ],
    [
        'slot_index' => 2,
        'widget_key' => 'current_time',
        'widget_config' => []
    ],
    [
        'slot_index' => 3,
        'widget_key' => 'org_name',
        'widget_config' => []
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/OpPilot/acc-sets/navbar-api.php?action=save');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    echo '<p class="success">✓ API Save successful (HTTP 200)</p>';
    echo '<pre>' . htmlspecialchars($response) . '</pre>';
    echo '<p>Saved 3 test widgets: Current User, Current Time, Organization Name</p>';
} else {
    echo '<p class="error">✗ API Save failed (HTTP ' . $httpCode . ')</p>';
    echo '<pre>' . htmlspecialchars($response) . '</pre>';
}
echo '</div>';

// Test 4: Reload and show widgets
echo '<div class="test-section">';
echo '<h2>Test 4: Reload and Display Widgets</h2>';
echo '<p><a href="' . $_SERVER['PHP_SELF'] . '">Refresh page to see saved widgets</a></p>';
echo '</div>';

// Test 5: Check database
echo '<div class="test-section">';
echo '<h2>Test 5: Database Check</h2>';
if ($mysqli) {
    $stmt = $mysqli->prepare('SELECT slot_index, widget_key FROM navbar_prefs WHERE pref_username = ?');
    if ($stmt) {
        $username = $_SESSION['user'];
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $widgets = [];
        while ($row = $result->fetch_assoc()) {
            $widgets[] = $row;
        }
        $stmt->close();
        
        if (empty($widgets)) {
            echo '<p>No widgets configured in database yet</p>';
        } else {
            echo '<p class="success">✓ Found ' . count($widgets) . ' configured widget(s):</p>';
            echo '<pre>' . htmlspecialchars(json_encode($widgets, JSON_PRETTY_PRINT)) . '</pre>';
        }
    } else {
        echo '<p class="error">✗ Failed to query database</p>';
    }
} else {
    echo '<p class="error">✗ Database connection not available</p>';
}
echo '</div>';

?>

<div style="margin-top: 40px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
    <h3>Next Steps:</h3>
    <ol>
        <li>Visit <a href="<?php echo url_path('acc-sets/account-settings.php'); ?>">Account Settings</a> to configure your widgets via UI</li>
        <li>Check your dashboard to see the widgets in action</li>
        <li>Try different widget types (ride status, zone lead, etc.)</li>
    </ol>
</div>

</body>
</html>
