<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OPilot – Settings</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="../../assets/css/theme.css" />
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="navbar-logo">
    <div class="logo-icon"></div>
    <span class="logo-name">O<span>P</span>ilot</span>
  </div>
</nav>

<div class="main">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="nav-section">
      <div class="nav-upper">
        <!-- Homepage -->
          <div class="nav-item">
            <a href="../dashboard/dashboard.php" class="nav-link active" id="home-link">
              <div class="nav-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M3 12L12 3l9 9"/>
                  <path d="M9 21V12h6v9"/>
                </svg>
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
    document.querySelectorAll('.attraction-thumb').forEach(t => t.classList.remove('selected'));
    el.classList.add('selected');
    const nameInput = document.getElementById('attractionName');
    if (nameInput) nameInput.value = name;
  }

  function addAttraction() {
    const name = prompt("Enter attraction name:");
    if (!name) return;

    const grid = document.getElementById("attractionGrid");
    const newTile = document.createElement("div");
    newTile.className = "attraction-thumb";
    newTile.setAttribute("data-id", name.toLowerCase().replace(/\s+/g, "-"));

    newTile.innerHTML = `
      <div class="thumb-bg">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <circle cx="12" cy="12" r="10"/>
        </svg>
      </div>
      <div class="thumb-check">
        <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2">
          <polyline points="1.5,5 4,7.5 8.5,2.5"/>
        </svg>
      </div>
      <div class="attraction-label">${name}</div>
    `;

    newTile.onclick = function () {
      selectAttraction(this, name);
    };

    const addTile = grid.querySelector('[data-id="add"]');
    grid.insertBefore(newTile, addTile);
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
