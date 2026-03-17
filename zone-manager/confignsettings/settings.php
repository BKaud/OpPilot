 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>OPilot – Settings</title>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap%22 rel="stylesheet" />
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
<a href="../dashboard/dashboard.php" class="zone-sub-link">Dashboard</a>
<a href="../EditMode/editmode.php" class="zone-sub-link">Edit Mode</a>
<a href="settings.php" class="zone-sub-link active">Settings & Config</a>
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
<!-- Attraction tiles loaded dynamically from DB -->
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
<div style="margin-top:12px;">
<button id="deleteBtn" class="btn btn-danger">Delete Attraction</button>
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
<button id="discardBtn" class="btn btn-danger">Discard Changes</button>
<button id="resetDefaultsBtn" class="btn btn-gray">Reset Defaults</button>
<button id="saveSettingsBtn" class="btn btn-teal">Save Settings</button>
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
  let savedSnapshot = null; // stores last-loaded ride data for discard
  function selectAttraction(el, name, rideId) {
    document.querySelectorAll('.attraction-thumb').forEach(t => t.classList.remove('selected'));
    el.classList.add('selected');
    if (!rideId) return;
    currentRideId = rideId;
    return fetch('api.php?action=getAttractionData&ride_id=' + rideId)
      .then(res => res.json())
      .then(data => {
        if (!data.success) return data;
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
        // Populate required certs if present
        const certsEl = document.getElementById('requiredCerts');
        if (certsEl && ride.ride_required_certs !== undefined) certsEl.value = ride.ride_required_certs || '';
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
<input type="text" placeholder="Position Name" value="${pos.pos_name}" />
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
        // Save deep-copy snapshot for discard/rollback (avoid accidental mutation)
        try {
          savedSnapshot = { ride: JSON.parse(JSON.stringify(ride)), positions: JSON.parse(JSON.stringify(positions)) };
        } catch (e) {
          savedSnapshot = { ride: ride, positions: positions };
        }
        // Restore main position selection if provided
        if (ride.ride_main_pos_id) {
          try { mainPosSelect.value = ride.ride_main_pos_id; } catch (e) {}
        }
        return data;
      })
      .catch(err => {
        console.error('Failed to load attraction data:', err);
        return { success: false, error: err.message };
      });
  }
  function addAttraction() {
    showInputModal('Enter attraction name:', 'Attraction name…').then(name => {
      if (!name) return;
      // Save to database
      const formData = new FormData();
      formData.append('action', 'addAttraction');
      formData.append('name', name);
      formData.append('zone_id', 1); // Current zone ID
      fetch('api.php', { method: 'POST', body: formData })
        .then(res => res.text())
        .then(text => {
          let data = null;
          try {
            data = JSON.parse(text);
          } catch (e) {
            // Server returned non-JSON (likely PHP error or warning)
            console.error('Non-JSON response from server:', text);
            showToast('Server error: ' + (text || 'Empty response'), 'error');
            return;
          }

          if (!data || !data.success) {
            showToast('Error saving attraction: ' + (data && data.error ? data.error : 'Unknown error'), 'error');
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
          // Auto-select the new tile and show success toast
          selectAttraction(newTile, data.ride_name, data.ride_id)
            .then(() => showToast('Attraction created', 'success'))
            .catch(() => showToast('Attraction created', 'success'));
        })
        .catch(err => {
          console.error('Failed to save attraction:', err);
          showToast('Failed to save attraction: ' + (err.message || err), 'error');
        });
    });
  }
  // Position management
  let posCount = 0;
  let deletedPosIds = [];
  function addPosition() {
    if (!currentRideId) {
      showToast('Select an attraction first.', 'error');
      return;
    }
    posCount++;
    const list = document.getElementById('positionList');
    const row = document.createElement('div');
    row.className = 'position-row';
    row.setAttribute('data-pos-id', '0');
    row.innerHTML = `
<input type="text" placeholder="Position Name" value="Position ${posCount}" />
<div class="divider">→</div>
<input type="text" placeholder="Assigned" value="Unassigned" readonly />
    `;
    list.appendChild(row);
    // Add to main position dropdown
    const mainPosSelect = document.getElementById('mainPosition');
    const opt = document.createElement('option');
    opt.value = '';
    opt.textContent = 'Position ' + posCount;
    mainPosSelect.appendChild(opt);
  }
  function removePosition() {
    const list = document.getElementById('positionList');
    if (list.children.length > 0) {
      const last = list.lastChild;
      const pid = parseInt(last.getAttribute('data-pos-id') || '0', 10);
      if (pid > 0) deletedPosIds.push(pid);
      list.removeChild(last);
      if (posCount > 0) posCount--;
      // Remove last option from main position dropdown if present
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
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
<circle cx="12" cy="12" r="10"/>
</svg>
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
  // Toast helper
  function showToast(message, type = 'info', timeout = 3000) {
    let container = document.getElementById('toastContainer');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toastContainer';
      document.body.appendChild(container);
    }
    const toast = document.createElement('div');
    toast.className = 'toast ' + type;
    toast.textContent = message;
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(12px)';
    container.appendChild(toast);
    // Force reflow then animate in
    void toast.offsetWidth;
    toast.style.transition = 'opacity 220ms ease, transform 220ms ease';
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(12px)';
      setTimeout(() => toast.remove(), 240);
    }, timeout);
  }
  // Input modal helper (returns Promise<string|null>)
  function showInputModal(title, placeholder = '') {
    return new Promise((resolve) => {
      const overlay = document.createElement('div');
      overlay.className = 'input-overlay';
      overlay.innerHTML = `
<div class="input-modal">
<div class="input-title">${title}</div>
<input class="input-field" placeholder="${placeholder}" />
<div class="input-actions">
<button class="btn btn-gray cancel">Cancel</button>
<button class="btn btn-teal ok">OK</button>
</div>
</div>
      `;
      document.body.appendChild(overlay);
      const input = overlay.querySelector('.input-field');
      const ok = overlay.querySelector('.ok');
      const cancel = overlay.querySelector('.cancel');
      function cleanup(val) {
        try { overlay.remove(); } catch (e) {}
        resolve(val);
      }
      ok.addEventListener('click', () => {
        const v = input.value.trim();
        cleanup(v === '' ? null : v);
      });
      cancel.addEventListener('click', () => cleanup(null));
      overlay.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') return cleanup(null);
        if (e.key === 'Enter') { e.preventDefault(); const v = input.value.trim(); return cleanup(v === '' ? null : v); }
      }, true);
      input.focus();
    });
  }
  // Save settings handler
  document.getElementById('saveSettingsBtn').addEventListener('click', function () {
    if (!currentRideId) {
      showToast('Select an attraction first.', 'error');
      return;
    }
    const name = document.getElementById('attractionName').value.trim();
    const status = document.getElementById('attractionStatus') ? document.getElementById('attractionStatus').value : 'up';
    const isPlaced = document.getElementById('attractionInRotation') && document.getElementById('attractionInRotation').checked ? 1 : 0;
    // Collect positions
    const positions = [];
    document.querySelectorAll('#positionList .position-row').forEach((row, idx) => {
      const pid = parseInt(row.getAttribute('data-pos-id') || '0', 10);
      const nameInput = row.querySelector('input[type="text"]');
      const pname = nameInput ? nameInput.value.trim() : '';
      positions.push({ pos_id: pid, pos_name: pname, pos_order: idx + 1 });
    });
    const mainPosition = document.getElementById('mainPosition') ? document.getElementById('mainPosition').value : '';
    const requiredCerts = document.getElementById('requiredCerts') ? document.getElementById('requiredCerts').value.trim() : '';
    const formData = new FormData();
    formData.append('action', 'saveAttractionSettings');
    formData.append('ride_id', currentRideId);
    formData.append('ride_name', name);
    formData.append('ride_status', status);
    formData.append('ride_is_placed_on_canvas', isPlaced);
    formData.append('positions', JSON.stringify(positions));
    formData.append('deleted_positions', JSON.stringify(deletedPosIds));
    formData.append('main_position', mainPosition);
    formData.append('required_certs', requiredCerts);
    fetch('api.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        if (!data.success) {
          showToast('Failed to save: ' + (data.error || 'Unknown error'), 'error');
          return;
        }
        // Update selected tile label
        const sel = document.querySelector('.attraction-thumb.selected .attraction-label');
        if (sel) sel.textContent = name || data.ride_name || sel.textContent;
        showToast('Settings saved', 'success');
      })
      .catch(err => {
        console.error('Save error:', err);
        showToast('Failed to save settings.', 'error');
      });
  });
  // Discard changes handler — reload saved data for current ride
  document.getElementById('discardBtn').addEventListener('click', function () {
    if (!currentRideId) {
      showToast('No attraction selected', 'error');
      return;
    }
    // Reset deleted/new position trackers
    deletedPosIds = [];
    // Find the tile element for current ride
    let tile = document.querySelector('.attraction-thumb.selected');
    if (!tile) tile = document.querySelector('[data-id="ride' + currentRideId + '"]');
    // If we have a saved snapshot for this ride, use it to revert immediately
    if (savedSnapshot && savedSnapshot.ride && parseInt(savedSnapshot.ride.ride_id, 10) === parseInt(currentRideId, 10)) {
      // Repopulate UI from snapshot
      const ride = savedSnapshot.ride;
      const positions = savedSnapshot.positions || [];
      document.getElementById('attractionName').value = ride.ride_name || '';
      const statusEl = document.getElementById('attractionStatus');
      if (statusEl) statusEl.value = ride.ride_status || 'up';
      const rotationEl = document.getElementById('attractionInRotation');
      if (rotationEl) rotationEl.checked = ride.ride_is_placed_on_canvas == 1;
      const certsEl = document.getElementById('requiredCerts');
      if (certsEl) certsEl.value = ride.ride_required_certs || '';
      const posList = document.getElementById('positionList');
      posList.innerHTML = '';
      const mainPosSelect = document.getElementById('mainPosition');
      mainPosSelect.innerHTML = '';
      positions.forEach(pos => {
        const row = document.createElement('div');
        row.className = 'position-row';
        row.setAttribute('data-pos-id', pos.pos_id);
        row.innerHTML = `
<input type="text" placeholder="Position Name" value="${pos.pos_name}" />
<div class="divider">→</div>
<input type="text" placeholder="Assigned" value="${pos.acc_name || 'Unassigned'}" readonly />
        `;
        posList.appendChild(row);
        const opt = document.createElement('option');
        opt.value = pos.pos_id;
        opt.textContent = pos.pos_name;
        mainPosSelect.appendChild(opt);
      });
      // Restore main position selection from snapshot
      if (ride.ride_main_pos_id) {
        try { mainPosSelect.value = ride.ride_main_pos_id; } catch (e) {}
      }
      posCount = positions.length;
      // Update tile label if present
      if (tile) {
        const label = tile.querySelector('.attraction-label');
        if (label) label.textContent = savedSnapshot.ride.ride_name || label.textContent;
      }
      showToast('Changes discarded', 'error');
    } else if (tile) {
      // No snapshot: reload from server
      selectAttraction(tile, '', currentRideId).then(data => {
        if (data && data.success) {
          const label = tile.querySelector('.attraction-label');
          if (label) label.textContent = data.ride.ride_name || label.textContent;
        }
        showToast('Changes discarded', 'error');
      }).catch(() => showToast('Changes discarded', 'error'));
    } else {
      // As fallback, fetch the data and repopulate directly
      fetch('api.php?action=getAttractionData&ride_id=' + currentRideId)
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            showToast('Failed to reload data', 'error');
            return;
          }
          // Populate UI with returned data
          document.getElementById('attractionName').value = data.ride.ride_name || '';
          const statusEl = document.getElementById('attractionStatus');
          if (statusEl) statusEl.value = data.ride.ride_status || 'up';
          const rotationEl = document.getElementById('attractionInRotation');
          if (rotationEl) rotationEl.checked = data.ride.ride_is_placed_on_canvas == 1;
          const certsEl = document.getElementById('requiredCerts');
          if (certsEl) certsEl.value = data.ride.ride_required_certs || '';
          // Rebuild positions
          const posList = document.getElementById('positionList');
          posList.innerHTML = '';
          const mainPosSelect = document.getElementById('mainPosition');
          mainPosSelect.innerHTML = '';
          data.positions.forEach(pos => {
            const row = document.createElement('div');
            row.className = 'position-row';
            row.setAttribute('data-pos-id', pos.pos_id);
            row.innerHTML = `
<input type="text" placeholder="Position Name" value="${pos.pos_name}" />
<div class="divider">→</div>
<input type="text" placeholder="Assigned" value="${pos.acc_name || 'Unassigned'}" readonly />
            `;
            posList.appendChild(row);
            const opt = document.createElement('option');
            opt.value = pos.pos_id;
            opt.textContent = pos.pos_name;
            mainPosSelect.appendChild(opt);
          });
            // Restore main position selection if present
            if (data.ride && data.ride.ride_main_pos_id) {
              try { mainPosSelect.value = data.ride.ride_main_pos_id; } catch (e) {}
            }
            posCount = data.positions.length;
          showToast('Changes discarded', 'error');
        })
        .catch(err => {
          console.error('Discard error:', err);
          showToast('Failed to discard changes', 'error');
        });
    }
  });
  // Reset Defaults handler — restore the tile/UI to the original saved snapshot
  document.getElementById('resetDefaultsBtn').addEventListener('click', function () {
    if (!currentRideId) {
      showToast('No attraction selected', 'error');
      return;
    }
    if (!savedSnapshot || !savedSnapshot.ride) {
      showToast('No defaults available', 'error');
      return;
    }
    // Use snapshot to restore
    const ride = savedSnapshot.ride;
    const positions = savedSnapshot.positions || [];
    // Reset trackers
    deletedPosIds = [];
    // Update UI
    document.getElementById('attractionName').value = ride.ride_name || '';
    const statusEl = document.getElementById('attractionStatus');
    if (statusEl) statusEl.value = ride.ride_status || 'up';
    const rotationEl = document.getElementById('attractionInRotation');
    if (rotationEl) rotationEl.checked = ride.ride_is_placed_on_canvas == 1;
    const certsEl = document.getElementById('requiredCerts');
    if (certsEl) certsEl.value = ride.ride_required_certs || '';
    // Rebuild positions and main position
    const posList = document.getElementById('positionList');
    posList.innerHTML = '';
    const mainPosSelect = document.getElementById('mainPosition');
    mainPosSelect.innerHTML = '';
    positions.forEach(pos => {
      const row = document.createElement('div');
      row.className = 'position-row';
      row.setAttribute('data-pos-id', pos.pos_id);
      row.innerHTML = `
<input type="text" placeholder="Position Name" value="${pos.pos_name}" />
<div class="divider">→</div>
<input type="text" placeholder="Assigned" value="${pos.acc_name || 'Unassigned'}" readonly />
      `;
      posList.appendChild(row);
      const opt = document.createElement('option');
      opt.value = pos.pos_id;
      opt.textContent = pos.pos_name;
      mainPosSelect.appendChild(opt);
    });
    posCount = positions.length;
    // Ensure main position selected when restoring defaults
    if (ride.ride_main_pos_id) {
      try { mainPosSelect.value = ride.ride_main_pos_id; } catch (e) {}
    }
    // Update left tile label if present
    const tile = document.querySelector('.attraction-thumb.selected') || document.querySelector('[data-id="ride' + currentRideId + '"]');
    if (tile) {
      const label = tile.querySelector('.attraction-label');
      if (label) label.textContent = ride.ride_name || label.textContent;
    }
    showToast('Defaults restored', 'info');
  });
  // Delete attraction handler — confirm by typing the attraction name, then call API
  document.getElementById('deleteBtn').addEventListener('click', function () {
    if (!currentRideId) {
      showToast('No attraction selected', 'error');
      return;
    }
    const currentName = (document.getElementById('attractionName') && document.getElementById('attractionName').value) ? document.getElementById('attractionName').value.trim() : (savedSnapshot && savedSnapshot.ride ? (savedSnapshot.ride.ride_name || '') : '');
    if (currentName) {
      showInputModal('Type the attraction name to confirm deletion:', currentName)
        .then(val => {
          if (!val || val !== currentName) {
            showToast('Deletion cancelled', 'info');
            return;
          }
          performDelete();
        });
    } else {
      // Fallback: require typing DELETE
      showInputModal('Type DELETE to confirm deletion', 'Type DELETE to confirm')
        .then(val => {
          if (!val || val !== 'DELETE') {
            showToast('Deletion cancelled', 'info');
            return;
          }
          performDelete();
        });
    }
    function performDelete() {
      const formData = new FormData();
      formData.append('action', 'deleteAttraction');
      formData.append('ride_id', currentRideId);
      fetch('api.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            showToast('Failed to delete: ' + (data.error || 'Unknown error'), 'error');
            return;
          }
          // Remove tile from grid if present
          const sel = document.querySelector('.attraction-thumb.selected');
          const tile = sel || document.querySelector('[data-id="ride' + currentRideId + '"]');
          if (tile) tile.remove();
          // Clear right panel and trackers
          currentRideId = null;
          savedSnapshot = null;
          deletedPosIds = [];
          const nameEl = document.getElementById('attractionName'); if (nameEl) nameEl.value = '';
          const posList = document.getElementById('positionList'); if (posList) posList.innerHTML = '';
          const mainPosSelect = document.getElementById('mainPosition'); if (mainPosSelect) mainPosSelect.innerHTML = '';
          showToast('Attraction deleted', 'success');
        })
        .catch(err => {
          console.error('Delete error:', err);
          showToast('Failed to delete attraction', 'error');
        });
    }
  });
</script>
<style>
  #toastContainer { position: fixed; left: 50%; bottom: 22px; transform: translateX(-50%); z-index: 10000; display:flex; flex-direction:column; gap:8px; align-items:center; pointer-events:none; }
  .toast { pointer-events:auto; min-width:160px; max-width:360px; padding:10px 14px; border-radius:8px; color:#fff; font-weight:600; box-shadow:0 6px 18px rgba(0,0,0,0.12); background:#333; opacity:0; }
  .toast.success { background: linear-gradient(90deg,#12b886,#07924b); }
  .toast.info { background: linear-gradient(90deg,#2b8cff,#1565c0); }
  .toast.error { background: linear-gradient(90deg,#ff6b6b,#d64545); }
  /* Input modal styles */
  .input-overlay { position: fixed; inset:0; display:flex; align-items:center; justify-content:center; background: rgba(0,0,0,0.35); z-index:10005; }
  .input-modal { background:#fff; padding:18px; border-radius:10px; box-shadow:0 8px 30px rgba(0,0,0,0.25); width:360px; max-width:92%; }
  .input-title { font-weight:700; margin-bottom:8px; }
  .input-field { width:100%; padding:8px 10px; border-radius:6px; border:1px solid #ddd; margin-bottom:12px; font-size:14px; }
  .input-actions { display:flex; gap:8px; justify-content:flex-end; }
  .input-actions .btn { padding:6px 10px; font-size:13px; }
  /* Ensure modal and input text is readable (black) */
  .input-modal, .input-modal .input-title { color: #000; }
  .input-field { color: #000; }
  /* Make form inputs and textarea text black for clarity */
  #positionList .position-row input,
  #positionList .position-row input::placeholder,
  input[type="text"],
  select,
  textarea { color: #000; }
</style>
</body>
</html>

 