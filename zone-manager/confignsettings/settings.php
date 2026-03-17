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
        <div class="nav-item">
          <a href="../../management/management-dashboard/management-dashboard.php" class="nav-link">
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

                <!-- Attraction tiles loaded dynamically from DB -->

                <div class="attraction-thumb" data-id="add" onclick="addAttraction()">
                  <div class="thumb-bg">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8bGluZSB4MT0iMTIiIHkxPSI1IiB4Mj0iMTIiIHkyPSIxOSIvPgogIDxsaW5lIHgxPSI1IiB5MT0iMTIiIHgyPSIxOSIgeTI9IjEyIi8+Cjwvc3ZnPg==" style="width:100%;height:100%;object-fit:cover;" />
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
                <div class="img-upload" title="Upload attraction image" onclick="document.getElementById('attractionImageInput').click()" style="cursor:pointer;overflow:hidden;position:relative;">
                  <input type="file" id="attractionImageInput" accept="image/*" style="display:none;" onchange="previewAttractionImage(this)" />
                  <img id="attractionImagePreview" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                  <svg id="attractionImagePlaceholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
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
                <select id="attractionStatus">
                  <option value="up">Operational</option>
                  <option value="maint">Maintenance</option>
                  <option value="down">Closed</option>
                </select>
              </div>

              <div class="field-label">Operation Hours</div>
              <div class="hours-row" style="margin-bottom:10px;">
                <input type="time" id="attractionHoursOpen" value="09:00" />
                <span class="hours-sep">–</span>
                <input type="time" id="attractionHoursClose" value="20:00" />
              </div>

              <div class="toggle-wrap" style="margin-bottom:6px;">
                <label class="toggle">
                  <input type="checkbox" id="attractionInRotation" checked />
                  <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Included in Rotation</span>
              </div>
              <div class="toggle-wrap">
                <label class="toggle">
                  <input type="checkbox" id="attractionRequiresCert" />
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

              <!-- Position rows loaded from DB -->
              <div id="positionList">
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
              <select id="mainPosition" style="width:100%;">
              </select>

              <div class="field-label" style="margin-top:10px;">Required Certifications</div>
              <textarea id="requiredCerts" placeholder="List required certifications or notes…"></textarea>

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

  // Attraction selector — fetch ride data from DB and populate right panel
  let currentRideId = null;

  function selectAttraction(el, name, rideId) {
    document.querySelectorAll('.attraction-thumb').forEach(t => t.classList.remove('selected'));
    el.classList.add('selected');

    if (!rideId) return;
    currentRideId = rideId;

    fetch('api.php?action=getAttractionData&ride_id=' + rideId)
      .then(res => res.json())
      .then(data => {
        if (!data.success) return;

        const ride = data.ride;
        const positions = data.positions;

        // Populate attraction name
        document.getElementById('attractionName').value = ride.ride_name;

        // Populate status
        const statusEl = document.getElementById('attractionStatus');
        if (statusEl) statusEl.value = ride.ride_status || 'up';

        // Populate in-rotation toggle (placed on canvas = in rotation)
        const rotationEl = document.getElementById('attractionInRotation');
        if (rotationEl) rotationEl.checked = ride.ride_is_placed_on_canvas == 1;

        // Build position list
        const posList = document.getElementById('positionList');
        posList.innerHTML = '';

        const mainPosSelect = document.getElementById('mainPosition');
        mainPosSelect.innerHTML = '';

        positions.forEach(pos => {
          // Position row
          const row = document.createElement('div');
          row.className = 'position-row';
          row.setAttribute('data-pos-id', pos.pos_id);
          const holder = pos.acc_name ? ` (${pos.acc_name})` : '';
          row.innerHTML = `
            <input type="text" placeholder="Position Name" value="${pos.pos_name}" readonly />
            <div class="divider">→</div>
            <input type="text" placeholder="Assigned" value="${pos.acc_name || 'Unassigned'}" readonly />
          `;
          posList.appendChild(row);

          // Main position option
          const opt = document.createElement('option');
          opt.value = pos.pos_id;
          opt.textContent = pos.pos_name;
          mainPosSelect.appendChild(opt);
        });

        if (positions.length === 0) {
          posList.innerHTML = '<div style="color:#888;font-size:12px;padding:6px 0;">No positions assigned to this ride.</div>';
        }

        posCount = positions.length;
      })
      .catch(err => console.error('Failed to load attraction data:', err));
  }

  function addAttraction() {
    const name = prompt("Enter attraction name:");
    if (!name) return;

    // Save to database
    const formData = new FormData();
    formData.append('action', 'addAttraction');
    formData.append('name', name);
    formData.append('zone_id', 1); // Current zone ID

    fetch('api.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        if (!data.success) {
          alert('Error saving attraction: ' + data.error);
          return;
        }

        // Add the tile to the grid after successful DB insert
        const grid = document.getElementById("attractionGrid");
        const newTile = document.createElement("div");
        newTile.className = "attraction-thumb";
        newTile.setAttribute("data-id", "ride" + data.ride_id);

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
          <div class="attraction-label">${data.ride_name}</div>
        `;

        newTile.onclick = function () {
          selectAttraction(this, data.ride_name, data.ride_id);
        };

        const addTile = grid.querySelector('[data-id="add"]');
        grid.insertBefore(newTile, addTile);

        // Auto-select the new tile
        selectAttraction(newTile, data.ride_name, data.ride_id);
      })
      .catch(err => {
        alert('Failed to save attraction: ' + err.message);
      });
  }

  // Position management
  let posCount = 0;
  function addPosition() {
    if (!currentRideId) {
      alert('Select an attraction first.');
      return;
    }
    posCount++;
    const list = document.getElementById('positionList');
    const row = document.createElement('div');
    row.className = 'position-row';
    row.innerHTML = `
      <input type="text" placeholder="Position Name" value="Position ${posCount}" />
      <div class="divider">→</div>
      <input type="text" placeholder="Assigned" value="Unassigned" readonly />
    `;
    list.appendChild(row);

    // Add to main position dropdown
    const mainPosSelect = document.getElementById('mainPosition');
    const opt = document.createElement('option');
    opt.textContent = 'Position ' + posCount;
    mainPosSelect.appendChild(opt);
  }

  function removePosition() {
    const list = document.getElementById('positionList');
    if (list.children.length > 1) {
      list.removeChild(list.lastChild);
      posCount--;

      // Remove last option from main position dropdown
      const mainPosSelect = document.getElementById('mainPosition');
      if (mainPosSelect.options.length > 0) {
        mainPosSelect.remove(mainPosSelect.options.length - 1);
      }
    }
  }

  // Permission tier toggle
  function togglePerm(el) {
    el.classList.toggle('active');
  }

  // ── Load attraction grid from DB on page load ──
  function loadAttractions(zoneId = 1) {
    fetch('api.php?action=getZoneAttractions&zone_id=' + zoneId)
      .then(res => res.json())
      .then(data => {
        if (!data.success) return;

        const grid = document.getElementById('attractionGrid');
        const addTile = grid.querySelector('[data-id="add"]');

        // Remove all existing tiles except the "Add New" tile
        Array.from(grid.children).forEach(child => {
          if (child !== addTile) child.remove();
        });

        data.attractions.forEach((ride, index) => {
          const tile = document.createElement('div');
          tile.className = 'attraction-thumb' + (index === 0 ? ' selected' : '');
          tile.setAttribute('data-id', 'ride' + ride.ride_id);

          tile.innerHTML = `
            <div class="thumb-bg">
              <img src="${ride.ride_image || 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSIxMCIgc3Ryb2tlPSJjdXJyZW50Q29sb3IiIHN0cm9rZS13aWR0aD0iMS41Ii8+Cjwvc3ZnPg=='}" style="width:100%;height:100%;object-fit:cover;" />
            </div>
            </div>
            <div class="thumb-check">
              <svg viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="2">
                <polyline points="1.5,5 4,7.5 8.5,2.5"/>
              </svg>
            </div>
            <div class="attraction-label">${ride.ride_name}</div>
          `;

          tile.onclick = function () {
            selectAttraction(this, ride.ride_name, ride.ride_id);
          };

          grid.insertBefore(tile, addTile);

          // Load data for the first attraction
          if (index === 0) {
            selectAttraction(tile, ride.ride_name, ride.ride_id);
          }
        });
      })
      .catch(err => console.error('Failed to load attractions:', err));
  }


  // Image upload preview
  function previewAttractionImage(input) {
    if (input.files && input.files[0]) {
      const file = input.files[0];
      if (!file.type.startsWith('image/')) return;
      const reader = new FileReader();
      reader.onload = function(e) {
        const preview = document.getElementById('attractionImagePreview');
        const placeholder = document.getElementById('attractionImagePlaceholder');
        preview.src = e.target.result;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  }

  // Load on page ready
  loadAttractions(1);
</script>
</body>
</html>
 