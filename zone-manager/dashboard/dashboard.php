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
        const chipClass = pos.operator ? 'assigned' : 'empty';
        const operatorText = pos.operator ? pos.operator : 'Unassigned';
        return `<span class="pos-chip ${chipClass}">${pos.name}: ${operatorText}</span>`;
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
          <div class="card-positions">
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