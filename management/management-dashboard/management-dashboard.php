<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OPilot – Management</title>
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
          <a href="zone_dashboard.html" class="nav-link">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12L12 3l9 9"/><path d="M9 21V12h6v9"/></svg></div>
            <span class="nav-text">Homepage</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="management.html" class="nav-link active">
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
      </div>
    </div>
  </aside>

  <!-- CONTENT -->
  <div class="content">
    <div class="page-header">
      <div>
        <h1>Management</h1>
        <div class="breadcrumb">Admin › <span>Management</span></div>
      </div>
      <div class="header-controls">
        <span class="mode-badge" id="modeBadge">Live</span>
      </div>
    </div>

    <div class="dashboard-body">
      <div class="zone-area" style="padding: 24px;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
          <div>
            <div style="font-weight:700; font-family:'Rajdhani',sans-serif; font-size:13px; color:var(--text-label)">Management Console</div>
            <div style="color:var(--text-muted); font-size:13px;">Quick access to administrative sections</div>
          </div>
        </div>

        <!-- Management grid -->
        <div class="attraction-row" style="gap:16px;">

          <a class="attraction-card" href="../perm-management/permissions.php" style="text-decoration:none;">
            <div class="card-thumb" style="background:linear-gradient(135deg,#6fb4a3,#1a8f7a);">
              <svg viewBox="0 0 24 24" fill="none" stroke="#fff"><path d="M12 2a4 4 0 014 4v2a4 4 0 01-8 0V6a4 4 0 014-4z"/><path d="M6 20v-2a6 6 0 0112 0v2"/></svg>
              <div class="card-num">P</div>
            </div>
            <div class="card-body">
              <div class="card-name">Permissions</div>
              <div class="card-meta"><span>Manage user permissions</span></div>
              <div style="margin-top:8px; font-size:11px; color:var(--text-muted)">Define who can access which features.</div>
            </div>
          </a>

          <a class="attraction-card" href="../perm-tier-management/permissions_tiers.php" style="text-decoration:none;">
            <div class="card-thumb" style="background:linear-gradient(135deg,#9ad1be,#22b09a);">
              <svg viewBox="0 0 24 24" fill="none" stroke="#fff"><path d="M12 2l3 6 6 .9-4.5 4 1 6L12 17l-5.5 2.9 1-6L3 8.9 9 8l3-6z"/></svg>
              <div class="card-num">T</div>
            </div>
            <div class="card-body">
              <div class="card-name">Permissions Tier</div>
              <div class="card-meta"><span>Tiered access groups</span></div>
              <div style="margin-top:8px; font-size:11px; color:var(--text-muted)">Create and assign permission tiers.</div>
            </div>
          </a>

          <a class="attraction-card" href="../account-management/account_management.php" style="text-decoration:none;">
            <div class="card-thumb" style="background:linear-gradient(135deg,#a3cbe6,#3aa0d6);">
              <svg viewBox="0 0 24 24" fill="none" stroke="#fff"><path d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3"/><path d="M6 11c-1.66 0-3-1.34-3-3s1.34-3 3-3"/><path d="M2 20c0-3.31 4.03-6 9-6s9 2.69 9 6"/></svg>
              <div class="card-num">A</div>
            </div>
            <div class="card-body">
              <div class="card-name">Account Management</div>
              <div class="card-meta"><span>Users and teams</span></div>
              <div style="margin-top:8px; font-size:11px; color:var(--text-muted)">Add/remove users, edit profiles.</div>
            </div>
          </a>

          <a class="attraction-card" href="../zone-management/zone_management.php" style="text-decoration:none;">
            <div class="card-thumb" style="background:linear-gradient(135deg,#f0c987,#e6a817);">
              <svg viewBox="0 0 24 24" fill="none" stroke="#fff"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/></svg>
              <div class="card-num">Z</div>
            </div>
            <div class="card-body">
              <div class="card-name">Zone Management</div>
              <div class="card-meta"><span>Zones & configurations</span></div>
              <div style="margin-top:8px; font-size:11px; color:var(--text-muted)">Create/edit zones and settings.</div>
            </div>
          </a>

          <a class="attraction-card" href="../org-management/organization_management.php" style="text-decoration:none;">
            <div class="card-thumb" style="background:linear-gradient(135deg,#cfa3d6,#9b6fb0);">
              <svg viewBox="0 0 24 24" fill="none" stroke="#fff"><path d="M3 7h18"/><path d="M5 21h14v-8H5z"/><circle cx="12" cy="4" r="2"/></svg>
              <div class="card-num">O</div>
            </div>
            <div class="card-body">
              <div class="card-name">Organization Management</div>
              <div class="card-meta"><span>Org-wide settings</span></div>
              <div style="margin-top:8px; font-size:11px; color:var(--text-muted)">Manage company-wide policies.</div>
            </div>
          </a>

        </div>

      </div>

      <!-- right schedule sidebar reused as info column -->
      <div class="schedule-bar" style="width:240px;">
        <div class="schedule-header">Admin Tips</div>
        <div class="schedule-time-display">
          <div class="sched-clock">Quick Links</div>
          <div class="sched-label">Use the tiles to access each area</div>
        </div>
        <div style="padding:12px; overflow:auto; flex:1;">
          <div style="font-size:13px; color:var(--text-muted); line-height:1.4;">
            - Permissions: grant or revoke feature access.<br>
            - Tiers: group users into roles for faster assignment.<br>
            - Accounts: reset passwords, view activity.<br>
            - Zones: configure attractions and schedules.<br>
            - Organization: billing, integrations, policies.
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  // Sidebar hover/active handled with CSS; keep small behavior for accessibility
  document.querySelectorAll('.nav-link').forEach(a => {
    a.addEventListener('click', (e) => {
      document.querySelectorAll('.nav-link').forEach(n => n.classList.remove('active'));
      a.classList.add('active');
    });
  });
</script>
</body>
</html>