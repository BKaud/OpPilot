<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OPilot – Settings</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="../../assets/css/theme.css" />
</head>

<body>
<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../partials/sidebar.php';
?>
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
                                    <input type="checkbox" id="zoneLockDuringMaint" />
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
                                    <div class="thumb-bg"
                                        style="background: linear-gradient(135deg, #b0b0b0, #a0a0a0);">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="5" x2="12" y2="19" />
                                            <line x1="5" y1="12" x2="19" y2="12" />
                                        </svg>
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
                                <div class="img-upload" title="Upload attraction image"
                                    onclick="document.getElementById('attractionImageInput').click()"
                                    style="cursor:pointer;overflow:hidden;position:relative;">
                                    <input type="file" id="attractionImageInput" accept="image/*" style="display:none;"
                                        onchange="previewAttractionImage(this)" />
                                    <img id="attractionImagePreview" src="" alt=""
                                        style="display:none;width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                                    <svg id="attractionImagePlaceholder" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <polyline points="21,15 16,10 5,21" />
                                    </svg>
                                </div>
                                <div class="form-col" style="flex:1;">
                                    <div class="field-label">Attraction Name</div>
                                    <div style="display:flex;gap:6px;">
                                        <input type="text" id="attractionName" value="Tidal Twist 1" style="flex:1;" />
                                        <button class="btn btn-gray btn-sm">Edit Name</button>
                                    </div>
                                    <div style="display:flex;gap:6px;margin-top:4px;">
                                        <input type="text" id="attractionLink" placeholder="Link to other ride…"
                                            style="flex:1;" />
                                        <button id="linkRideBtn" class="btn btn-gray btn-sm">Link Ride</button>
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
                                <button id="addPositionBtn" class="btn btn-gray btn-sm" onclick="addPosition()">+ Add
                                    Position</button>
                                <button id="removePositionBtn" class="btn btn-danger btn-sm"
                                    onclick="removePosition()">– Remove</button>
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
                            <textarea id="requiredCerts"
                                placeholder="List required certifications or notes…"></textarea>
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
                // Populate link field for this ride (per-tile)
                try {
                    const linkEl = document.getElementById('attractionLink');
                    if (linkEl) linkEl.value = ride.ride_link_url || ride.ride_link || '';
                } catch (e) {}
                // Populate status
                const statusEl = document.getElementById('attractionStatus');
                if (statusEl) statusEl.value = ride.ride_status || 'up';
                // Populate in-rotation toggle (placed on canvas = in rotation)
                const rotationEl = document.getElementById('attractionInRotation');
                if (rotationEl) rotationEl.checked = ride.ride_is_placed_on_canvas == 1;
                // Populate required certs if present
                const certsEl = document.getElementById('requiredCerts');
                if (certsEl && ride.ride_required_certs !== undefined) certsEl.value = ride.ride_required_certs ||
                    '';
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
                    posList.innerHTML =
                        '<div style="color:#888;font-size:12px;padding:6px 0;">No positions assigned to this ride.</div>';
                }
                posCount = positions.length;
                // Load ride image into preview and the left tile if the server returned one
                try {
                    const previewEl = document.getElementById('attractionImagePreview');
                    const placeholderEl = document.getElementById('attractionImagePlaceholder');
                    const tileEl = document.querySelector('.attraction-thumb.selected') || document.querySelector(
                        '[data-id="ride' + ride.ride_id + '"]');
                    let imageSrc = null;
                    if (ride.ride_image_url) imageSrc = ride.ride_image_url;
                    else if (ride.ride_image) imageSrc = ride.ride_image;
                    if (imageSrc) {
                        if (previewEl) {
                            previewEl.src = imageSrc;
                            previewEl.style.display = 'block';
                            if (placeholderEl) placeholderEl.style.display = 'none';
                        }
                        if (tileEl) {
                            const thumb = tileEl.querySelector('.thumb-bg');
                            if (thumb) {
                                thumb.style.backgroundImage = 'url("' + imageSrc + '")';
                                thumb.style.backgroundSize = 'cover';
                                thumb.style.backgroundPosition = 'center';
                                thumb.style.backgroundRepeat = 'no-repeat';
                                const sv = thumb.querySelector('svg');
                                if (sv) sv.style.display = 'none';
                            }
                            // ensure the tile reflects server status/link for locking and link editing
                            try {
                                tileEl.setAttribute('data-status', ride.ride_status || '');
                                tileEl.setAttribute('data-link', ride.ride_link_url || ride.ride_link || '');
                            } catch (e) {}
                        }
                    } else {
                        if (previewEl) {
                            previewEl.style.display = 'none';
                            if (placeholderEl) placeholderEl.style.display = 'block';
                        }
                        if (tileEl) {
                            const thumb = tileEl.querySelector('.thumb-bg');
                            if (thumb) {
                                thumb.style.backgroundImage = '';
                                const sv = thumb.querySelector('svg');
                                if (sv) sv.style.display = '';
                            }
                        }
                    }
                } catch (e) {
                    /* ignore image errors */
                }
                // Save deep-copy snapshot for discard/rollback (avoid accidental mutation)
                try {
                    savedSnapshot = {
                        ride: JSON.parse(JSON.stringify(ride)),
                        positions: JSON.parse(JSON.stringify(positions))
                    };
                } catch (e) {
                    savedSnapshot = {
                        ride: ride,
                        positions: positions
                    };
                }
                // Restore main position selection if provided
                if (ride.ride_main_pos_id) {
                    try {
                        mainPosSelect.value = ride.ride_main_pos_id;
                    } catch (e) {}
                }
                return data;
            })
            .catch(err => {
                console.error('Failed to load attraction data:', err);
                return {
                    success: false,
                    error: err.message
                };
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
            fetch('api.php', {
                    method: 'POST',
                    body: formData
                })
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
                        showToast('Error saving attraction: ' + (data && data.error ? data.error :
                            'Unknown error'), 'error');
                        return;
                    }

                    // Add the tile to the grid after successful DB insert
                    const grid = document.getElementById("attractionGrid");
                    const newTile = document.createElement("div");
                    newTile.className = "attraction-thumb";
                    newTile.setAttribute("data-id", "ride" + data.ride_id);
                    newTile.setAttribute('data-status', data.ride_status || 'up');
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
                    attachTileClick(newTile);
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

    // Attach a safe click handler that respects the maintenance lock
    function attachTileClick(tile) {
        tile.onclick = function(e) {
            if (tile.classList.contains('locked')) {
                showToast('This attraction is locked for maintenance', 'error');
                return;
            }
            const id = tile.getAttribute('data-id');
            const rideId = id && id.startsWith('ride') ? id.replace('ride', '') : null;
            selectAttraction(tile, tile.querySelector('.attraction-label') ? tile.querySelector('.attraction-label')
                .textContent : '', rideId);
        };
    }

    // Enable/disable right panel inputs when a ride is locked
    function setRightPanelEditable(enabled) {
        const fields = ['#attractionName', '#attractionStatus', '#attractionInRotation', '#attractionRequiresCert',
            '#mainPosition', '#requiredCerts', '#attractionLink'
        ];
        fields.forEach(s => {
            const el = document.querySelector(s);
            if (el) el.disabled = !enabled;
        });
        document.querySelectorAll('#positionList input[type="text"]').forEach(i => i.disabled = !enabled);
        ['saveSettingsBtn', 'deleteBtn', 'resetDefaultsBtn', 'addPositionBtn', 'removePositionBtn'].forEach(id => {
            const b = document.getElementById(id);
            if (b) b.disabled = !enabled;
        });
        const imgUpload = document.querySelector('.img-upload');
        if (imgUpload) {
            imgUpload.style.pointerEvents = enabled ? '' : 'none';
            imgUpload.style.opacity = enabled ? '' : '0.6';
        }
    }

    // Apply lock state across tiles (called on toggle change and after load/save)
    function updateMaintenanceLocking() {
        const lock = document.getElementById('zoneLockDuringMaint') && document.getElementById('zoneLockDuringMaint')
            .checked;
        document.querySelectorAll('.attraction-thumb').forEach(tile => {
            if (tile.getAttribute('data-id') === 'add') return;
            const status = tile.getAttribute('data-status') || '';
            if (lock && status === 'maint') tile.classList.add('locked');
            else tile.classList.remove('locked');
            // reattach click wrapper to ensure behavior
            attachTileClick(tile);
        });
        const selected = document.querySelector('.attraction-thumb.selected');
        if (selected && selected.classList.contains('locked')) {
            setRightPanelEditable(false);
        } else {
            setRightPanelEditable(true);
        }
    }
    // ── Load attraction grid from DB on page load ──
    function loadAttractions(zoneId = 1) {
        fetch('api.php?action=getZoneAttractions&zone_id=' + zoneId)
            .then(res => res.json())
            .then(data => {
                if (!data.success) return;
                const grid = document.getElementById('attractionGrid');
                const addTile = grid.querySelector('[data-id="add"]');
                // For each attraction from server, add it only if it doesn't already exist
                data.attractions.forEach((ride, index) => {
                    const id = 'ride' + ride.ride_id;
                    let tile = grid.querySelector('[data-id="' + id + '"]');
                    if (!tile) {
                        tile = document.createElement('div');
                        tile.className = 'attraction-thumb';
                        tile.setAttribute('data-id', id);
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
                        // store status/link on the tile element for locking and quick access
                        tile.setAttribute('data-status', ride.ride_status || '');
                        tile.setAttribute('data-link', ride.ride_link_url || '');
                        attachTileClick(tile);
                        grid.insertBefore(tile, addTile);
                    } else {
                        // Update label if changed
                        const lbl = tile.querySelector('.attraction-label');
                        if (lbl && lbl.textContent !== ride.ride_name) lbl.textContent = ride.ride_name;
                    }

                    // If ride has an image URL from server, apply it to the thumb
                    try {
                        const imgUrl = ride.ride_image_url || ride.ride_image || null;
                        if (imgUrl) {
                            const thumb = tile.querySelector('.thumb-bg');
                            if (thumb) {
                                thumb.style.backgroundImage = 'url("' + imgUrl + '")';
                                thumb.style.backgroundSize = 'cover';
                                thumb.style.backgroundPosition = 'center';
                                thumb.style.backgroundRepeat = 'no-repeat';
                                const sv = thumb.querySelector('svg');
                                if (sv) sv.style.display = 'none';
                            }
                        }
                    } catch (e) {
                        /* ignore */
                    }
                });

                // If there's no currently selected tile, select the first server-provided one
                if (!document.querySelector('.attraction-thumb.selected') && data.attractions && data.attractions
                    .length > 0) {
                    const first = grid.querySelector('[data-id="ride' + data.attractions[0].ride_id + '"]');
                    if (first) {
                        selectAttraction(first, data.attractions[0].ride_name, data.attractions[0].ride_id).then(
                        () => updateMaintenanceLocking()).catch(() => updateMaintenanceLocking());
                    } else {
                        updateMaintenanceLocking();
                    }
                } else {
                    // ensure lock state is applied even if nothing selected/changed
                    updateMaintenanceLocking();
                }
            })
            .catch(err => console.error('Failed to load attractions:', err));
    }



    // Image upload preview — also update the left tile background when an image is chosen
    function previewAttractionImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const dataUrl = e.target.result;
                const preview = document.getElementById('attractionImagePreview');
                const placeholder = document.getElementById('attractionImagePlaceholder');
                preview.src = dataUrl;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';

                // Update corresponding tile background (selected tile or tile for currentRideId)
                try {
                    const tile = document.querySelector('.attraction-thumb.selected') || document.querySelector(
                        '[data-id="ride' + currentRideId + '"]');
                    if (tile) {
                        const thumb = tile.querySelector('.thumb-bg');
                        if (thumb) {
                            thumb.style.backgroundImage = 'url("' + dataUrl + '")';
                            thumb.style.backgroundSize = 'cover';
                            thumb.style.backgroundPosition = 'center';
                            thumb.style.backgroundRepeat = 'no-repeat';
                            const sv = thumb.querySelector('svg');
                            if (sv) sv.style.display = 'none';
                        }
                    }
                } catch (err) {
                    console.warn('Failed to update tile background:', err);
                }
            };
            reader.readAsDataURL(file);
        }
    }
    // Load on page ready
    loadAttractions(1);
    // Hook the zone maintenance lock checkbox so changes apply immediately and persist
    try {
        const lockCheckbox = document.getElementById('zoneLockDuringMaint');

        function saveZoneLockState(checked) {
            const form = new URLSearchParams();
            form.append('action', 'saveZoneLock');
            form.append('zone_id', 1);
            form.append('locked', checked ? 1 : 0);
            fetch('api.php', {
                    method: 'POST',
                    body: form
                })
                .then(r => r.json())
                .then(resp => {
                    if (!resp || !resp.success) {
                        showToast('Failed to save zone lock', 'error');
                        return;
                    }
                    updateMaintenanceLocking();
                    showToast('Zone lock saved', 'info');
                })
                .catch(err => {
                    console.error('Failed to save zone lock', err);
                    showToast('Failed to save zone lock', 'error');
                });
        }

        function loadZoneLockState() {
            fetch('api.php?action=getZoneSettings&zone_id=1')
                .then(r => r.json())
                .then(resp => {
                    if (!resp || !resp.success) return;
                    try {
                        lockCheckbox.checked = !!resp.zone_lock_during_maint;
                    } catch (e) {}
                    // Update visual indicator in the zone list
                    try {
                        const ind = document.getElementById('zoneLockIndicator-1');
                        if (ind) {
                            if (resp.zone_lock_during_maint) {
                                ind.innerHTML =
                                    '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V8a5 5 0 0110 0v3"/></svg>';
                                ind.classList.add('locked');
                                ind.title = 'Locked during maintenance';
                            } else {
                                ind.innerHTML = '';
                                ind.classList.remove('locked');
                                ind.title = 'Zone lock';
                            }
                        }
                    } catch (e) {}
                    updateMaintenanceLocking();
                })
                .catch(err => console.warn('Failed to load zone settings', err));
        }

        if (lockCheckbox) {
            lockCheckbox.addEventListener('change', function() {
                saveZoneLockState(this.checked);
            });
            // Load saved state on page load
            loadZoneLockState();
        }
    } catch (e) {}
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
                try {
                    overlay.remove();
                } catch (e) {}
                resolve(val);
            }
            ok.addEventListener('click', () => {
                const v = input.value.trim();
                cleanup(v === '' ? null : v);
            });
            cancel.addEventListener('click', () => cleanup(null));
            overlay.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') return cleanup(null);
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const v = input.value.trim();
                    return cleanup(v === '' ? null : v);
                }
            }, true);
            input.focus();
        });
    }
    // Save settings handler
    document.getElementById('saveSettingsBtn').addEventListener('click', function() {
        if (!currentRideId) {
            showToast('Select an attraction first.', 'error');
            return;
        }
        const name = document.getElementById('attractionName').value.trim();
        const status = document.getElementById('attractionStatus') ? document.getElementById('attractionStatus')
            .value : 'up';
        const isPlaced = document.getElementById('attractionInRotation') && document.getElementById(
            'attractionInRotation').checked ? 1 : 0;
        // Collect positions
        const positions = [];
        document.querySelectorAll('#positionList .position-row').forEach((row, idx) => {
            const pid = parseInt(row.getAttribute('data-pos-id') || '0', 10);
            const nameInput = row.querySelector('input[type="text"]');
            const pname = nameInput ? nameInput.value.trim() : '';
            positions.push({
                pos_id: pid,
                pos_name: pname,
                pos_order: idx + 1
            });
        });
        const mainPosition = document.getElementById('mainPosition') ? document.getElementById('mainPosition')
            .value : '';
        const requiredCerts = document.getElementById('requiredCerts') ? document.getElementById(
            'requiredCerts').value.trim() : '';
        const rideLink = document.getElementById('attractionLink') ? document.getElementById('attractionLink')
            .value.trim() : '';
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
        formData.append('ride_link', rideLink);
        // Append image file if present so server can persist it
        try {
            const imgInput = document.getElementById('attractionImageInput');
            if (imgInput && imgInput.files && imgInput.files[0]) {
                formData.append('attraction_image', imgInput.files[0]);
            }
        } catch (e) {
            console.warn('No image to append', e);
        }
        fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    showToast('Failed to save: ' + (data.error || 'Unknown error'), 'error');
                    return;
                }
                // Update selected tile label
                const sel = document.querySelector('.attraction-thumb.selected .attraction-label');
                if (sel) sel.textContent = name || data.ride_name || sel.textContent;
                // If server returned an image URL, update the tile background
                if (data.ride_image_url) {
                    const tile = document.querySelector('.attraction-thumb.selected') || document
                        .querySelector('[data-id="ride' + currentRideId + '"]');
                    if (tile) {
                        const thumb = tile.querySelector('.thumb-bg');
                        if (thumb) {
                            thumb.style.backgroundImage = 'url("' + data.ride_image_url + '")';
                            thumb.style.backgroundSize = 'cover';
                            thumb.style.backgroundPosition = 'center';
                            thumb.style.backgroundRepeat = 'no-repeat';
                            const sv = thumb.querySelector('svg');
                            if (sv) sv.style.display = 'none';
                        }
                    }
                    // update tile attributes for status/link and refresh lock state
                    try {
                        if (tile) {
                            tile.setAttribute('data-status', status);
                            tile.setAttribute('data-link', rideLink);
                        }
                    } catch (e) {}
                    updateMaintenanceLocking();
                    // Also update preview img
                    const preview = document.getElementById('attractionImagePreview');
                    const placeholder = document.getElementById('attractionImagePlaceholder');
                    if (preview) {
                        preview.src = data.ride_image_url;
                        preview.style.display = 'block';
                        if (placeholder) placeholder.style.display = 'none';
                    }
                } else {
                    // even if no image returned, ensure status/link are stored and lock state updated
                    try {
                        const tile = document.querySelector('.attraction-thumb.selected') || document
                            .querySelector('[data-id="ride' + currentRideId + '"]');
                        if (tile) {
                            tile.setAttribute('data-status', status);
                            tile.setAttribute('data-link', rideLink);
                        }
                    } catch (e) {}
                    updateMaintenanceLocking();
                }
                showToast('Settings saved', 'success');
            })
            .catch(err => {
                console.error('Save error:', err);
                showToast('Failed to save settings.', 'error');
            });
    });
    // Discard changes handler — reload saved data for current ride
    document.getElementById('discardBtn').addEventListener('click', function() {
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
        if (savedSnapshot && savedSnapshot.ride && parseInt(savedSnapshot.ride.ride_id, 10) === parseInt(
                currentRideId, 10)) {
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
                try {
                    mainPosSelect.value = ride.ride_main_pos_id;
                } catch (e) {}
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
                        try {
                            mainPosSelect.value = data.ride.ride_main_pos_id;
                        } catch (e) {}
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
    document.getElementById('resetDefaultsBtn').addEventListener('click', function() {
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
            try {
                mainPosSelect.value = ride.ride_main_pos_id;
            } catch (e) {}
        }
        // Update left tile label if present
        const tile = document.querySelector('.attraction-thumb.selected') || document.querySelector(
            '[data-id="ride' + currentRideId + '"]');
        if (tile) {
            const label = tile.querySelector('.attraction-label');
            if (label) label.textContent = ride.ride_name || label.textContent;
        }
        showToast('Defaults restored', 'info');
    });
    // Delete attraction handler — confirm by typing the attraction name, then call API
    document.getElementById('deleteBtn').addEventListener('click', function() {
        if (!currentRideId) {
            showToast('No attraction selected', 'error');
            return;
        }
        const currentName = (document.getElementById('attractionName') && document.getElementById(
            'attractionName').value) ? document.getElementById('attractionName').value.trim() : (
            savedSnapshot && savedSnapshot.ride ? (savedSnapshot.ride.ride_name || '') : '');
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
            fetch('api.php', {
                    method: 'POST',
                    body: formData
                })
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
                    const nameEl = document.getElementById('attractionName');
                    if (nameEl) nameEl.value = '';
                    const posList = document.getElementById('positionList');
                    if (posList) posList.innerHTML = '';
                    const mainPosSelect = document.getElementById('mainPosition');
                    if (mainPosSelect) mainPosSelect.innerHTML = '';
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
    #toastContainer {
        position: fixed;
        left: 50%;
        bottom: 22px;
        transform: translateX(-50%);
        z-index: 10000;
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: center;
        pointer-events: none;
    }

    .toast {
        pointer-events: auto;
        min-width: 160px;
        max-width: 360px;
        padding: 10px 14px;
        border-radius: 8px;
        color: #fff;
        font-weight: 600;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        background: #333;
        opacity: 0;
    }

    .toast.success {
        background: linear-gradient(90deg, #12b886, #07924b);
    }

    .toast.info {
        background: linear-gradient(90deg, #2b8cff, #1565c0);
    }

    .toast.error {
        background: linear-gradient(90deg, #ff6b6b, #d64545);
    }

    /* Input modal styles */
    .input-overlay {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.35);
        z-index: 10005;
    }

    .input-modal {
        background: #fff;
        padding: 18px;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        width: 360px;
        max-width: 92%;
    }

    .input-title {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .input-field {
        width: 100%;
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .input-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .input-actions .btn {
        padding: 6px 10px;
        font-size: 13px;
    }

    /* Ensure modal and input text is readable (black) */
    .input-modal,
    .input-modal .input-title {
        color: #000;
    }

    .input-field {
        color: #000;
    }

    /* Zone lock indicator in sidebar */
    .zone-lock-indicator {
        display: inline-block;
        width: 14px;
        height: 14px;
        margin-left: 6px;
        vertical-align: middle;
        opacity: 0.9;
        color: #d64545;
    }

    .zone-lock-indicator svg {
        display: block;
    }

    /* Make form inputs and textarea text black for clarity */
    #positionList .position-row input,
    #positionList .position-row input::placeholder,
    input[type="text"],
    select,
    textarea {
        color: #000;
    }
    </style>
</body>

</html>