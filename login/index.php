<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Organization ID</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
  <link rel="stylesheet" href="login.css" />
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <h2>Enter Organization ID</h2>
      <form method="post" action="login.php">
        <input type="text" name="org_id" placeholder="Organization ID" required autofocus />
        <button type="submit">Next</button>
      </form>
    </div>
  </div>
</body>
</html>
