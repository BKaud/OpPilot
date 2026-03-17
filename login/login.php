<?php
session_start();

// Step 1: Handle Org ID submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['org_id'])) {
    $_SESSION['org_id'] = trim($_POST['org_id']);
    header('Location: login.php?step=2');
    exit();
}

// Step 2: Handle Username/Password submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    // TODO: Replace with real authentication logic
    $valid = ($_POST['username'] === 'admin' && $_POST['password'] === 'password');
    if ($valid) {
        $_SESSION['user'] = $_POST['username'];
        header('Location: ../zone-manager/dashboard/dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
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
