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
          <a href="../../home/home.php" class="nav-link">
            <div class="nav-icon">
              <!-- home.svg inline for color control -->
              <img class="filter-999" width="22" height="22" src="../../assets/images/icons/home.svg" alt="Home Icon">
            </div>
            <span class="nav-text">Homepage</span>
          </a>
        </div>
        <div class="nav-item expandable" id="zones">
          <a href="../../zones-dash/zone-dash.php" class="nav-link" id="zones-toggle">
            <div class="nav-icon">
              <!-- zones.svg -->
              <img class="filter-999" width="22" height="22" src="../../assets/images/icons/zones.svg" alt="Zones Icon">
            </div>
            <span class="nav-text">Zones</span>
          </a>
          <div class="sub-nav expanded" id="zones-sub">
            <!-- Zone Dashboard section -->
            <div class="zone-item" id="rides1-zone">
              <a href="../../zones-dash/zone-dash.php" class="sub-nav-link" >Zones Dashboard</a>
            </div>
            <div class="zone-item expandable" id="rides1-zone">
              <a href="#" class="sub-nav-link expandable">Rides 1</a>
              <div class="zone-sub-nav expanded" id="rides1-sub">
                <a href="../dashboard/dashboard.php" class="zone-sub-link active">Dashboard</a>
                <a href="../EditMode/editmode.php" class="zone-sub-link">Edit Mode</a>
                <a href="../confignsettings/settings.php" class="zone-sub-link">Settings & Config</a>
              </div>
            </div>
            <div class="zone-item expandable" id="rides2-zone">
              <a href="#" class="sub-nav-link expandable">Rides 2</a>
              <div class="zone-sub-nav" id="rides2-sub">
                <a href="../dashboard/dashboard.php" class="zone-sub-link active">Dashboard</a>
                <a href="../EditMode/editmode.php" class="zone-sub-link">Edit Mode</a>
                <a href="../confignsettings/settings.php" class="zone-sub-link">Settings & Config</a>
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
          <a href="../../acc-sets/account-settings.php" class="nav-link">
            <div class="nav-icon">
              <!-- acc.svg -->
              <img class="filter-999" width="19" height="19" src="../../assets/images/icons/acc.svg" alt="Account Icon">
            </div>
            <span class="nav-text">Account Settings</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="../../changelog/changelog.php" class="nav-link">
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
                
                <!-- Position/Station Boxes - Full Width Stacked -->
                <div style="display: flex; flex-direction: column; gap: 6px; margin: 8px 0;">
                  <!-- Station 1 -->
                  <div style="border: 2px solid #999; border-radius: 2px; overflow: visible; display: flex; gap: 2px;">
                    <div style="flex: 1; background: transparent; border: 1px solid #bbb; border-radius: 2px; padding: 3px 5px; text-align: center;">
                      <div style="font-size: 7px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.2px;">Station 1</div>
                    </div>
                    <div style="flex: 1; background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                      <div style="font-size: 7px; font-weight: 600; color: var(--teal);">H. Brown</div>
                    </div>
                  </div>

                  <!-- Station 2 -->
                  <div style="border: 2px solid #999; border-radius: 2px; overflow: visible; display: flex; gap: 2px;">
                    <div style="flex: 1; background: transparent; border: 1px solid #bbb; border-radius: 2px; padding: 3px 5px; text-align: center;">
                      <div style="font-size: 7px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.2px;">Station 2</div>
                    </div>
                    <div style="flex: 1; background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                      <div style="font-size: 7px; font-weight: 600; color: var(--teal);">J. Kim</div>
                    </div>
                  </div>

                  <!-- Station 3 -->
                  <div style="border: 2px solid #999; border-radius: 2px; overflow: visible; display: flex; gap: 2px;">
                    <div style="flex: 1; background: transparent; border: 1px solid #bbb; border-radius: 2px; padding: 3px 5px; text-align: center;">
                      <div style="font-size: 7px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.2px;">Station 3</div>
                    </div>
                    <div style="flex: 1; background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                      <div style="font-size: 7px; font-weight: 600; color: var(--teal);">M. Lee</div>
                    </div>
                  </div>

                  <!-- Station 4 (Empty) -->
                  <div style="border: 2px solid #999; border-radius: 2px; overflow: visible; display: flex; gap: 2px;">
                    <div style="flex: 1; background: transparent; border: 1px solid #bbb; border-radius: 2px; padding: 3px 5px; text-align: center;">
                      <div style="font-size: 7px; font-weight: 700; color: var(--accent-red); text-transform: uppercase; letter-spacing: 0.2px;">Station 4</div>
                    </div>
                    <div style="flex: 1; background: rgba(192, 57, 43, 0.1); border: 1px solid rgba(192, 57, 43, 0.3); border-radius: 2px; padding: 3px 5px; text-align: center;">
                      <div style="font-size: 7px; font-weight: 600; color: var(--accent-red);">EMPTY</div>
                    </div>
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
      <div id="scheduleResizeHandle" style="width: 20px; cursor: ew-resize; flex: 0 0 20px; display: flex; align-items: center; justify-content: center; z-index: 100; position: relative; user-select: none; pointer-events: auto; background: transparent;" title="Drag to resize">|||</div>

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
            <!-- Generated by JavaScript from rotation schedule data -->
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
  
  // Realistic staff pool from database
  const staffPool = [
    'M. Torres', 'D. Reyes', 'A. Kim', 'P. Vega', 'S. Okoro', 'J. Marsh', 
    'C. Liu', 'H. Brown', 'T. Nair', 'B. Okafor', 'L. Santos', 'R. Patel', 
    'K. Nguyen', 'F. Jensen', 'W. Diaz', 'N. Abebe', 'O. Ferreira'
  ];

  // Position types for each ride
  const ridePositions = {
    'Tidal Twist': ['Station 1', 'Station 2', 'Load'],
    'Thunder Mountain': ['Station 1', 'Dispatch', 'Load'],
    'Space Coaster': ['Station 1', 'Dispatch', 'Control'],
    'Bumper Cars': ['Floor', 'Control', 'Monitor'],
    'Pirate Ship': ['Load', 'Dispatch', 'Control'],
    'Log Flume': ['Platform', 'Station 1', 'Load']
  };

  // Track staff position preferences for consistency
  let staffPreferences = {};
  
  // Store attractions globally for access by update functions
  let currentAttractions = [];

  function getAssignmentForRotation(rotIndex, positionIndex) {
    // Create a seeded random for reproducibility
    const seed = rotIndex * 1000 + positionIndex * 7;
    const pseudoRand = Math.sin(seed) * 10000;
    const normalizedRand = pseudoRand - Math.floor(pseudoRand);
    
    // ~70% chance staff stays in same position, 30% they move
    if (normalizedRand < 0.7 && staffPreferences[`rot${rotIndex}_pos${positionIndex}`]) {
      return staffPreferences[`rot${rotIndex}_pos${positionIndex}`];
    }
    
    // ~15% chance position is empty
    if (normalizedRand > 0.85 && rotIndex % 4 !== 0) {
      return '';
    }
    
    // Otherwise pick a random staff member
    const staffIndex = Math.floor(Math.sin(seed * 2.5) * staffPool.length * 10) % staffPool.length;
    const staff = staffPool[staffIndex];
    
    // Store preference for next rotation
    staffPreferences[`rot${rotIndex}_pos${positionIndex}`] = staff;
    
    return staff;
  }

  // ============================================================
  // ROTATION SCHEDULE DATA - Easy to modify for EditMode later
  // ============================================================
  const rotationSchedule = {
    // 9am-12pm: 30 min intervals with varied ride assignments
    morning: [
      { time: '09:00', label: '09:00 AM', rotation: 'A', isMini: false, assignments: [
        { position: 'Station 1', operator: 'P. Vega', ride: 'Tidal Twist' },
        { position: 'Station 2', operator: 'M. Torres', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'J. Marsh', ride: 'Tidal Twist' },
        { position: 'Station 1', operator: 'H. Brown', ride: 'Thunder Mountain' }
      ]},
      { time: '09:30', label: '09:30 AM', rotation: 'B', isMini: true, assignments: [
        { position: 'Station 1', operator: 'P. Vega', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'A. Kim', ride: 'Tidal Twist' }
      ]},
      { time: '10:00', label: '10:00 AM', rotation: 'C', isMini: false, assignments: [
        { position: 'Station 1', operator: 'K. Nguyen', ride: 'Space Coaster' },
        { position: 'Dispatch', operator: 'R. Patel', ride: 'Space Coaster' },
        { position: 'Control', operator: 'C. Liu', ride: 'Space Coaster' },
        { position: 'Floor', operator: 'N. Abebe', ride: 'Bumper Cars' },
        { position: 'Control', operator: 'W. Diaz', ride: 'Bumper Cars' },
        { position: 'Monitor', operator: 'T. Nair', ride: 'Bumper Cars' }
      ]},
      { time: '10:30', label: '10:30 AM', rotation: 'D', isMini: true, assignments: [
        { position: 'Station 1', operator: 'T. Nair', ride: 'Tidal Twist' },
        { position: 'Dispatch', operator: 'B. Okafor', ride: 'Thunder Mountain' }
      ]},
      { time: '11:00', label: '11:00 AM', rotation: 'E', isMini: false, assignments: [
        { position: 'Load', operator: 'D. Reyes', ride: 'Pirate Ship' },
        { position: 'Dispatch', operator: 'B. Okafor', ride: 'Pirate Ship' },
        { position: 'Platform', operator: 'F. Jensen', ride: 'Log Flume' },
        { position: 'Station 1', operator: 'T. Nair', ride: 'Log Flume' },
        { position: 'Station 1', operator: 'P. Vega', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'O. Ferreira', ride: 'Tidal Twist' }
      ]},
      { time: '11:30', label: '11:30 AM', rotation: 'F', isMini: true, assignments: [
        { position: 'Station 2', operator: 'W. Diaz', ride: 'Tidal Twist' },
        { position: 'Control', operator: 'K. Nguyen', ride: 'Space Coaster' }
      ]},
      { time: '12:00', label: '12:00 PM', rotation: 'G', isMini: false, assignments: [
        { position: 'Station 1', operator: 'C. Liu', ride: 'Space Coaster' },
        { position: 'Dispatch', operator: 'K. Nguyen', ride: 'Space Coaster' },
        { position: 'Control', operator: 'R. Patel', ride: 'Space Coaster' },
        { position: 'Floor', operator: 'N. Abebe', ride: 'Bumper Cars' },
        { position: 'Control', operator: 'W. Diaz', ride: 'Bumper Cars' },
        { position: 'Monitor', operator: 'S. Okoro', ride: 'Bumper Cars' }
      ]},
      { time: '12:30', label: '12:30 PM', rotation: 'H', isMini: true, assignments: [
        { position: 'Floor', operator: 'P. Vega', ride: 'Bumper Cars' },
        { position: 'Monitor', operator: 'L. Santos', ride: 'Bumper Cars' },
        { position: 'Main', operator: 'K. Nguyen', ride: 'Carousel' }
      ]}
    ],
    // 1pm-8pm: 30 min intervals with repeating pattern (same as morning)
    afternoon: [
      { time: '13:00', label: '01:00 PM', rotation: 'I', isMini: false, assignments: [
        { position: 'Station 1', operator: 'H. Brown', ride: 'Tidal Twist' },
        { position: 'Station 2', operator: 'D. Reyes', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'J. Marsh', ride: 'Tidal Twist' },
        { position: 'Station 1', operator: 'M. Torres', ride: 'Thunder Mountain' },
        { position: 'Dispatch', operator: 'B. Okafor', ride: 'Thunder Mountain' },
        { position: 'Load', operator: 'L. Santos', ride: 'Thunder Mountain' }
      ]},
      { time: '13:30', label: '01:30 PM', rotation: 'J', isMini: true, assignments: [
        { position: 'Station 1', operator: 'A. Kim', ride: 'Tidal Twist' },
        { position: 'Dispatch', operator: 'S. Okoro', ride: 'Thunder Mountain' }
      ]},
      { time: '14:00', label: '02:00 PM', rotation: 'K', isMini: false, assignments: [
        { position: 'Station 1', operator: 'H. Brown', ride: 'Thunder Mountain' },
        { position: 'Dispatch', operator: 'J. Marsh', ride: 'Thunder Mountain' },
        { position: 'Load', operator: 'D. Reyes', ride: 'Thunder Mountain' },
        { position: 'Load', operator: 'B. Okafor', ride: 'Pirate Ship' },
        { position: 'Dispatch', operator: 'L. Santos', ride: 'Pirate Ship' },
        { position: 'Platform', operator: 'F. Jensen', ride: 'Log Flume' }
      ]},
      { time: '14:30', label: '02:30 PM', rotation: 'L', isMini: true, assignments: [
        { position: 'Station 2', operator: 'W. Diaz', ride: 'Tidal Twist' },
        { position: 'Dispatch', operator: 'B. Okafor', ride: 'Thunder Mountain' }
      ]},
      { time: '15:00', label: '03:00 PM', rotation: 'M', isMini: false, assignments: [
        { position: 'Floor', operator: 'A. Kim', ride: 'Bumper Cars' },
        { position: 'Control', operator: 'S. Okoro', ride: 'Bumper Cars' },
        { position: 'Monitor', operator: 'W. Diaz', ride: 'Bumper Cars' },
        { position: 'Station 1', operator: 'M. Torres', ride: 'Tidal Twist' },
        { position: 'Station 2', operator: 'P. Vega', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'L. Santos', ride: 'Tidal Twist' }
      ]},
      { time: '15:30', label: '03:30 PM', rotation: 'N', isMini: true, assignments: [
        { position: 'Floor', operator: 'A. Kim', ride: 'Bumper Cars' },
        { position: 'Control', operator: 'S. Okoro', ride: 'Bumper Cars' }
      ]},
      { time: '16:00', label: '04:00 PM', rotation: 'O', isMini: false, assignments: [
        { position: 'Station 1', operator: 'D. Reyes', ride: 'Tidal Twist' },
        { position: 'Station 2', operator: 'J. Marsh', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'H. Brown', ride: 'Tidal Twist' },
        { position: 'Station 1', operator: 'P. Vega', ride: 'Thunder Mountain' },
        { position: 'Dispatch', operator: 'M. Torres', ride: 'Thunder Mountain' },
        { position: 'Load', operator: 'L. Santos', ride: 'Thunder Mountain' }
      ]},
      { time: '16:30', label: '04:30 PM', rotation: 'P', isMini: true, assignments: [
        { position: 'Station 2', operator: 'T. Nair', ride: 'Tidal Twist' },
        { position: 'Control', operator: 'C. Liu', ride: 'Space Coaster' }
      ]},
      { time: '17:00', label: '05:00 PM', rotation: 'Q', isMini: false, assignments: [
        { position: 'Station 1', operator: 'M. Torres', ride: 'Tidal Twist' },
        { position: 'Station 2', operator: 'P. Vega', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'L. Santos', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'S. Okoro', ride: 'Pirate Ship' },
        { position: 'Dispatch', operator: 'J. Marsh', ride: 'Pirate Ship' },
        { position: 'Platform', operator: 'O. Ferreira', ride: 'Log Flume' }
      ]},
      { time: '17:30', label: '05:30 PM', rotation: 'R', isMini: true, assignments: [
        { position: 'Station 1', operator: 'H. Brown', ride: 'Tidal Twist' },
        { position: 'Dispatch', operator: 'S. Okoro', ride: 'Thunder Mountain' }
      ]},
      { time: '18:00', label: '06:00 PM', rotation: 'S', isMini: false, assignments: [
        { position: 'Station 1', operator: 'P. Vega', ride: 'Tidal Twist' },
        { position: 'Station 2', operator: 'M. Torres', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'L. Santos', ride: 'Tidal Twist' },
        { position: 'Floor', operator: 'N. Abebe', ride: 'Bumper Cars' },
        { position: 'Control', operator: 'W. Diaz', ride: 'Bumper Cars' },
        { position: 'Monitor', operator: 'S. Okoro', ride: 'Bumper Cars' }
      ]},
      { time: '18:30', label: '06:30 PM', rotation: 'T', isMini: true, assignments: [
        { position: 'Floor', operator: 'C. Liu', ride: 'Bumper Cars' },
        { position: 'Control', operator: 'K. Nguyen', ride: 'Bumper Cars' }
      ]},
      { time: '19:00', label: '07:00 PM', rotation: 'U', isMini: false, assignments: [
        { position: 'Station 1', operator: 'J. Marsh', ride: 'Tidal Twist' },
        { position: 'Station 2', operator: 'D. Reyes', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'T. Nair', ride: 'Tidal Twist' },
        { position: 'Floor', operator: 'N. Abebe', ride: 'Bumper Cars' },
        { position: 'Control', operator: 'W. Diaz', ride: 'Bumper Cars' },
        { position: 'Monitor', operator: 'S. Okoro', ride: 'Bumper Cars' }
      ]},
      { time: '19:30', label: '07:30 PM', rotation: 'V', isMini: true, assignments: [
        { position: 'Station 1', operator: 'A. Kim', ride: 'Tidal Twist' },
        { position: 'Control', operator: 'R. Patel', ride: 'Space Coaster' }
      ]},
      { time: '20:00', label: '08:00 PM', rotation: 'W', isMini: false, assignments: [
        { position: 'Station 1', operator: 'M. Torres', ride: 'Tidal Twist' },
        { position: 'Station 2', operator: 'P. Vega', ride: 'Tidal Twist' },
        { position: 'Load', operator: 'L. Santos', ride: 'Tidal Twist' },
        { position: 'Station 1', operator: 'H. Brown', ride: 'Thunder Mountain' },
        { position: 'Dispatch', operator: 'F. Jensen', ride: 'Thunder Mountain' },
        { position: 'Load', operator: 'D. Reyes', ride: 'Thunder Mountain' }
      ]}
    ]
  };

  // Generate schedule HTML from rotation data
  function generateScheduleHTML() {
    const scheduleList = document.getElementById('scheduleList');
    if (!scheduleList) return;
    
    let html = '';
    
    // Combine morning and afternoon rotations
    const allRotations = [...rotationSchedule.morning, ...rotationSchedule.afternoon];
    
    allRotations.forEach(rotation => {
      // Check if any position is empty (no operator)
      const hasEmpty = rotation.assignments.some(a => !a.operator || a.operator.trim() === '');
      const emptyStyle = hasEmpty ? 'background: rgba(192, 57, 43, 0.15); border: 2px solid rgba(192, 57, 43, 0.4);' : '';
      
      const assignmentBoxes = rotation.assignments
        .map(a => {
          const isEmpty = !a.operator || a.operator.trim() === '';
          const opBgColor = isEmpty ? 'rgba(192, 57, 43, 0.15)' : 'var(--teal-glow)';
          const opBorderColor = isEmpty ? 'rgba(192, 57, 43, 0.4)' : 'var(--teal)';
          const opTextColor = isEmpty ? 'var(--accent-red)' : 'var(--teal)';
          const opText = isEmpty ? 'EMPTY' : a.operator;
          
          return `
          <div style="border: 2px solid #999; border-radius: 3px; overflow: visible; display: flex; gap: 2px; margin-bottom: 4px;">
            <div style="flex: 1; background: transparent; border: 1px solid #bbb; border-radius: 2px; padding: 2px 4px; text-align: center;">
              <div style="font-size: 8px; font-weight: 700; color: var(--text-dark); text-transform: uppercase; letter-spacing: 0.2px;">${a.position}</div>
            </div>
            <div style="flex: 1.2; background: ${opBgColor}; border: 1px solid ${opBorderColor}; border-radius: 2px; padding: 2px 4px; text-align: center;">
              <div style="font-size: 8px; font-weight: 600; color: ${opTextColor};">${opText}</div>
            </div>
            <div style="flex: 0.9; background: rgba(26, 143, 122, 0.08); border: 1px solid rgba(26, 143, 122, 0.3); border-radius: 2px; padding: 2px 4px; text-align: center;">
              <div style="font-size: 7px; color: var(--teal); font-weight: 600;">${a.ride}</div>
            </div>
          </div>
        `;
        })
        .join('');
      
      const rotationType = rotation.isMini ? 'mini' : 'hard';
      const badgeClass = rotation.isMini ? 'mini-rotation' : 'hard-rotation';
      
      html += `
        <div class="sched-item ${rotationType}-rotation" data-time="${rotation.time}" style="${emptyStyle}">
          <div class="sched-item-time">${rotation.label} • <strong>ROT ${rotation.rotation}</strong></div>
          <div class="rotation-assignments">
            ${assignmentBoxes}
          </div>
        </div>
      `;
    });
    
    scheduleList.innerHTML = html;
  }

  // Call this when page loads
  function initSchedule() {
    generateScheduleHTML();
    setupScheduleEventListeners();
    // Initialize with current time
    updateRotationIndicators();
  }

  // Setup event listeners for schedule items
  function setupScheduleEventListeners() {
    console.log('[Dashboard] Setting up schedule item event listeners');
    const items = document.querySelectorAll('.sched-item');
    console.log('[Dashboard] Found ' + items.length + ' schedule items');
    
    items.forEach(item => {
      item.addEventListener('click', () => {
        // Extract time from the item
        const timeStr = item.getAttribute('data-time');
        const [hours, mins] = timeStr.split(':').map(Number);
        const itemMins = hours * 60 + mins;
        
        // Set preview mode to this time
        isPreview = true;
        previewMinutes = itemMins;
        updateDisplay(itemMins);
        setScrubberPct((itemMins - DAY_START) / DAY_SPAN);
        
        // Remove active from all and add to clicked
        document.querySelectorAll('.sched-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        
        // Update rotation indicators and previews
        updateRotationIndicators();
        updateAttractionRotationPreviews();
        console.log('[Dashboard] Clicked rotation at ' + timeStr);
      });
    });
    
    // Update indicators immediately after setting up
    updateRotationIndicators();
    updateAttractionRotationPreviews();
    console.log('[Dashboard] Schedule event listeners setup complete');
  }
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
      const text = await response.text();
      console.log('[loadZoneData] Raw response:', text);
      
      let data;
      try {
        data = JSON.parse(text);
      } catch (parseError) {
        console.error('[loadZoneData] JSON Parse Error:', parseError);
        console.error('[loadZoneData] Response text:', text);
        return;
      }
      
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
    // Store attractions globally for update functions
    currentAttractions = attractions;
    
    const attractionRow = document.getElementById('attractionRow');
    
    // Clear ALL existing cards completely
    attractionRow.innerHTML = '';

    // Create cards from database data
    attractions.forEach((attraction, index) => {
      if (!attraction.isPlaced) return; // Skip attractions not placed on canvas
      
      const card = document.createElement('div');
      card.className = 'attraction-card';
      card.setAttribute('data-attraction-name', attraction.name);
      
      // Build card thumbnail with image if available
      let thumbContent = '';
      if (attraction.imageUrl) {
        thumbContent = `
          <div style="position:relative;width:100%;height:100%;">
            <img src="${attraction.imageUrl}" alt="${attraction.name}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
            <div class="card-status-dot" style="position:absolute;top:8px;right:8px;"></div>
            <div class="card-num" style="position:absolute;bottom:8px;left:8px;">${index + 1}</div>
          </div>
        `;
      } else {
        thumbContent = `
          <div class="card-status-dot"></div>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2z"/><path d="M12 8v8M8 12h8"/></svg>
          <div class="card-num">${index + 1}</div>
        `;
      }
      
      const positionsHTML = attraction.positions.map(pos => {
        const bgClass = pos.operator ? 'teal' : 'red';
        const textColor = pos.operator ? 'var(--teal)' : 'var(--accent-red)';
        const bgColor = pos.operator ? 'var(--teal-glow)' : 'rgba(192, 57, 43, 0.1)';
        const borderColor = pos.operator ? 'var(--teal)' : 'rgba(192, 57, 43, 0.3)';
        const operatorText = pos.operator ? pos.operator : 'EMPTY';
        return `
          <div style="border: 2px solid #999; border-radius: 2px; overflow: visible; display: flex; gap: 2px; width: 100%;">
            <div style="flex: 1; background: transparent; border: 1px solid #bbb; border-radius: 2px; padding: 3px 5px; text-align: center;">
              <div style="font-size: 7px; font-weight: 700; color: ${textColor}; text-transform: uppercase; letter-spacing: 0.2px;">${pos.name}</div>
            </div>
            <div style="flex: 1; background: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 2px; padding: 3px 5px; text-align: center;">
              <div style="font-size: 7px; font-weight: 600; color: ${textColor};">${operatorText}</div>
            </div>
          </div>
        `;
      }).join('');
      const positionsContainerHTML = `<div style="display: flex; flex-direction: column; gap: 6px; width: 100%;">${positionsHTML}</div>`;

      const leadOperator = attraction.positions.find(p => p.name.toLowerCase().includes('control') || p.name.toLowerCase().includes('lead'));
      const leadName = leadOperator?.operator || '—';
      const posCount = attraction.positions.length;
      const filledCount = attraction.positions.filter(p => p.operator).length;
      const positionText = `${filledCount} of ${posCount} Positions`;

      card.innerHTML = `
        <div class="card-thumb">
          ${thumbContent}
        </div>
        <div class="card-body">
          <div class="card-name">${attraction.name}</div>
          <div class="card-meta"><span>${positionText}</span><span>Tier 1</span></div>
          ${positionsContainerHTML}
          <div class="card-operator">Lead: ${leadName}</div>
          <div class="rotation-change-preview">
            <div class="rotation-label">
              <span class="rotation-time-badge">11:00 AM</span>
              <span class="rotation-text">Rotation D</span>
            </div>
            <div class="rotation-staff">
              ${attraction.positions.map(pos => {
                const operator = pos.operator || 'EMPTY';
                const bgColor = pos.operator ? 'var(--teal-glow)' : 'rgba(192, 57, 43, 0.1)';
                const borderColor = pos.operator ? 'var(--teal)' : 'rgba(192, 57, 43, 0.3)';
                const textColor = pos.operator ? 'var(--teal)' : 'var(--accent-red)';
                return `
                  <div style="border: 2px solid #999; border-radius: 3px; overflow: visible; display: flex; gap: 2px;">
                    <div style="flex: 1; background: transparent; border: 1px solid #bbb; border-radius: 2px; padding: 2px 4px; text-align: center;">
                      <div style="font-size: 8px; font-weight: 700; color: var(--text-dark); text-transform: uppercase; letter-spacing: 0.2px;">${pos.name}</div>
                    </div>
                    <div style="flex: 1; background: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 2px; padding: 2px 4px; text-align: center;">
                      <div style="font-size: 8px; font-weight: 600; color: ${textColor};">${operator}</div>
                    </div>
                  </div>
                `;
              }).join('')}
            </div>
          </div>
        </div>
      `;
      
      attractionRow.appendChild(card);
    });
    
    // Update rotation previews after all cards are created
    updateAttractionRotationPreviews();
  }

  // Get next rotation info based on current time (in minutes from midnight)
  // Optional: filter by attraction positions
  function getNextRotation(mins, attractionPositions = null) {
    const allRotations = [...rotationSchedule.morning, ...rotationSchedule.afternoon];
    
    // Filter rotations: if attractionPositions provided, only include rotations with matching assignments
    let candidateRotations = allRotations;
    if (attractionPositions && attractionPositions.length > 0) {
      candidateRotations = allRotations.filter(rot => {
        // Check if this rotation has assignments that match the attraction's position names
        return rot.assignments && rot.assignments.some(assign => 
          attractionPositions.includes(assign.position)
        );
      });
    }
    
    // Find the first rotation after current time
    const nextRot = candidateRotations.find(rot => {
      const [h, m] = rot.time.split(':').map(Number);
      const rotMins = h * 60 + m;
      return rotMins > mins;
    });
    
    // If no rotation found, wrap to first in the candidates
    return nextRot || candidateRotations[0] || allRotations[0];
  }

  // Update attraction card rotation preview sections dynamically
  function updateAttractionRotationPreviews() {
    const currentMins = isPreview ? previewMinutes : minutesFromMidnight(new Date());
    
    // Update all rotation preview sections in attraction cards
    const cards = document.querySelectorAll('.rotation-change-preview');
    cards.forEach((card) => {
      const timeBadge = card.querySelector('.rotation-time-badge');
      const rotText = card.querySelector('.rotation-text');
      
      // Get the attraction card and find the attraction data
      const attractionCard = card.closest('.attraction-card');
      let attractionPositions = [];
      
      if (attractionCard) {
        const attractionName = attractionCard.getAttribute('data-attraction-name');
        // Find the attraction in the data from currentAttractions
        const attraction = currentAttractions.find(a => a.name === attractionName);
        if (attraction) {
          // Get position names directly from the attraction data
          attractionPositions = attraction.positions.map(p => p.name);
        }
      }
      
      // Get next rotation FOR THIS ATTRACTION only
      const nextRot = getNextRotation(currentMins, attractionPositions);
      
      if (timeBadge) timeBadge.textContent = nextRot.label;
      
      // Count filled positions (those with an operator assigned)
      // Filter to ONLY show assignments that match this attraction's positions
      const matchingAssignments = attractionPositions.map(posName => {
        return nextRot.assignments?.find(assign => assign.position === posName) || { position: posName, operator: '' };
      });
      
      let filledCount = 0;
      const staffHTML = matchingAssignments.map((assignment) => {
        const operator = assignment.operator || '';
        let bgColor, borderColor, textColor;
        if (operator && operator.trim()) {
          filledCount++;
          bgColor = 'var(--teal-glow)';
          borderColor = 'var(--teal)';
          textColor = 'var(--teal)';
        } else {
          bgColor = 'rgba(192, 57, 43, 0.1)';
          borderColor = 'rgba(192, 57, 43, 0.3)';
          textColor = 'var(--accent-red)';
        }
        const displayOperator = operator && operator.trim() ? operator : 'EMPTY';
        return `
          <div style="border: 2px solid #999; border-radius: 3px; overflow: visible; display: flex; gap: 2px;">
            <div style="flex: 1; background: transparent; border: 1px solid #bbb; border-radius: 2px; padding: 2px 4px; text-align: center;">
              <div style="font-size: 8px; font-weight: 700; color: var(--text-dark); text-transform: uppercase; letter-spacing: 0.2px;">${assignment.position}</div>
            </div>
            <div style="flex: 1; background: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 2px; padding: 2px 4px; text-align: center;">
              <div style="font-size: 8px; font-weight: 600; color: ${textColor};">${displayOperator}</div>
            </div>
          </div>
        `;
      }).join('');
      
      // Update rotation text with position count
      if (rotText) {
        rotText.textContent = `Rotation ${nextRot.rotation} • ${filledCount} of ${attractionPositions.length} Positions`;
      }
      
      // Update staff list - always use matchingAssignments which is filtered for this attraction
      const staffDiv = card.querySelector('.rotation-staff');
      if (staffDiv) {
        staffDiv.innerHTML = staffHTML;
      }
    });
  }

  // Load data when page loads
  function initDashboard() {
    loadZoneData();
    initSchedule();
  }
  
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDashboard);
  } else {
    initDashboard();
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

  // Scrubber setup - MUST be before tick() is called
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
    
    // Sync schedule list scroll - center the current rotation in view
    const list = document.getElementById('scheduleList');
    if (list) {
      const items = list.querySelectorAll('.sched-item');
      const currentMins = isPreview ? previewMinutes : minutesFromMidnight(new Date());
      const allRotations = [...rotationSchedule.morning, ...rotationSchedule.afternoon];
      
      let closestIndex = -1;
      let closestDiff = Infinity;
      
      allRotations.forEach((rot, idx) => {
        const [h, m] = rot.time.split(':').map(Number);
        const rotMins = h * 60 + m;
        const diff = Math.abs(currentMins - rotMins);
        if (diff < closestDiff) {
          closestDiff = diff;
          closestIndex = idx;
        }
      });
      
      if (closestIndex >= 0 && items[closestIndex]) {
        // Get the item's position and scroll to center it
        const item = items[closestIndex];
        const itemTop = item.offsetTop;
        const itemHeight = item.offsetHeight;
        const containerHeight = list.clientHeight;
        const targetScroll = itemTop + (itemHeight / 2) - (containerHeight / 2);
        list.scrollTop = Math.max(0, targetScroll);
      }
    }
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
    // Always update rotation indicators and previews
    updateRotationIndicators();
    updateAttractionRotationPreviews();
  }

  setInterval(tick, 10000);
  tick();

  // More frequent rotation indicator updates
  setInterval(() => {
    updateRotationIndicators();
  }, 1000);

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
      let mins = DAY_START + pct * DAY_SPAN;
      // Round to nearest minute
      mins = Math.round(mins);
      previewMinutes = mins;
      updateDisplay(mins);
      setScrubberPct((mins - DAY_START) / DAY_SPAN);
      updateRotationIndicators();
      updateAttractionRotationPreviews();
    });
    document.addEventListener('mouseup', () => { dragging = false; });

    scrubDot.addEventListener('touchstart', e => { dragging = true; }, { passive: true });
    document.addEventListener('touchmove', e => {
      if (!dragging) return;
      const pct = pctFromEvent(e);
      isPreview = true;
      let mins = DAY_START + pct * DAY_SPAN;
      // Round to nearest minute
      mins = Math.round(mins);
      previewMinutes = mins;
      updateDisplay(mins);
      setScrubberPct((mins - DAY_START) / DAY_SPAN);
      updateRotationIndicators();
      updateAttractionRotationPreviews();
    }, { passive: true });
    document.addEventListener('touchend', () => { dragging = false; });
  }

  // Function to update active rotation indicators based on current time
  function updateRotationIndicators() {
    const currentMins = isPreview ? previewMinutes : minutesFromMidnight(new Date());
    
    // Clamp currentMins to day range to ensure valid highlighting
    const clampedCurrentMins = Math.max(DAY_START, Math.min(DAY_END, currentMins));
    
    document.querySelectorAll('.sched-item').forEach(item => {
      // Clear all highlights first
      item.classList.remove('current-hard', 'close-to-mini');
      
      const timeStr = item.getAttribute('data-time');
      if (!timeStr) return; // Skip if no time data
      
      const timeParts = timeStr.split(':');
      if (timeParts.length !== 2) return; // Skip if invalid format
      
      const hours = parseInt(timeParts[0], 10);
      const mins = parseInt(timeParts[1], 10);
      
      if (isNaN(hours) || isNaN(mins)) return; // Skip if not valid numbers
      
      const itemMins = hours * 60 + mins;
      
      // Calculate time difference - only highlight if future rotation is within window
      const timeDiff = itemMins - clampedCurrentMins; // Positive means rotation is in future
      
      // Only add highlights if the rotation is in the future and within the time window
      if (timeDiff > 0) { // Must be in the future
        if (item.classList.contains('hard-rotation') && timeDiff <= 5) {
          item.classList.add('current-hard');
        } else if (item.classList.contains('mini-rotation') && timeDiff <= 3) {
          item.classList.add('close-to-mini');
        }
      }
    });
  }
  
  console.log('[Dashboard] Schedule event listeners setup - NOW STARTING RESIZE SETUP');
  // ===== RESIZE HANDLE SETUP (Horizontal - Schedule Bar) =====
  // Wrap in try-catch to ensure it runs even if other code has errors
  try {
    const resizeHandle = document.getElementById('scheduleResizeHandle');
    const scheduleBar = document.getElementById('scheduleBar');
    let isResizing = false;
    let startX = 0;
    let startWidth = 0;

    console.log('[Dashboard Resize] Handle found:', !!resizeHandle);
    console.log('[Dashboard Resize] Schedule bar found:', !!scheduleBar);
    console.log('[Dashboard Resize] Schedule bar current width:', scheduleBar?.offsetWidth);
    console.log('[Dashboard Resize] Schedule bar flex:', window.getComputedStyle(scheduleBar).flex);

    if (resizeHandle && scheduleBar) {
      resizeHandle.addEventListener('mousedown', function(e) {
        console.log('[Resize] Mousedown fired');
        e.preventDefault();
        isResizing = true;
        startX = e.clientX;
        startWidth = scheduleBar.offsetWidth;
        console.log('[Resize] Starting drag - startX:', startX, 'startWidth:', startWidth);
        document.body.style.userSelect = 'none';
        document.body.style.cursor = 'ew-resize';
      });

      document.addEventListener('mousemove', function(e) {
        if (!isResizing) return;
        
        const diff = startX - e.clientX;
        const newWidth = Math.max(150, Math.min(600, startWidth + diff));
        
        console.log('[Resize] Moving - diff:', diff, 'newWidth:', newWidth);
        scheduleBar.style.setProperty('width', newWidth + 'px', 'important');
        scheduleBar.style.setProperty('flex', '0 0 ' + newWidth + 'px', 'important');
        scheduleBar.style.setProperty('flex-basis', newWidth + 'px', 'important');
      });

      document.addEventListener('mouseup', function() {
        if (isResizing) {
          console.log('[Resize] Mouse up - stopping');
          isResizing = false;
          document.body.style.userSelect = '';
          document.body.style.cursor = '';
        }
      });
    } else {
      console.error('[Resize] Missing elements - handle:', !!resizeHandle, 'bar:', !!scheduleBar);
    }
  } catch (err) {
    console.error('[Resize] Error during setup:', err);
  }

</script>

<!-- Resize handler in separate script for reliability -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  console.log('[Resize Init] DOM loaded - initializing resize');
  
  const handle = document.getElementById('scheduleResizeHandle');
  const bar = document.getElementById('scheduleBar');
  
  console.log('[Resize Init] Elements:', { handle: !!handle, bar: !!bar });
  
  if (!handle || !bar) {
    console.error('[Resize Init] Elements not found!');
    return;
  }
  
  let resizing = false;
  let startX = 0;
  let startWidth = 0;
  
  handle.addEventListener('mousedown', (e) => {
    console.log('[ResizeInit] DOWN', e.clientX);
    resizing = true;
    startX = e.clientX;
    startWidth = bar.offsetWidth;
    document.body.style.cursor = 'ew-resize';
    e.preventDefault();
  });
  
  document.addEventListener('mousemove', (e) => {
    if (!resizing) return;
    const diff = startX - e.clientX;
    const newW = Math.max(150, Math.min(600, startWidth + diff));
    console.log('[ResizeInit] MOVE', newW);
    bar.style.setProperty('width', newW + 'px', 'important');
    bar.style.setProperty('flex', '0 0 ' + newW + 'px', 'important');
    bar.style.setProperty('flex-basis', newW + 'px', 'important');
  });
  
  document.addEventListener('mouseup', () => {
    if (resizing) {
      console.log('[ResizeInit] UP');
      resizing = false;
      document.body.style.cursor = '';
    }
  });
});
</script>

</body>
</html>