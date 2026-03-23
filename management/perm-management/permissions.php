<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>OPilot – Permissions</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../assets/css/theme.css" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<!-- NAVBAR -->
<nav class="navbar">
  <div class="navbar-logo">
    <div class="logo-icon"></div>
    <span class="logo-name">O<span>P</span>ilot</span>
  </div>
  <div class="navbar-login">
    <input type="text" placeholder="Username" />
    <input type="password" placeholder="Password" />
    <button class="login-btn">Login</button>
  </div>
</nav>

<div class="main">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="nav-section">
      <div class="nav-upper">
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon">
              <!-- home.svg inline for color control -->
              <img class="filter-999" width="22" height="22" src="../../assets/images/icons/home.svg" alt="Home Icon">
            </div>
            <span class="nav-text">Homepage</span>
          </a>
        </div>
        <div class="nav-item expandable" id="zones">
          <a href="#" class="nav-link" id="zones-toggle">
            <div class="nav-icon">
              <!-- zones.svg -->
              <img class="filter-999" width="22" height="22" src="../../assets/images/icons/zones.svg" alt="Zones Icon">
            </div>
            <span class="nav-text">Zones</span>
          </a>
          <div class="sub-nav expanded" id="zones-sub">
            <!-- Zone Dashboard section -->
            <div class="zone-item" id="rides1-zone">
              <a href="#" class="sub-nav-link" >Zones Dashboard</a>
            </div>
            <div class="zone-item expandable" id="rides1-zone">
              <a href="#" class="sub-nav-link expandable">Rides 1</a>
              <div class="zone-sub-nav expanded" id="rides1-sub">
                <a href="dashboard.php" class="zone-sub-link active">Dashboard</a>
                <a href="../EditMode/editmode.php" class="zone-sub-link">Edit Mode</a>
                <a href="../confignsettings/settings.php" class="zone-sub-link">Settings & Config</a>
              </div>
            </div>
            <div class="zone-item expandable" id="rides2-zone">
              <a href="#" class="sub-nav-link expandable">Rides 2</a>
              <div class="zone-sub-nav" id="rides2-sub">
                <a href="#" class="zone-sub-link">Dashboard</a>
                <a href="#" class="zone-sub-link">Edit Mode</a>
                <a href="#" class="zone-sub-link">Settings & Config</a>
              </div>
            </div>
          </div>
        </div>
        <div class="nav-item">
          <a href="../../management/management-dashboard/management-dashboard.php" class="nav-link">
            <div class="nav-icon">
              <!-- manage.svg -->
              <img class="filter-999" width="22" height="22" src="../../assets/images/icons/manage.svg" alt="Manage Icon">
            </div>
            <span class="nav-text">Management</span>
          </a>
        </div>
      </div>
      <div class="nav-lower">
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon">
              <!-- acc.svg -->
              <img class="filter-999" width="19" height="19" src="../../assets/images/icons/acc.svg" alt="Account Icon">
            </div>
            <span class="nav-text">Account Settings</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon">
              <!-- changelog.svg -->
              <img class="filter-999" width="22" height="22" src="../../assets/images/icons/changelog.svg" alt="Changelog Icon">
            </div>
            <span class="nav-text">Changelog</span>
          </a>
        </div>
      </div>
    </div>
  </aside>


  <div class="content">
    <div class="page-header">
      <div>
        <h1>Permissions</h1>
        <div class="breadcrumb">Admin › Management › <span>Permissions</span></div>
      </div>
      <div class="header-controls">
        <span class="mode-badge">Live</span>
      </div>
    </div>

    <div class="dashboard-body" style="padding:18px;">
      <div class="zone-area">
        <div class="attraction-card" style="width:100%; min-width:auto;">
          <div class="card-thumb" style="height:84px; background:linear-gradient(135deg,#6fb4a3,#1a8f7a);">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" style="width:44px;height:44px;"><path d="M12 2a4 4 0 014 4v2a4 4 0 01-8 0V6a4 4 0 014-4z"/><path d="M6 20v-2a6 6 0 0112 0v2"/></svg>
          </div>
          <div class="card-body">
            <div class="card-name">Permissions</div>
            <div class="card-meta"><span>Overview & management</span></div>
            <div style="margin-top:8px; color:var(--text-muted); font-size:13px;">
              This page will list individual permissions that can be granted to users or tiers. Add, edit, or remove permissions here.
            </div>

            <div style="margin-top:12px; display:flex; gap:8px;">
              <a class="btn btn-teal" href="management.html">Back</a>
              <a class="btn btn-gray" href="#">Create Permission</a>
            </div>
          </div>
        </div>
      </div>

      <div style="height:20px;"></div>
      <div style="color:var(--text-muted); font-size:13px;">
        (Placeholder) Replace with a table or form to manage permission records.
      </div>
    </div>
  </div>
</div>
<script>
// Sidebar expand/collapse for ride zones
document.addEventListener('DOMContentLoaded', function() {
  var zonesToggle = document.getElementById('zones-toggle');
  if (zonesToggle) {
    zonesToggle.addEventListener('click', function(e) {
      e.preventDefault();
      var zonesSub = document.getElementById('zones-sub');
      if (zonesSub) zonesSub.classList.toggle('expanded');
    });
  }
  document.querySelectorAll('.zone-item').forEach(function(item) {
    var subNavLink = item.querySelector('.sub-nav-link');
    var zoneSubNav = item.querySelector('.zone-sub-nav');
    if (subNavLink && zoneSubNav) {
      subNavLink.addEventListener('click', function(e) {
        e.preventDefault(); e.stopPropagation();
        zoneSubNav.classList.toggle('expanded');
      });
    }
  });

  // Sidebar icon color logic
  document.querySelectorAll('.nav-link').forEach(function(link) {
    link.addEventListener('click', function(e) {
      document.querySelectorAll('.nav-link').forEach(function(n) {
        n.classList.remove('active');
      });
      link.classList.add('active');
    });
  });
});
</script>
</body>
</html>