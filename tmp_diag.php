<?php
require_once 'C:/xampp/htdocs/OpPilot/bootstrap.php';

// 1. Check what mysqli error reporting mode is currently active
// In PHP 8.2, MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT is the DEFAULT
// This means prepare() THROWS an exception instead of returning false
echo "=== MySQL error reporting mode ===\n";
// Test it:
try {
    $stmt = $mysqli->prepare('SELECT acc_job_title FROM account LIMIT 1');
    if ($stmt === false) {
        echo "prepare() returned FALSE (strict mode disabled)\n";
        $stmt = null;
    } else {
        echo "prepare() returned OBJECT (column exists or no exception)\n";
        $stmt->close();
    }
} catch (mysqli_sql_exception $e) {
    echo "prepare() THREW mysqli_sql_exception: " . $e->getMessage() . "\n";
    echo "THIS IS THE ROOT CAUSE - PHP 8.2 strict mode throws instead of returning false\n";
} catch (Throwable $e) {
    echo "prepare() threw OTHER exception: " . get_class($e) . ": " . $e->getMessage() . "\n";
}

// 2. Check current mysqli report mode value
$current = mysqli_report(MYSQLI_REPORT_OFF); // this returns the current mode and sets to OFF
echo "Current mysqli report mode was: $current\n";
mysqli_report($current); // restore

// 3. Check what display_errors is set to
echo "display_errors = " . ini_get('display_errors') . "\n";
echo "error_reporting = " . ini_get('error_reporting') . "\n";
