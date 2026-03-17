<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>OPilot – Zone Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../assets/css/theme.css" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<nav class="navbar">
  <div class="navbar-logo"><div class="logo-icon"></div><span class="logo-name">O<span>P</span>ilot</span></div>
  <div class="navbar-login"><input type="text" placeholder="Username" /><input type="password" placeholder="Password" /><button class="login-btn">Login</button></div>
</nav>

<div class="main">
  <aside class="sidebar">
    <div class="nav-section">
      <div class="nav-upper">
        <div class="nav-item"><a href="management.html" class="nav-link"><div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7"/></svg></div><span class="nav-text">Back</span></a></div>
      </div>
    </div>
  </aside>

  <div class="content">
    <div class="page-header">
      <div>
        <h1>Zone Management</h1>
        <div class="breadcrumb">Admin › Management › <span>Zone Management</span></div>
      </div>
      <div class="header-controls"><span class="mode-badge">Live</span></div>
    </div>

    <div class="dashboard-body" style="padding:18px;">
      <div class="zone-area">
        <div class="attraction-card" style="width:100%;">
          <div class="card-thumb" style="height:84px; background:linear-gradient(135deg,#f0c987,#e6a817);">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" style="width:44px;height:44px;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/></svg>
          </div>
          <div class="card-body">
            <div class="card-name">Zone Management</div>
            <div class="card-meta"><span>Zones & configurations</span></div>
            <div style="margin-top:8px; color:var(--text-muted); font-size:13px;">
              Create or edit zones, link attractions, set rotation and scheduling defaults for zones.
            </div>
            <div style="margin-top:12px; display:flex; gap:8px;">
              <a class="btn btn-teal" href="management.html">Back</a>
              <a class="btn btn-gray" href="#">Create Zone</a>
            </div>
          </div>
        </div>
      </div>

      <div style="margin-top:16px; color:var(--text-muted);">(Placeholder) Zone listing and configuration UI goes here.</div>
    </div>
  </div>
</div>
</body>
</html>