<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>OPilot – Zone Dashboard</title>
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
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12L12 3l9 9"/><path d="M9 21V12h6v9"/></svg></div>
            <span class="nav-text">Homepage</span>
          </a>
        </div>
        <div class="nav-item expandable" id="zones">
          <a href="#" class="nav-link" id="zones-toggle">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg></div>
            <span class="nav-text">Zones</span>
          </a>
          <div class="sub-nav expanded" id="zones-sub">
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

  <!-- CONTENT -->
  <div class="content">
    <div class="page-header">
      <div>
        <h1>Zone Dashboard</h1>
        <div class="breadcrumb">Zones › Rides 1 › <span>Dashboard</span></div>
      </div>
      <div class="header-controls">
        <span class="mode-badge" id="modeBadge">Live</span>
        <button class="btn btn-gray btn-sm" onclick="togglePreviewMode()">Preview Mode</button>
        <button class="btn btn-teal btn-sm">Rotate Now</button>
      </div>
    </div>

    <div class="dashboard-body">

      <!-- ZONE GRID -->
      <div class="zone-area">
        <div class="time-strip">
          <div>
            <div class="time-now" id="timeNow">10:32 AM <span id="timeNote">LIVE</span></div>
            <div class="breadcrumb" style="font-size:10px;">Next rotation in <strong id="rotCountdown">12:44</strong></div>
          </div>
          <div class="time-preview-tag" id="previewTag">⚡ PREVIEW MODE</div>
        </div>

        <!-- Section: Rotation Concepts -->
        <div class="attraction-section">
          <div class="section-label">Rotation Display Ideas</div>
          <div class="attraction-row" id="rotationRow">
            
            <!-- CONCEPT 1: Circular Position Wheel -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #2a9d7f, #1a6f5a); position: relative;">
                <div class="card-status-dot"></div>
                <svg viewBox="0 0 80 80" style="width: 50px; height: 50px; opacity: 0.9;" fill="none" stroke="#fff" stroke-width="1.5">
                  <circle cx="40" cy="40" r="35" />
                  <circle cx="40" cy="40" r="20" />
                  <!-- Position markers -->
                  <circle cx="40" cy="12" r="3" fill="#fff"/>
                  <circle cx="62" cy="40" r="3" fill="#26c9a0"/>
                  <circle cx="40" cy="68" r="3" fill="#fff"/>
                  <circle cx="18" cy="40" r="3" fill="#fff"/>
                  <!-- Pointer -->
                  <line x1="40" y1="40" x2="62" y2="40" stroke="#26c9a0" stroke-width="2"/>
                </svg>
                <div class="card-num">D</div>
              </div>
              <div class="card-body">
                <div class="card-name">Thunder Mountain</div>
                <div class="card-meta"><span>11:00 AM • ROTATION D</span></div>
                <div class="card-positions">
                  <span class="pos-chip assigned">M. Torres (Ride Ops)</span>
                  <span class="pos-chip assigned">D. Reyes (Dispatch)</span>
                  <span class="pos-chip assigned">L. Chen (Station)</span>
                </div>
                <div class="card-operator">Next: Rotation E at 12:00 PM</div>
              </div>
            </div>

            <!-- CONCEPT 2: Timeline Progress View -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #2a7a9d, #1a5a6f); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;">
                <div class="card-status-dot"></div>
                <div style="width: 70%; height: 24px; background: rgba(255,255,255,0.1); border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.2); position: relative;">
                  <div style="height: 100%; width: 65%; background: linear-gradient(90deg, #26c9a0, #1a8f7a); transition: width 0.3s;"></div>
                  <div style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); color: #fff; font-size: 10px; font-weight: bold;">65%</div>
                </div>
                <div class="card-num" style="font-size: 16px; opacity: 0.8;">D</div>
              </div>
              <div class="card-body">
                <div class="card-name">Space Coaster</div>
                <div class="card-meta"><span>11:00 AM • Halfway through cycle</span></div>
                <div class="card-positions">
                  <span class="pos-chip assigned">J. Monroe (Lead)</span>
                  <span class="pos-chip assigned">P. Vega (Control)</span>
                  <span class="pos-chip assigned">A. Kim (Queue)</span>
                  <span class="pos-chip assigned">R. Patel (Station)</span>
                </div>
                <div class="card-operator">Started: 11:00 AM • Est. End: 11:45 AM</div>
              </div>
            </div>

            <!-- CONCEPT 3: Position Grid Layout -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #7a2a9d, #5a1a6f); display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 6px; padding: 10px;">
                <div class="card-status-dot"></div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; width: 100%; max-width: 35px;">
                  <div style="width: 14px; height: 14px; border-radius: 2px; background: #26c9a0; border: 1px solid rgba(255,255,255,0.3);"></div>
                  <div style="width: 14px; height: 14px; border-radius: 2px; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);"></div>
                  <div style="width: 14px; height: 14px; border-radius: 2px; background: #26c9a0; border: 1px solid rgba(255,255,255,0.3);"></div>
                  <div style="width: 14px; height: 14px; border-radius: 2px; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);"></div>
                </div>
                <div class="card-num" style="margin-left: 5px;">D</div>
              </div>
              <div class="card-body">
                <div class="card-name">Bumper Cars</div>
                <div class="card-meta"><span>11:00 AM • 2 of 4 Positions</span></div>
                <div class="card-positions">
                  <span class="pos-chip assigned">✓ S. Brown</span>
                  <span class="pos-chip empty">✗ C. Liu</span>
                  <span class="pos-chip assigned">✓ T. Nair</span>
                  <span class="pos-chip empty">✗ K. Wong</span>
                </div>
                <div class="card-operator">Staffing: 50% • 2 of 4 positions filled</div>
              </div>
            </div>

            <!-- CONCEPT 4: Radial Status Indicator -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #9d7a2a, #6f5a1a); display: flex; align-items: center; justify-content: center; position: relative;">
                <div class="card-status-dot"></div>
                <svg viewBox="0 0 80 80" style="width: 50px; height: 50px;" fill="none">
                  <!-- Outer ring progress -->
                  <circle cx="40" cy="40" r="32" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                  <circle cx="40" cy="40" r="32" stroke="#f59e0b" stroke-width="2" 
                          stroke-dasharray="100" stroke-dashoffset="35" stroke-linecap="round"
                          style="transform: rotate(-90deg); transform-origin: 40px 40px;"/>
                  <!-- Center text -->
                  <text x="40" y="35" text-anchor="middle" font-size="14" font-weight="bold" fill="#fff">ROT</text>
                  <text x="40" y="50" text-anchor="middle" font-size="18" font-weight="bold" fill="#f59e0b">D</text>
                </svg>
                <div class="card-num" style="opacity: 0;"></div>
              </div>
              <div class="card-body">
                <div class="card-name">Log Flume</div>
                <div class="card-meta"><span>11:00 AM • ROTATION D Active</span></div>
                <div class="card-positions">
                  <span class="pos-chip assigned">E. Martinez (Load)</span>
                  <span class="pos-chip assigned">F. Jensen (Unload)</span>
                  <span class="pos-chip assigned">G. Wang (Ops)</span>
                </div>
                <div class="card-operator">Full staffing • All positions filled</div>
              </div>
            </div>

            <!-- CONCEPT 5: Position + Station Layout -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #2a6f9d, #1a4f6f); display: flex; align-items: center; justify-content: center; position: relative;">
                <div class="card-status-dot"></div>
                <div style="text-align: center;">
                  <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: bold; letter-spacing: 0.5px;">ROTATION D</div>
                </div>
              </div>
              <div class="card-body">
                <div class="card-name">Pirate Ship</div>
                <div class="card-meta"><span>ROTATION D • 3 of 4 Positions</span></div>
                
                <!-- Position/Station Boxes - Stacked Vertical -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin: 8px 0;">
                  <!-- Station 1 -->
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.2px;">Station 1</div>
                  </div>
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 600; color: var(--teal);">H. Brown</div>
                  </div>

                  <!-- Station 2 -->
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.2px;">Station 2</div>
                  </div>
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 600; color: var(--teal);">J. Kim</div>
                  </div>

                  <!-- Station 3 -->
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.2px;">Station 3</div>
                  </div>
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 600; color: var(--teal);">M. Lee</div>
                  </div>

                  <!-- Station 4 (Empty) -->
                  <div style="background: rgba(192, 57, 43, 0.1); border: 1px solid rgba(192, 57, 43, 0.3); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 700; color: var(--accent-red); text-transform: uppercase; letter-spacing: 0.2px;">Station 4</div>
                  </div>
                  <div style="background: rgba(192, 57, 43, 0.1); border: 1px solid rgba(192, 57, 43, 0.3); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 600; color: var(--accent-red);">EMPTY</div>
                  </div>
                </div>

                <div class="card-operator" style="border-top: 1px solid #ddd; padding-top: 6px; margin-top: 6px;">Next: Rotation E at 12:00 PM</div>
              </div>
            </div>

          </div>
        </div>

        <!-- Section: Top row -->
        <div class="attraction-section">
          <div class="section-label">Active Attractions</div>
          <div class="attraction-row" id="attractionRow">
            <!-- Cards will be generated dynamically from database -->
          </div>
        </div>

        <!-- Section: Break/Offline -->
        <div class="attraction-section">
          <div class="section-label">Break Pool / Offline</div>
          <div class="attraction-row">
            <div class="attraction-card" style="opacity:0.7;">
              <div class="card-thumb" style="background:linear-gradient(135deg,#888,#666);">
                <div class="card-status-dot off"></div>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                <div class="card-num" style="opacity:0.4;">—</div>
              </div>
              <div class="card-body">
                <div class="card-name" style="color:#777;">Break Pool (3)</div>
                <div class="card-meta"><span>On break</span></div>
                <div class="card-positions">
                  <span class="pos-chip">C. Liu</span>
                  <span class="pos-chip">H. Brown</span>
                  <span class="pos-chip">T. Nair</span>
                </div>
                <div class="card-operator">Returns: 10:45</div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- RESIZE HANDLE -->
      <div id="scheduleResizeHandle" style="width: 20px; height: 50px; background: transparent; cursor: ew-resize; flex: 0 0 20px; display: flex; align-items: center; justify-content: center; border-left: 1px solid #ccc; border-right: 1px solid #ccc; z-index: 100; position: relative; user-select: none; pointer-events: auto;">
        <div style="width: 3px; height: 15px; background: #555; border-radius: 2px; box-shadow: 0 -10px 0 #555, 0 10px 0 #555; pointer-events: none;"></div>
      </div>

      <!-- SCHEDULE SIDEBAR -->
      <div class="schedule-bar" id="scheduleBar">
        <div class="schedule-header">Schedule &amp; Timeline</div>
        <div class="schedule-time-display">
          <div class="sched-clock" id="schedClock">10:32 AM</div>
          <div class="sched-label" id="schedLabelText">Current Time · Live</div>
        </div>

        <div class="timeline-wrap">
          <!-- Schedule list -->
          <div class="schedule-list" id="scheduleList">
            <div class="sched-item">
              <div class="sched-item-time">09:00 AM</div>
              <div class="sched-item-desc">Park Open · All positions fill</div>
              <div class="sched-item-badge">Rotation A</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">09:45 AM</div>
              <div class="sched-item-desc">First break wave begins</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">10:00 AM</div>
              <div class="sched-item-desc">Rotation B · Shift swap</div>
              <div class="sched-item-badge">Rotation B</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">10:15 AM</div>
              <div class="sched-item-desc">Break wave 2</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="now-line" id="nowLine"></div>
            <div class="sched-item active">
              <div class="sched-item-time">10:32 AM</div>
              <div class="sched-item-desc">Current · Rotation C active</div>
              <div class="sched-item-badge">Rotation C</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">10:45 AM</div>
              <div class="sched-item-desc">Break wave 3 · 3 operators</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">11:00 AM</div>
              <div class="sched-item-desc">Rotation D · Thunder Mtn +1</div>
              <div class="sched-item-badge">Rotation D</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">11:30 AM</div>
              <div class="sched-item-desc">Lunch wave begins</div>
              <div class="sched-item-badge warn">Lunch</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">12:00 PM</div>
              <div class="sched-item-desc">Peak ops · Rotation E</div>
              <div class="sched-item-badge">Rotation E</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">12:30 PM</div>
              <div class="sched-item-desc">Break wave 4</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">01:00 PM</div>
              <div class="sched-item-desc">Rotation F</div>
              <div class="sched-item-badge">Rotation F</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">01:45 PM</div>
              <div class="sched-item-desc">Maintenance window: Bumper Cars</div>
              <div class="sched-item-badge warn">Maint.</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">02:00 PM</div>
              <div class="sched-item-desc">Rotation G · Full staff</div>
              <div class="sched-item-badge">Rotation G</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">04:00 PM</div>
              <div class="sched-item-desc">Afternoon break wave</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">06:00 PM</div>
              <div class="sched-item-desc">Rotation H · Wind-down</div>
              <div class="sched-item-badge">Rotation H</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">08:00 PM</div>
              <div class="sched-item-desc">Park Close · Wrap</div>
              <div class="sched-item-badge">Close</div>
            </div>
          </div>

          <!-- Vertical scrubber -->
          <div class="v-scrubber" id="vScrubber" title="Drag to preview time">
            <span class="scrub-top-label">09:00</span>
            <div class="v-scrubber-track" id="scrubTrack">
              <div class="v-scrubber-dot" id="scrubDot"></div>
              <div class="v-scrubber-line" id="scrubLine"></div>
            </div>
            <span class="scrub-bot-label">20:00</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  // Initial debug log
  console.log('[Dashboard] Script loaded - beginning initialization');
  console.log('[Dashboard] About to load zone data');
  
  // Zone configuration
  const ZONE_ID = 1; // Default to Rides 1
  let zoneData = null;

  // Sidebar expand/collapse
  const sidebar = document.querySelector('.sidebar');

  document.getElementById('zones-toggle').addEventListener('click', e => {
    e.preventDefault();
    document.getElementById('zones-sub').classList.toggle('expanded');
  });
  document.querySelectorAll('.zone-item').forEach(item => {
    item.querySelector('.sub-nav-link').addEventListener('click', e => {
      e.preventDefault(); e.stopPropagation();
      item.querySelector('.zone-sub-nav').classList.toggle('expanded');
    });
  });

  // Load zone data from database on page load
  async function loadZoneData() {
    console.log('[loadZoneData] Checking for updates...');
    try {
      const response = await fetch(`../EditMode/api.php?action=getZoneData&zone_id=${ZONE_ID}`);
      const data = await response.json();
      console.log('[loadZoneData] Response received:', data);
      
      if (data.success && data.attractions) {
        // Check if data has changed
        const newDataString = JSON.stringify(data.attractions);
        const oldDataString = JSON.stringify(zoneData);
        
        if (newDataString !== oldDataString) {
          console.log('[loadZoneData] Data changed! Updating dashboard');
          zoneData = data.attractions;
          populateDashboard(zoneData);
        } else {
          console.log('[loadZoneData] No changes detected');
        }
      } else {
        console.warn('No zone data found, using sample data');
      }
    } catch (error) {
      console.error('Error loading zone data:', error);
    }
  }

  // Auto-refresh every 30 seconds
  console.log('[Dashboard] Setting up auto-refresh every 30 seconds');
  setInterval(loadZoneData, 30000);

  // Populate dashboard with real data from database
  function populateDashboard(attractions) {
    const attractionRow = document.getElementById('attractionRow');
    
    // Clear ALL existing cards completely
    attractionRow.innerHTML = '';

    // Create cards from database data
    attractions.forEach((attraction, index) => {
      if (!attraction.isPlaced) return; // Skip attractions not placed on canvas
      
      const card = document.createElement('div');
      card.className = 'attraction-card';
      
      const positionsHTML = attraction.positions.map(pos => {
        const bgClass = pos.operator ? 'teal' : 'red';
        const textColor = pos.operator ? 'var(--teal)' : 'var(--accent-red)';
        const bgColor = pos.operator ? 'var(--teal-glow)' : 'rgba(192, 57, 43, 0.1)';
        const borderColor = pos.operator ? 'var(--teal)' : 'rgba(192, 57, 43, 0.3)';
        const operatorText = pos.operator ? pos.operator : 'EMPTY';
        return `
          <div style="background: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 2px; padding: 3px 5px; text-align: center;">
            <div style="font-size: 7px; font-weight: 700; color: ${textColor}; text-transform: uppercase; letter-spacing: 0.2px;">${pos.name}</div>
          </div>
          <div style="background: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 2px; padding: 3px 5px; text-align: center;">
            <div style="font-size: 7px; font-weight: 600; color: ${textColor};">${operatorText}</div>
          </div>
        `;
      }).join('');

      const leadOperator = attraction.positions.find(p => p.name.toLowerCase().includes('control') || p.name.toLowerCase().includes('lead'));
      const leadName = leadOperator?.operator || '—';
      const posCount = attraction.positions.length;

      card.innerHTML = `
        <div class="card-thumb">
          <div class="card-status-dot"></div>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2z"/><path d="M12 8v8M8 12h8"/></svg>
          <div class="card-num">${index + 1}</div>
        </div>
        <div class="card-body">
          <div class="card-name">${attraction.name}</div>
          <div class="card-meta"><span>${posCount} positions</span><span>Tier 1</span></div>
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin: 8px 0;">
            ${positionsHTML}
          </div>
          <div class="card-operator">Lead: ${leadName}</div>
          <div class="rotation-change-preview">
            <div class="rotation-label">
              <span class="rotation-time-badge">11:00 AM</span>
              <span class="rotation-text">Rotation D</span>
            </div>
            <div class="rotation-staff">
              ${attraction.positions.map(pos => `<div class="staff-item">${pos.name}: ${pos.operator || 'TBD'}</div>`).join('')}
            </div>
          </div>
        </div>
      `;
      
      attractionRow.appendChild(card);
    });
  }

  // Load data when page loads
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadZoneData);
  } else {
    loadZoneData();
  }

  // Live clock
  function padZ(n) { return String(n).padStart(2,'0'); }
  function formatTime(d) {
    let h = d.getHours(), m = d.getMinutes();
    const ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12 || 12;
    return `${padZ(h)}:${padZ(m)} ${ampm}`;
  }

  let isPreview = false;
  let previewMinutes = 0; // offset from midnight

  function minutesFromMidnight(d) {
    return d.getHours() * 60 + d.getMinutes();
  }

  const DAY_START = 9 * 60;  // 09:00
  const DAY_END   = 20 * 60; // 20:00
  const DAY_SPAN  = DAY_END - DAY_START;

  function minutesToTimeStr(mins) {
    mins = Math.max(DAY_START, Math.min(DAY_END, mins));
    const h = Math.floor(mins / 60);
    const m = mins % 60;
    const ampm = h >= 12 ? 'PM' : 'AM';
    const h12 = h % 12 || 12;
    return `${padZ(h12)}:${padZ(m)} ${ampm}`;
  }

  function updateDisplay(mins) {
    const timeStr = minutesToTimeStr(mins);
    document.getElementById('timeNow').innerHTML =
      `${timeStr} <span id="timeNote">${isPreview ? 'PREVIEW' : 'LIVE'}</span>`;
    document.getElementById('schedClock').textContent = timeStr;
    document.getElementById('schedLabelText').textContent =
      isPreview ? 'Preview Time · Scrubbing' : 'Current Time · Live';
    document.getElementById('previewTag').classList.toggle('visible', isPreview);
    document.getElementById('modeBadge').textContent = isPreview ? 'Preview' : 'Live';
    document.getElementById('modeBadge').style.background = isPreview ? '#888' : 'var(--teal)';
  }

  function tick() {
    if (!isPreview) {
      const now = new Date();
      const mins = minutesFromMidnight(now);
      updateDisplay(mins);
      // Set scrubber position
      const pct = Math.max(0, Math.min(1, (mins - DAY_START) / DAY_SPAN));
      setScrubberPct(pct);
    }
  }

  setInterval(tick, 10000);
  tick();

  // Rotation countdown
  let countdownSecs = 764;
  setInterval(() => {
    countdownSecs--;
    if (countdownSecs < 0) countdownSecs = 900;
    const m = Math.floor(countdownSecs / 60);
    const s = countdownSecs % 60;
    const timeStr = `${padZ(m)}:${padZ(s)}`;
    document.getElementById('rotCountdown').textContent = timeStr;
  }, 1000);

  // Preview mode toggle button
  function togglePreviewMode() {
    isPreview = !isPreview;
    if (!isPreview) {
      tick();
    }
  }

  // Scrubber drag
  const scrubTrack = document.getElementById('scrubTrack');
  const scrubDot   = document.getElementById('scrubDot');
  const scrubLine  = document.getElementById('scrubLine');

  let dragging = false;

  function setScrubberPct(pct) {
    if (!scrubTrack) return; // Safety check
    pct = Math.max(0, Math.min(1, pct));
    const trackH = scrubTrack.clientHeight;
    const dotH = 14;
    const offset = pct * (trackH - dotH);
    scrubDot.style.top = offset + 'px';
    scrubLine.style.top = (offset + dotH / 2) + 'px';
    // Sync schedule list scroll
    const list = document.getElementById('scheduleList');
    list.scrollTop = pct * (list.scrollHeight - list.clientHeight);
  }

  function pctFromEvent(e) {
    if (!scrubTrack) return 0; // Safety check
    const rect = scrubTrack.getBoundingClientRect();
    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
    return (clientY - rect.top) / rect.height;
  }

  // Setup scrubber controls only if elements exist
  if (scrubDot) {
    scrubDot.addEventListener('mousedown', e => { dragging = true; e.preventDefault(); });
    document.addEventListener('mousemove', e => {
      if (!dragging) return;
      const pct = pctFromEvent(e);
      isPreview = true;
      const mins = DAY_START + pct * DAY_SPAN;
      previewMinutes = mins;
      updateDisplay(mins);
      setScrubberPct(pct);
    });
    document.addEventListener('mouseup', () => { dragging = false; });

    scrubDot.addEventListener('touchstart', e => { dragging = true; }, { passive: true });
    document.addEventListener('touchmove', e => {
      if (!dragging) return;
      const pct = pctFromEvent(e);
      isPreview = true;
      const mins = DAY_START + pct * DAY_SPAN;
      updateDisplay(mins);
      setScrubberPct(pct);
    }, { passive: true });
    document.addEventListener('touchend', () => { dragging = false; });
  }

  // Click on schedule items
  console.log('[Dashboard] About to set up schedule item clicks');
  document.querySelectorAll('.sched-item').forEach(item => {
    item.addEventListener('click', () => {
      document.querySelectorAll('.sched-item').forEach(i => i.classList.remove('active'));
      item.classList.add('active');
    });
  });
  console.log('[Dashboard] Schedule clicks done - NOW STARTING RESIZE SETUP');
  console.log('[Resize] TEST 1');
  alert('TEST ALERT - Resize code section reached!');

  // ===== RESIZE HANDLE SETUP =====
  console.log('[Resize] Resize code loaded');
  console.log('[Resize] Looking for elements...');
  
  const resizeHandle = document.getElementById('scheduleResizeHandle');
  const scheduleBar = document.getElementById('scheduleBar');
  
  console.log('[Resize] Handle element found:', !!resizeHandle);
  console.log('[Resize] Bar element found:', !!scheduleBar);
  
  if (!resizeHandle) {
    console.error('[Resize] ERROR - scheduleResizeHandle NOT FOUND!');
  }
  if (!scheduleBar) {
    console.error('[Resize] ERROR - scheduleBar NOT FOUND!');
  }
  
  if (resizeHandle && scheduleBar) {
    console.log('[Resize] *** Both elements found! Attaching event listeners...');
    
    let isResizing = false;
    let startX = 0;
    let startWidth = 0;
    
    resizeHandle.onmousedown = function(e) {
      console.log('[Resize] *** MOUSEDOWN FIRED - X:', e.clientX);
      if (e.button !== 0) return;
      
      isResizing = true;
      startX = e.clientX;
      startWidth = scheduleBar.offsetWidth;
      
      console.log('[Resize] READY TO DRAG - width:', startWidth);
      document.body.style.userSelect = 'none';
      document.body.style.cursor = 'ew-resize';
      e.preventDefault();
    };
    
    document.onmousemove = function(e) {
      if (!isResizing) return;
      
      const diff = startX - e.clientX;
      const newWidth = Math.max(150, Math.min(600, startWidth + diff));
      
      console.log('[Resize] DRAGGING - diff:', diff, 'new:', newWidth);
      scheduleBar.style.width = newWidth + 'px';
      scheduleBar.style.flex = '0 0 ' + newWidth + 'px';
    };
    
    document.onmouseup = function(e) {
      if (isResizing) {
        console.log('[Resize] MOUSEUP - Done');
        isResizing = false;
        document.body.style.userSelect = '';
        document.body.style.cursor = '';
      }
    };
    
    console.log('[Resize] Event listeners attached!');
  }

</script>
</body>
</html>