session_start();

<?php
require_once '../DBfiles/db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $org_id = trim($_POST['org_id']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($org_id) || empty($username) || empty($password)) {
        $error = 'All fields are required.';
    } else {
        $conn = getDbConnection();
        // Check if username already exists
        $stmt = $conn->prepare('SELECT account_id FROM account WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'Username already taken.';
        } else {
            // Get next account_id
            $result = $conn->query('SELECT MAX(account_id) AS max_id FROM account');
            $row = $result->fetch_assoc();
            $next_id = $row['max_id'] ? $row['max_id'] + 1 : 1;

            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $now = date('Y-m-d H:i:s');
            $stmt = $conn->prepare('INSERT INTO account (account_id, acc_name, username, password, acc_create_date, acc_is_active) VALUES (?, ?, ?, ?, ?, 1)');
            $acc_name = $username;
            $stmt->bind_param('issss', $next_id, $acc_name, $username, $password_hash, $now);
            if ($stmt->execute()) {
              $stmt2 = $conn->prepare('INSERT INTO org_acc (org_acc_org_id, org_acc_acc_id) VALUES (?, ?)');
              $stmt2->bind_param('ii', $org_id, $next_id);
              $stmt2->execute();
              $stmt2->close();
              $_SESSION['user'] = $username;
              header('Location: ../zone-manager/dashboard/dashboard.php');
              exit();
            } else {
              $error = 'Registration failed. Please try again.';
            }
            $stmt->close();
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Account</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
  <link rel="stylesheet" href="login.css" />
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <h2>Create Account</h2>
      <?php if (!empty($error)): ?>
        <div style="color: #c0392b; margin-bottom: 1rem;"> <?php echo $error; ?> </div>
      <?php endif; ?>
      <form method="post" action="register.php">
        <input type="text" name="org_id" placeholder="Organization ID" required value="<?php echo isset($org_id) ? htmlspecialchars($org_id) : '' ?>" />
        <input type="text" name="username" placeholder="Username" required value="<?php echo isset($username) ? htmlspecialchars($username) : '' ?>" />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Register</button>
      </form>
      <div style="margin-top:1rem;">
        <a href="login.php" style="color: var(--teal); text-decoration: underline; font-size: 0.95em;">Back to Login</a>
      </div>
    </div>
  </div>
</body>
</html>
