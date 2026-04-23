<?php
session_start();
require_once __DIR__ . '/../DBfiles/db_config.php';

// Step 1: Handle Org Code submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['org_id'])) {
    $input = trim($_POST['org_id']);
    $conn  = getDbConnection(false);
    $orgRow = null;
    if ($conn) {
        // Try by custom org_code first
        $st = $conn->prepare('SELECT org_id, org_code FROM organization WHERE org_code = ? LIMIT 1');
        if ($st) {
            $st->bind_param('s', $input);
            $st->execute();
            $orgRow = $st->get_result()->fetch_assoc();
            $st->close();
        }

        // Fall back to numeric org_id for backwards compatibility
        if (!$orgRow && ctype_digit($input)) {
            $numId = (int)$input;
            $st = $conn->prepare('SELECT org_id, org_code FROM organization WHERE org_id = ? LIMIT 1');
            if ($st) {
                $st->bind_param('i', $numId);
                $st->execute();
                $orgRow = $st->get_result()->fetch_assoc();
                $st->close();
            }
        }
        $conn->close();
    }
    if ($orgRow) {
        $_SESSION['org_id']   = (int)$orgRow['org_id'];
        $_SESSION['org_code'] = $orgRow['org_code'] ?? ('#' . $orgRow['org_id']);
        header('Location: login.php?step=2');
    } else {
        header('Location: login.php?org_error=1');
    }
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
        'SELECT a.account_id, a.username, a.password, a.acc_name, a.acc_permissions,
          COALESCE(a.acc_is_active, 1) AS acc_is_active,
          COALESCE(a.acc_primary_color, "#1a8f7a") AS acc_primary_color
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
          $_SESSION['account_id'] = (int)$row['account_id'];
          $_SESSION['org_id'] = $orgId;
          $_SESSION['perm_group'] = $row['acc_permissions'] ?? '—';
          $_SESSION['acc_primary_color'] = (string)($row['acc_primary_color'] ?? '#1a8f7a');
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
$org_error = isset($_GET['org_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OpPilot<?php echo $step === 2 ? ' — Sign In' : ' — Organization Login'; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
  <link rel="stylesheet" href="login.css" />
</head>
<body>

<div class="login-outer">
  <div class="login-card">

    <!-- ── Header ── -->
    <div class="login-header">
      <div class="login-logo">Op<span>Pilot</span></div>
      <div class="login-step-badge">
        <?php if ($step === 1): ?>
          Step 1 of 2
        <?php else: ?>
          Step 2 of 2
        <?php endif; ?>
      </div>
    </div>

    <!-- ── Body ── -->
    <div class="login-body">

      <?php if ($step === 1): ?>

        <div class="login-icon">
          <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="3" y="13" width="24" height="15" rx="3" stroke="currentColor" stroke-width="2.2" fill="none"/>
            <path d="M9 13V9.5a6 6 0 0 1 12 0V13" stroke="currentColor" stroke-width="2.2" fill="none" stroke-linecap="round"/>
            <circle cx="15" cy="21" r="2.2" fill="currentColor"/>
          </svg>
        </div>
        <h2 class="login-title">Welcome Back</h2>
        <p class="login-sub">Enter your Organization Code to continue.</p>

        <?php if ($org_error): ?>
        <div class="login-error">
          Organization not found. Please check your code and try again.
        </div>
        <?php endif; ?>

        <form method="post" action="login.php">
          <div class="login-field">
            <label for="org_id">Organization Code</label>
            <input type="text" id="org_id" name="org_id" placeholder="e.g. EVERPK" required autofocus />
          </div>
          <button type="submit" class="btn-login">Continue &rarr;</button>
        </form>

        <div class="login-footer-link">
          New here? <a href="register.php">Register your organization</a>
        </div>

      <?php else: ?>

        <div class="login-icon">
          <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="15" cy="10" r="6.5" stroke="currentColor" stroke-width="2.2" fill="none"/>
            <path d="M3.5 26 Q7 19 15 21.5 Q23 19 26.5 26" stroke="currentColor" stroke-width="2.2" fill="none" stroke-linecap="round"/>
          </svg>
        </div>
        <h2 class="login-title">Sign In</h2>
        <p class="login-sub">Organization <strong><?php echo htmlspecialchars((string)($_SESSION['org_code'] ?? ('#' . $_SESSION['org_id']))); ?></strong></p>

        <?php if (!empty($error)): ?>
        <div class="login-error">
          <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form method="post" action="login.php?step=2">
          <div class="login-field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus />
          </div>
          <div class="login-field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required />
          </div>
          <button type="submit" class="btn-login">Sign In</button>
        </form>

        <div class="login-footer-link">
          <a href="login.php">&larr; Change Organization ID</a>
        </div>

      <?php endif; ?>

    </div>
  </div>
</div>

</body>
</html>
