<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OPilot – Settings</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --teal:       #1a8f7a;
      --teal-light: #22b09a;
      --teal-glow:  rgba(26,143,122,0.18);
      --bg-dark:    #1a1a1a;
      --bg-sidebar: #111111;
      --bg-panel:   #e8e8e8;
      --bg-card:    #d8d8d8;
      --bg-input:   #cecece;
      --text-main:  #f0f0f0;
      --text-muted: #888;
      --text-dark:  #222;
      --text-label: #555;
      --border:     rgba(255,255,255,0.06);
      --border-panel: #bbb;
      --accent-red: #c0392b;
      --accent-yellow: #e6a817;
      --sidebar-w:  160px;
      --nav-w:      42px;
    }

    html, body { height: 100%; overflow: hidden; }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg-dark);
      color: var(--text-main);
      display: flex;
      flex-direction: column;
    }

    /* ── NAVBAR ─────────────────────────────────────── */
    .navbar {
      height: 44px;
      background: #0d0d0d;
      border-bottom: 1px solid #2a2a2a;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 14px;
      flex-shrink: 0;
      z-index: 100;
    }
    .navbar-logo {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .logo-icon {
      width: 30px; height: 30px;
      border: 2px solid var(--teal);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      position: relative;
    }
    .logo-icon::before {
      content: '';
      width: 8px; height: 8px;
      border: 2px solid var(--teal);
      border-radius: 50%;
      position: absolute;
    }
    .logo-icon::after {
      content: '';
      width: 22px; height: 2px;
      background: var(--teal);
      position: absolute;
      transform: rotate(-45deg);
    }
    .logo-name {
      font-family: 'Rajdhani', sans-serif;
      font-size: 22px;
      font-weight: 700;
      letter-spacing: 1px;
      color: #fff;
    }
    .logo-name span { color: var(--teal); }

    .navbar-login {
      display: flex; align-items: center; gap: 6px;
    }
    .navbar-login input {
      background: #1e1e1e;
      border: 1px solid #333;
      color: #ccc;
      padding: 4px 8px;
      font-size: 12px;
      border-radius: 3px;
      width: 110px;
      outline: none;
    }
    .login-btn {
      background: var(--teal);
      color: #fff;
      border: none;
      padding: 5px 14px;
      font-size: 12px;
      font-weight: 600;
      border-radius: 3px;
      cursor: pointer;
      font-family: 'Rajdhani', sans-serif;
      letter-spacing: 0.5px;
    }
    .login-btn:hover { background: var(--teal-light); }

    /* ── MAIN LAYOUT ─────────────────────────────────── */
    .main {
      display: flex;
      flex: 1;
      overflow: hidden;
    }

    /* ── SIDEBAR ─────────────────────────────────────── */
    .sidebar {
      width: var(--nav-w);
      background: var(--bg-sidebar);
      border-right: 1px solid #2a2a2a;
      display: flex;
      flex-direction: column;
      transition: width 0.22s ease;
      overflow: hidden;
      flex-shrink: 0;
      z-index: 50;
    }
    .sidebar:hover { width: var(--sidebar-w); }

    .nav-section { display: flex; flex-direction: column; height: 100%; }
    .nav-upper { flex: 1; padding-top: 8px; }
    .nav-lower { padding-bottom: 8px; border-top: 1px solid #222; }

    .nav-item { position: relative; }
    .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 10px;
      color: #999;
      text-decoration: none;
      font-size: 12px;
      font-weight: 500;
      white-space: nowrap;
      transition: background 0.15s, color 0.15s;
      border-left: 3px solid transparent;
    }
    .nav-link:hover { background: rgba(255,255,255,0.04); color: #ddd; }
    .nav-link.active {
      background: rgba(26,143,122,0.12);
      color: var(--teal-light);
      border-left-color: var(--teal);
    }
    .nav-icon {
      width: 22px; height: 22px;
      flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
    }
    .nav-icon svg { width: 18px; height: 18px; }

    .nav-text { opacity: 0; transition: opacity 0.15s 0.05s; font-size: 12px; }
    .sidebar:hover .nav-text { opacity: 1; }

    /* sub-nav */
    .sub-nav { display: none; }
    .sub-nav.expanded { display: block; }
    .sub-nav-link, .zone-sub-link {
      display: block; padding: 7px 12px 7px 36px;
      color: #777; font-size: 11px; text-decoration: none;
      white-space: nowrap; transition: color 0.15s;
    }
    .sub-nav-link:hover, .zone-sub-link:hover { color: #ccc; }
    .zone-sub-link.active { color: var(--teal-light); }
    .zone-sub-nav { display: none; }
    .zone-sub-nav.expanded { display: block; }
    .zone-sub-link { padding-left: 48px; }

    /* ── CONTENT AREA ────────────────────────────────── */
    .content {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      background: #c8c8c8;
    }

    .page-header {
      background: #d0d0d0;
      border-bottom: 1px solid var(--border-panel);
      padding: 14px 24px 10px;
      flex-shrink: 0;
    }
    .page-header h1 {
      font-family: 'Rajdhani', sans-serif;
      font-size: 20px;
      font-weight: 700;
      color: var(--text-dark);
      letter-spacing: 0.5px;
    }
    .breadcrumb {
      font-size: 11px;
      color: var(--text-label);
      margin-top: 2px;
    }
    .breadcrumb span { color: var(--teal); }

    .settings-body {
      flex: 1;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0;
      overflow: hidden;
    }

    /* ── PANELS ──────────────────────────────────────── */
    .panel {
      border-right: 1px solid var(--border-panel);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    .panel:last-child { border-right: none; }

    .panel-title {
      font-family: 'Rajdhani', sans-serif;
      font-size: 15px;
      font-weight: 700;
      color: var(--teal);
      letter-spacing: 0.4px;
      padding: 12px 18px 8px;
      border-bottom: 1px solid var(--border-panel);
      background: #d4d4d4;
      flex-shrink: 0;
    }

    .panel-scroll {
      flex: 1;
      overflow-y: auto;
      padding: 14px 18px;
    }
    .panel-scroll::-webkit-scrollbar { width: 4px; }
    .panel-scroll::-webkit-scrollbar-thumb { background: #aaa; border-radius: 2px; }

    /* ── SECTION CARDS ───────────────────────────────── */
    .section-card {
      background: var(--bg-card);
      border: 1px solid var(--border-panel);
      border-radius: 4px;
      margin-bottom: 12px;
      overflow: hidden;
    }
    .section-card-header {
      font-family: 'Rajdhani', sans-serif;
      font-size: 13px;
      font-weight: 700;
      color: var(--text-dark);
      letter-spacing: 0.3px;
      padding: 8px 12px;
      background: #d0d0d0;
      border-bottom: 1px solid var(--border-panel);
    }
    .section-card-body { padding: 12px; }

    /* ── FORM ELEMENTS ───────────────────────────────── */
    .form-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 10px;
    }
    .form-row:last-child { margin-bottom: 0; }
    .form-col { display: flex; flex-direction: column; gap: 10px; }

    label {
      font-size: 11px;
      font-weight: 600;
      color: var(--text-label);
      letter-spacing: 0.3px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    input[type="text"],
    input[type="number"],
    input[type="time"],
    select,
    textarea {
      background: var(--bg-input);
      border: 1px solid #b0b0b0;
      color: var(--text-dark);
      padding: 5px 8px;
      font-size: 12px;
      border-radius: 3px;
      outline: none;
      font-family: 'Inter', sans-serif;
      transition: border-color 0.15s;
    }
    input:focus, select:focus, textarea:focus {
      border-color: var(--teal);
    }
    input[type="text"] { width: 100%; }
    input[type="number"] { width: 70px; }
    textarea { width: 100%; resize: vertical; min-height: 60px; }

    .input-group {
      display: flex;
      align-items: center;
      gap: 6px;
      width: 100%;
    }
    .input-group label { min-width: 120px; }
    .input-group input, .input-group select { flex: 1; }

    /* Toggle */
    .toggle-wrap {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .toggle {
      position: relative;
      width: 34px; height: 18px;
      flex-shrink: 0;
    }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
      position: absolute; inset: 0;
      background: #aaa;
      border-radius: 18px;
      cursor: pointer;
      transition: background 0.2s;
    }
    .toggle-slider::before {
      content: '';
      position: absolute;
      width: 12px; height: 12px;
      background: #fff;
      border-radius: 50%;
      left: 3px; top: 3px;
      transition: transform 0.2s;
    }
    .toggle input:checked + .toggle-slider { background: var(--teal); }
    .toggle input:checked + .toggle-slider::before { transform: translateX(16px); }
    .toggle-label { font-size: 12px; color: var(--text-dark); }

    /* Buttons */
    .btn {
      font-family: 'Rajdhani', sans-serif;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 0.4px;
      border: none;
      border-radius: 3px;
      padding: 6px 14px;
      cursor: pointer;
      transition: background 0.15s, opacity 0.15s;
    }
    .btn-teal { background: var(--teal); color: #fff; }
    .btn-teal:hover { background: var(--teal-light); }
    .btn-gray { background: #bbb; color: #333; }
    .btn-gray:hover { background: #aaa; }
    .btn-danger { background: var(--accent-red); color: #fff; }
    .btn-danger:hover { opacity: 0.85; }
    .btn-sm { padding: 4px 10px; font-size: 12px; }
    .btn-full { width: 100%; text-align: center; margin-top: 6px; }

    /* Attraction selector grid */
    .attraction-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
    }
    .attraction-thumb {
      background: #b0b0b0;
      border: 2px solid #aaa;
      border-radius: 4px;
      aspect-ratio: 16/9;
      display: flex;
      align-items: flex-end;
      justify-content: flex-end;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: border-color 0.15s;
    }
    .attraction-thumb:hover { border-color: var(--teal); }
    .attraction-thumb.selected { border-color: var(--teal); }
    .attraction-thumb .thumb-bg {
      position: absolute; inset: 0;
      background: linear-gradient(135deg, #999 0%, #777 100%);
      display: flex; align-items: center; justify-content: center;
    }
    .attraction-thumb .thumb-bg svg { width: 32px; height: 32px; opacity: 0.3; }
    .attraction-label {
      position: relative;
      background: rgba(0,0,0,0.55);
      color: #fff;
      font-size: 10px;
      font-weight: 600;
      padding: 3px 6px;
      font-family: 'Rajdhani', sans-serif;
      letter-spacing: 0.4px;
      width: 100%;
      text-align: right;
    }
    .thumb-check {
      position: absolute;
      top: 4px; left: 4px;
      width: 14px; height: 14px;
      background: var(--teal);
      border-radius: 2px;
      display: none;
      align-items: center; justify-content: center;
    }
    .thumb-check svg { width: 10px; height: 10px; }
    .attraction-thumb.selected .thumb-check { display: flex; }

    /* Position row */
    .position-row {
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      gap: 6px;
      align-items: center;
      margin-bottom: 6px;
      padding-bottom: 6px;
      border-bottom: 1px solid #c4c4c4;
    }
    .position-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .position-row input { width: 100%; }
    .position-row .divider { color: #aaa; font-size: 11px; text-align: center; }

    /* Image upload box */
    .img-upload {
      width: 72px; height: 72px;
      background: #bbb;
      border: 2px dashed #999;
      border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      flex-shrink: 0;
      transition: border-color 0.15s;
    }
    .img-upload:hover { border-color: var(--teal); }
    .img-upload svg { width: 24px; height: 24px; opacity: 0.4; }

    /* Hours row */
    .hours-row {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .hours-sep { color: #888; font-size: 13px; }

    /* Perm tiers */
    .perm-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: #c4c4c4;
      border: 1px solid #b0b0b0;
      border-radius: 3px;
      padding: 3px 8px;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-dark);
      cursor: pointer;
      transition: border-color 0.15s, background 0.15s;
    }
    .perm-badge:hover { border-color: var(--teal); }
    .perm-badge.active { background: var(--teal-glow); border-color: var(--teal); color: var(--teal); }
    .perm-row { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 4px; }

    /* Save bar */
    .save-bar {
      background: #d0d0d0;
      border-top: 1px solid var(--border-panel);
      padding: 10px 20px;
      display: flex;
      justify-content: flex-end;
      gap: 8px;
      flex-shrink: 0;
    }

    /* Divider label */
    .field-label {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--text-label);
      margin-bottom: 6px;
      margin-top: 2px;
    }

    hr.section-sep {
      border: none;
      border-top: 1px solid #c4c4c4;
      margin: 10px 0;
    }

    .inline-btn-row {
      display: flex; gap: 6px; margin-top: 6px;
    }

    /* Right panel sub-sections */
    .right-sub {
      border-top: 1px solid var(--border-panel);
      padding-top: 12px;
      margin-top: 4px;
    }
    .sub-title {
      font-family: 'Rajdhani', sans-serif;
      font-size: 14px;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 10px;
    }

    .no-select { color: #999; font-size: 12px; text-align: center; padding: 20px; }
  </style>
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
        <!-- Homepage -->
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12L12 3l9 9"/><path d="M9 21V12h6v9"/></svg>
            </div>
            <span class="nav-text">Homepage</span>
          </a>
        </div>
        <!-- Zones -->
        <div class="nav-item expandable" id="zones">
          <a href="#" class="nav-link expanded">
            <div class="nav-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            </div>
            <span class="nav-text">Zones</span>
          </a>
          <div class="sub-nav expanded" id="zones-sub">
            <div class="zone-item expandable" id="rides1-zone">
              <a href="#" class="sub-nav-link expandable">Rides 1</a>
              <div class="zone-sub-nav expanded" id="rides1-sub">
                <a href="#" class="zone-sub-link">Dashboard</a>
                <a href="#" class="zone-sub-link">Edit Mode</a>
                <a href="#" class="zone-sub-link">Config</a>
                <a href="#" class="zone-sub-link active">Settings</a>
              </div>
            </div>
            <div class="zone-item expandable" id="rides2-zone">
              <a href="#" class="sub-nav-link expandable">Rides 2</a>
              <div class="zone-sub-nav" id="rides2-sub">
                <a href="#" class="zone-sub-link">Dashboard</a>
                <a href="#" class="zone-sub-link">Edit Mode</a>
                <a href="#" class="zone-sub-link">Config</a>
                <a href="#" class="zone-sub-link">Settings</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-lower">
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            </div>
            <span class="nav-text">Account Settings</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <span class="nav-text">Changelog</span>
          </a>
        </div>
      </div>
    </div>
  </aside>

  <!-- CONTENT -->
  <div class="content">
    <div class="page-header">
      <h1>Zone Settings &amp; Configuration</h1>
      <div class="breadcrumb">Zones › Rides 1 › <span>Settings</span></div>
    </div>

    <div class="settings-body">

      <!-- ── LEFT PANEL: Zone + Attraction Selector ── -->
      <div class="panel">
        <div class="panel-title">Zone Settings &amp; Configuration</div>
        <div class="panel-scroll">

          <!-- Zone Configuration -->
          <div class="section-card">
            <div class="section-card-header">Zone Configuration</div>
            <div class="section-card-body form-col">

              <div class="input-group">
                <label>Zone Name</label>
                <input type="text" value="Rides 1" />
              </div>

              <div class="input-group">
                <label>Rotation Delay Time</label>
                <input type="number" value="15" min="1" />
                <span style="font-size:11px;color:#666">min</span>
              </div>

              <div class="input-group">
                <label>Max Operators</label>
                <input type="number" value="12" min="1" />
              </div>

              <div class="input-group">
                <label>Break Duration</label>
                <input type="number" value="15" min="5" />
                <span style="font-size:11px;color:#666">min</span>
              </div>

              <div class="toggle-wrap">
                <label class="toggle">
                  <input type="checkbox" checked />
                  <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Enable Auto-Rotation</span>
              </div>

              <div class="toggle-wrap">
                <label class="toggle">
                  <input type="checkbox" />
                  <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Lock Zone During Maintenance</span>
              </div>

            </div>
          </div>

          <!-- Attraction Edit Selector -->
          <div class="section-card">
            <div class="section-card-header">Attraction Edit Selector</div>
            <div class="section-card-body">
              <div class="field-label">Select Attraction to Configure</div>
              <div class="attraction-grid" id="attractionGrid">

                <div class="attraction-thumb selected" data-id="tidal1" onclick="selectAttraction(this, 'Tidal Twist 1')">
                  <div class="thumb-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2z"/><path d="M12 8v8M8 12h8"/></svg>
                  </div>
                  <div class="thumb-check">
                    <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2"><polyline points="1.5,5 4,7.5 8.5,2.5"/></svg>
                  </div>
                  <div class="attraction-label">Tidal Twist</div>
                </div>

                <div class="attraction-thumb" data-id="tidal2" onclick="selectAttraction(this, 'Tidal Twist 2')">
                  <div class="thumb-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2z"/><path d="M12 8v8M8 12h8"/></svg>
                  </div>
                  <div class="thumb-check">
                    <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2"><polyline points="1.5,5 4,7.5 8.5,2.5"/></svg>
                  </div>
                  <div class="attraction-label">Tidal Twist</div>
                </div>

                <div class="attraction-thumb" data-id="coaster1" onclick="selectAttraction(this, 'Space Coaster')">
                  <div class="thumb-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 17l5-10 4 6 3-4 6 8"/></svg>
                  </div>
                  <div class="thumb-check">
                    <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2"><polyline points="1.5,5 4,7.5 8.5,2.5"/></svg>
                  </div>
                  <div class="attraction-label">Space Coaster</div>
                </div>

                <div class="attraction-thumb" data-id="cars1" onclick="selectAttraction(this, 'Bumper Cars')">
                  <div class="thumb-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="9" width="20" height="8" rx="2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
                  </div>
                  <div class="thumb-check">
                    <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2"><polyline points="1.5,5 4,7.5 8.5,2.5"/></svg>
                  </div>
                  <div class="attraction-label">Bumper Cars</div>
                </div>

                <div class="attraction-thumb" data-id="carousel1" onclick="selectAttraction(this, 'Carousel')">
                  <div class="thumb-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg>
                  </div>
                  <div class="thumb-check">
                    <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2"><polyline points="1.5,5 4,7.5 8.5,2.5"/></svg>
                  </div>
                  <div class="attraction-label">Carousel</div>
                </div>

                <div class="attraction-thumb" data-id="drop1" onclick="selectAttraction(this, 'Drop Tower')">
                  <div class="thumb-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="12" y1="2" x2="12" y2="22"/><polyline points="7,17 12,22 17,17"/></svg>
                  </div>
                  <div class="thumb-check">
                    <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2"><polyline points="1.5,5 4,7.5 8.5,2.5"/></svg>
                  </div>
                  <div class="attraction-label">Drop Tower</div>
                </div>

                <div class="attraction-thumb" data-id="thunder1" onclick="selectAttraction(this, 'Thunder Mountain')">
                  <div class="thumb-bg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                  </div>
                  <div class="thumb-check">
                    <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2"><polyline points="1.5,5 4,7.5 8.5,2.5"/></svg>
                  </div>
                  <div class="attraction-label">Thunder Mountain</div>
                </div>

                <div class="attraction-thumb" data-id="add" onclick="addAttraction()">
                  <div class="thumb-bg" style="background: linear-gradient(135deg, #b0b0b0, #a0a0a0);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  </div>
                  <div class="attraction-label">Add New</div>
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- ── RIGHT PANEL: Attraction + Position Settings ── -->
      <div class="panel">
        <div class="panel-title">Attraction Settings &amp; Configuration</div>
        <div class="panel-scroll">

          <!-- Attraction Configuration -->
          <div class="section-card">
            <div class="section-card-header">Attraction Configuration</div>
            <div class="section-card-body">
              <div class="form-row" style="align-items:flex-start; gap:12px;">
                <div class="img-upload" title="Upload attraction image">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
                </div>
                <div class="form-col" style="flex:1;">
                  <div class="field-label">Attraction Name</div>
                  <div style="display:flex;gap:6px;">
                    <input type="text" id="attractionName" value="Tidal Twist 1" style="flex:1;" />
                    <button class="btn btn-gray btn-sm">Edit Name</button>
                  </div>
                  <div style="display:flex;gap:6px;margin-top:4px;">
                    <input type="text" placeholder="Link to other ride…" style="flex:1;" />
                    <button class="btn btn-gray btn-sm">Link Ride</button>
                  </div>
                </div>
              </div>

              <hr class="section-sep" />

              <!-- Attraction Settings -->
              <div class="sub-title">Attraction Settings</div>

              <div class="input-group" style="margin-bottom:8px;">
                <label>Status</label>
                <select>
                  <option>Operational</option>
                  <option>Maintenance</option>
                  <option>Closed</option>
                  <option>Seasonal</option>
                </select>
              </div>

              <div class="field-label">Operation Hours</div>
              <div class="hours-row" style="margin-bottom:10px;">
                <input type="time" value="09:00" />
                <span class="hours-sep">–</span>
                <input type="time" value="20:00" />
              </div>

              <div class="toggle-wrap" style="margin-bottom:6px;">
                <label class="toggle">
                  <input type="checkbox" checked />
                  <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Included in Rotation</span>
              </div>
              <div class="toggle-wrap">
                <label class="toggle">
                  <input type="checkbox" />
                  <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Requires Certification</span>
              </div>
            </div>
          </div>

          <!-- Position Settings -->
          <div class="section-card">
            <div class="section-card-header">Position Settings</div>
            <div class="section-card-body">

              <div class="field-label">Positions &amp; Permission Tiers</div>

              <!-- Position rows -->
              <div id="positionList">

                <div class="position-row">
                  <input type="text" placeholder="Position Name" value="Station 1" />
                  <div class="divider">→</div>
                  <input type="text" placeholder="Edit Position Name" />
                </div>

                <div class="position-row">
                  <input type="text" placeholder="Position Name" value="Station 2" />
                  <div class="divider">→</div>
                  <input type="text" placeholder="Edit Position Name" />
                </div>

                <div class="position-row">
                  <input type="text" placeholder="Position Name" value="Load Platform" />
                  <div class="divider">→</div>
                  <input type="text" placeholder="Edit Position Name" />
                </div>

                <div class="position-row">
                  <input type="text" placeholder="Position Name" value="Control Booth" />
                  <div class="divider">→</div>
                  <input type="text" placeholder="Edit Position Name" />
                </div>

              </div>

              <div class="inline-btn-row">
                <button class="btn btn-gray btn-sm" onclick="addPosition()">+ Add Position</button>
                <button class="btn btn-danger btn-sm" onclick="removePosition()">– Remove</button>
              </div>

              <hr class="section-sep" />

              <div class="field-label">Permission Tier</div>
              <div class="perm-row">
                <span class="perm-badge active" onclick="togglePerm(this)">Tier 1</span>
                <span class="perm-badge" onclick="togglePerm(this)">Tier 2</span>
                <span class="perm-badge" onclick="togglePerm(this)">Tier 3</span>
                <span class="perm-badge" onclick="togglePerm(this)">Lead</span>
                <span class="perm-badge" onclick="togglePerm(this)">Supervisor</span>
              </div>

              <hr class="section-sep" />

              <div class="field-label">Main Position</div>
              <select style="width:100%;">
                <option>Station 1</option>
                <option>Station 2</option>
                <option>Load Platform</option>
                <option>Control Booth</option>
              </select>

              <div class="field-label" style="margin-top:10px;">Required Certifications</div>
              <textarea placeholder="List required certifications or notes…">Basic Safety, Ride Op Level 1</textarea>

            </div>
          </div>

        </div>

        <!-- Save bar -->
        <div class="save-bar">
          <button class="btn btn-danger">Discard Changes</button>
          <button class="btn btn-gray">Reset Defaults</button>
          <button class="btn btn-teal">Save Settings</button>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  // Sidebar expand on hover
  const sidebar = document.querySelector('.sidebar');
  sidebar.addEventListener('mouseenter', () => {
    document.querySelectorAll('.nav-text').forEach(t => t.style.opacity = '1');
  });
  sidebar.addEventListener('mouseleave', () => {
    document.querySelectorAll('.nav-text').forEach(t => t.style.opacity = '0');
  });

  // Zone expand/collapse
  document.getElementById('zones').querySelector('.nav-link').addEventListener('click', (e) => {
    e.preventDefault();
    const sub = document.getElementById('zones-sub');
    sub.classList.toggle('expanded');
  });

  document.querySelectorAll('.zone-item').forEach(item => {
    item.querySelector('.sub-nav-link').addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      const sub = item.querySelector('.zone-sub-nav');
      sub.classList.toggle('expanded');
    });
  });

  // Attraction selector
  function selectAttraction(el, name) {
    if (el.dataset.id === 'add') return;
    document.querySelectorAll('.attraction-thumb').forEach(t => t.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('attractionName').value = name;
  }

  function addAttraction() {
    alert('Add new attraction dialog would open here.');
  }

  // Position management
  let posCount = 4;
  function addPosition() {
    posCount++;
    const list = document.getElementById('positionList');
    const row = document.createElement('div');
    row.className = 'position-row';
    row.innerHTML = `
      <input type="text" placeholder="Position Name" value="Position ${posCount}" />
      <div class="divider">→</div>
      <input type="text" placeholder="Edit Position Name" />
    `;
    list.appendChild(row);
  }

  function removePosition() {
    const list = document.getElementById('positionList');
    if (list.children.length > 1) {
      list.removeChild(list.lastChild);
      posCount--;
    }
  }

  // Permission tier toggle
  function togglePerm(el) {
    el.classList.toggle('active');
  }
</script>
</body>
</html>
