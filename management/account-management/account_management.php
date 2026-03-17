<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>OPilot – Account Management</title>
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
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12L12 3l9 9"/><path d="M9 21V12h6v9"/></svg></div>
            <span class="nav-text">Homepage</span>
          </a>
        </div>
        <div class="nav-item expandable" id="zones">
          <a href="#" class="nav-link" id="zones-toggle">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg></div>
            <span class="nav-text">Zones</span>
          </a>
          <div class="sub-nav" id="zones-sub">
            <div class="zone-item expandable" id="rides1-zone">
              <a href="#" class="sub-nav-link expandable">Rides 1</a>
              <div class="zone-sub-nav" id="rides1-sub">
        </div>
        <div class="nav-item">
          <a href="../management-dashboard/management-dashboard.php" class="nav-link">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg></div>
            <span class="nav-text">Management</span>
          </a>
                <a href="../../zone-manager/dashboard/dashboard.php" class="zone-sub-link">Dashboard</a>
                <a href="../../zone-manager/EditMode/editmode.php" class="zone-sub-link">Edit Mode</a>
                <a href="../../zone-manager/confignsettings/settings.php" class="zone-sub-link">Settings & Config</a>
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
          <a href="../management-dashboard/management-dashboard.php" class="nav-link active">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg></div>
            <span class="nav-text">Management</span>
          </a>
        </div>
      </div>
      <div class="nav-lower">
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
            <span class="nav-text">Account Settings</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
            <span class="nav-text">Changelog</span>
          </a>
        </div>
      </div>
    </div>
  </aside>

  <div class="content">
    <div class="page-header">
      <div>
        <h1>Account Management</h1>
        <div class="breadcrumb">Admin › Management › <span>Account Management</span></div>
      </div>
      <div class="header-controls"><span class="mode-badge">Live</span></div>
    </div>

    <div class="dashboard-body" style="padding:18px;">
      <div class="zone-area">
        <div class="attraction-card" style="width:100%;">
          <div class="card-thumb" style="height:84px; background:linear-gradient(135deg,#a3cbe6,#3aa0d6);">
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" style="width:44px;height:44px;"><path d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3"/><path d="M6 11c-1.66 0-3-1.34-3-3s1.34-3 3-3"/><path d="M2 20c0-3.31 4.03-6 9-6s9 2.69 9 6"/></svg>
          </div>
          <div class="card-body">
            <div class="card-name">Account Management</div>
            <div class="card-meta"><span>Users & teams</span></div>
            <div style="margin-top:8px; color:var(--text-muted); font-size:13px;">
              Manage user accounts: invite, disable, view activity, reset passwords and assign roles/tiers.
            </div>
            <div style="margin-top:12px; display:flex; gap:8px;">
              <a class="btn btn-teal" href="management.html">Back</a>
              <a class="btn btn-gray" href="#">Invite User</a>
            </div>
          </div>
        </div>
      </div>

      <div style="margin-top:16px; color:var(--text-muted);">(Placeholder) Replace with user table and detail views.</div>
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
});
</script>
</body>
</html>