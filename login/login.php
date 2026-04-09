<?php
session_start();
require_once __DIR__ . '/../DBfiles/db_config.php';

// Step 1: Handle Org ID submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['org_id'])) {
    $_SESSION['org_id'] = trim($_POST['org_id']);
    header('Location: login.php?step=2');
    exit();
}

// Step 2: Handle Username/Password submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
  $orgId = isset($_SESSION['org_id']) ? (int)$_SESSION['org_id'] : 0;
  $username = trim((string)$_POST['username']);
  $password = (string)$_POST['password'];

  if ($orgId <= 0) {
    $error = 'Organization ID is missing. Please start again.';
  } else {
    $conn = getDbConnection(false);
    if (!$conn) {
      $error = 'Database unavailable. Please try again.';
    } else {
      $stmt = $conn->prepare(
        'SELECT a.account_id, a.username, a.password, a.acc_name, a.acc_permissions, COALESCE(a.acc_is_active, 1) AS acc_is_active
         FROM account a
         INNER JOIN org_acc oa ON oa.org_acc_acc_id = a.account_id
         WHERE oa.org_acc_org_id = ? AND a.username = ?
         LIMIT 1'
      );

      if (!$stmt) {
        $error = 'Login unavailable right now.';
      } else {
        $stmt->bind_param('is', $orgId, $username);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $valid = false;
        if ($row) {
          $stored = (string)($row['password'] ?? '');
          $valid = ($stored !== '') && (
            password_verify($password, $stored) ||
            hash_equals($stored, $password)
          );

          // Upgrade old plain-text passwords to a hash on successful login.
          if ($valid && !password_get_info($stored)['algo']) {
            $rehash = password_hash($password, PASSWORD_DEFAULT);
            $up = $conn->prepare('UPDATE account SET password = ? WHERE account_id = ?');
            if ($up) {
              $accId = (int)$row['account_id'];
              $up->bind_param('si', $rehash, $accId);
              $up->execute();
              $up->close();
            }
          }
        }

        if ($row && $valid && (int)$row['acc_is_active'] === 1) {
          $_SESSION['user'] = (string)$row['username'];
          $_SESSION['org_id'] = $orgId;
          $_SESSION['perm_group'] = $row['acc_permissions'] ?? '—';
          header('Location: ../zone-manager/dashboard/dashboard.php');
          $conn->close();
          exit();
        }

        if ($row && (int)$row['acc_is_active'] !== 1) {
          $error = 'Your account is inactive. Contact an administrator.';
        } else {
          $error = 'Invalid username or password.';
        }
      }

      $conn->close();
    }
  }
}

$step = isset($_GET['step']) && $_GET['step'] == 2 && isset($_SESSION['org_id']) ? 2 : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login<?php echo $step === 2 ? ' - User Login' : ' - Organization ID'; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
  <link rel="stylesheet" href="login.css" />
</head>
<body>
  
  <div class="login-container">
    <div class="login-card">
      <?php if ($step === 1): ?>
        <h2>Enter Organization ID</h2>
        <form method="post" action="login.php">
          <input type="text" name="org_id" placeholder="Organization ID" required autofocus />
          <button type="submit">Next</button>
        </form>
      <?php else: ?>
        <h2>Login to Dashboard</h2>
        <?php if (!empty($error)): ?>
          <div style="color: #c0392b; margin-bottom: 1rem;"> <?php echo $error; ?> </div>
        <?php endif; ?>
        <form method="post" action="login.php?step=2">
          <input type="text" name="username" placeholder="Username" required autofocus />
          <input type="password" name="password" placeholder="Password" required />
          <button type="submit">Login</button>
        </form>
        <div style="margin-top:1rem;">
          <a href="login.php" style="color: var(--teal); text-decoration: underline; font-size: 0.95em;">Change Organization ID</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
