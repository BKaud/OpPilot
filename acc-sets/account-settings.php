<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OPilot – Account Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="style.css?v=2" />
</head>
<body>
<?php
require_once __DIR__ . '/../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require_once APP_ROOT . '/partials/sidebar.php';

$username = $_SESSION['user'] ?? 'Guest';

// Load all zones for zone-specific widget configs
$zones = [];
if (isset($mysqli) && $mysqli) {
    $r = $mysqli->query('SELECT zone_id, zone_name FROM zone ORDER BY zone_name');
    if ($r) while ($row = $r->fetch_assoc()) $zones[] = $row;
}

// ── All available widgets definition ─────────────────────────
$widget_def = [
    'current_time'  => ['label' => 'Current Time',        'icon' => '⏱', 'config' => []],
    'current_date'  => ['label' => 'Current Date',        'icon' => '📅', 'config' => []],
    'current_user'  => ['label' => 'Current User',        'icon' => '👤', 'config' => []],
    'ride_status'   => ['label' => 'Ride Status',         'icon' => '🎢', 'config' => ['zone_id', 'ride_id']],
    'open_rides'    => ['label' => 'Open Rides Count',    'icon' => '✅', 'config' => []],
    'zone_lead'     => ['label' => 'Zone Lead',           'icon' => '⭐', 'config' => ['zone_id']],
    'zone_rotation' => ['label' => 'Zone Rotation Timer', 'icon' => '🔄', 'config' => ['zone_id']],
    'org_name'      => ['label' => 'Organisation Name',   'icon' => '🏢', 'config' => []],
    'quick_link'    => ['label' => 'Quick Link',          'icon' => '🔗', 'config' => ['label', 'url']],
];

// ── Rides grouped by zone (for ride_status widget picker) ────
$zone_rides = []; // [zone_id => [['ride_id'=>int,'ride_name'=>str], ...]]
if (isset($mysqli) && $mysqli) {
    $r = $mysqli->query(
        'SELECT zr.zone_ride_zone_id AS zone_id, r.ride_id, r.ride_name
         FROM zone_ride zr
         JOIN ride r ON r.ride_id = zr.zone_ride_ride_id
         ORDER BY zr.zone_ride_zone_id, r.ride_name'
    );
    if ($r) {
        while ($row = $r->fetch_assoc()) {
            $zid = (int)$row['zone_id'];
            $zone_rides[$zid][] = ['ride_id' => (int)$row['ride_id'], 'ride_name' => $row['ride_name']];
        }
    }
}
?>

<!-- CONTENT -->
<div class="content">

    <div class="page-header">
        <div>
            <h1>Account Settings</h1>
            <div class="breadcrumb">Account › <span>Settings</span></div>
        </div>
    </div>

    <div class="acc-body">

        <!-- ── Profile ──────────────────────────────────────── -->
        <section class="acc-section acc-section--profile">
            <div class="acc-section-head">
                <div class="acc-section-title">Profile</div>
                <div class="acc-section-sub">Your display name, profile picture, job title, and permission groups.</div>
            </div>

            <div class="prof-box" id="profBox">
                <!-- Avatar -->
                <div class="prof-avatar-wrap">
                    <div class="prof-avatar" id="profAvatar">
                        <span class="prof-initials" id="profInitials">?</span>
                        <img id="profAvatarImg" class="prof-avatar-img" src="" alt="Profile picture" style="display:none;" />
                    </div>
                    <label class="prof-avatar-edit" title="Change profile picture">
                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                        <input type="file" id="profPicInput" accept="image/jpeg,image/png,image/gif,image/webp" style="display:none;" />
                    </label>
                </div>

                <!-- Info -->
                <div class="prof-info">
                    <!-- Name display / edit -->
                    <div class="prof-name-row" id="profNameDisplay">
                        <span class="prof-name" id="profName">Loading…</span>
                        <button class="prof-icon-btn" id="profNameEditBtn" title="Edit name">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                        </button>
                    </div>
                    <div class="prof-name-edit" id="profNameEdit" style="display:none;">
                        <input type="text" class="prof-input" id="profNameInput" maxlength="100" placeholder="Display name" />
                        <button class="prof-save-btn" id="profNameSaveBtn">Save</button>
                        <button class="prof-cancel-btn" id="profNameCancelBtn">Cancel</button>
                    </div>

                    <!-- Job title -->
                    <div class="prof-role" id="profRole"></div>

                    <!-- Permission groups -->
                    <div class="prof-perms" id="profPerms"></div>

                    <!-- Theme color -->
                    <div class="prof-theme" id="profTheme">
                        <label class="prof-theme-label" for="profColorInput">Primary Color</label>
                        <div class="prof-theme-controls">
                            <input type="color" id="profColorInput" class="prof-color-input" value="#1a8f7a" aria-label="Primary color" />
                            <input type="text" id="profColorHex" class="prof-color-hex" value="#1A8F7A" maxlength="7" aria-label="Primary color hex" />
                            <button class="prof-save-btn" id="profColorSaveBtn" type="button">Save</button>
                        </div>
                    </div>

                    <form class="prof-logout-form" id="logoutForm" method="post" action="<?php echo htmlspecialchars(url_path('login/logout.php')); ?>">
                        <button class="prof-logout-btn" type="button" id="logoutBtn">Log Out</button>
                    </form>

                    <!-- Logout confirmation modal -->
                    <div id="logoutModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);display:none;align-items:center;justify-content:center;">
                        <div style="background:var(--card-bg,#1e1e2e);border:1px solid var(--border,#333);border-radius:12px;padding:2rem 2.5rem;min-width:300px;max-width:90vw;text-align:center;box-shadow:0 8px 32px rgba(0,0,0,0.4);">
                            <p style="margin:0 0 1.5rem;font-size:1rem;color:var(--text,#eee);">Are you sure you want to log out?</p>
                            <div style="display:flex;gap:.75rem;justify-content:center;">
                                <button id="logoutConfirmBtn" style="padding:.5rem 1.4rem;border-radius:8px;border:none;background:var(--accent,#1a8f7a);color:#fff;font-size:.9rem;cursor:pointer;">Log Out</button>
                                <button id="logoutCancelBtn" style="padding:.5rem 1.4rem;border-radius:8px;border:1px solid var(--border,#333);background:transparent;color:var(--text,#eee);font-size:.9rem;cursor:pointer;">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- ── Navbar Widget Configuration ──────────────────── -->
        <section class="acc-section acc-section--widgets">
            <div class="acc-section-head">
                <div class="acc-section-title">Navbar Widgets</div>
                <div class="acc-section-sub">Assign up to 9 widgets to slots in the bar that appears below the navbar. Leave a slot empty to hide it.</div>
            </div>

            <div class="widget-config-grid" id="widgetConfigGrid">
                <?php for ($i = 1; $i <= 9; $i++): ?>
                <div class="wc-slot" data-slot="<?php echo $i; ?>">
                    <div class="wc-slot-num"><?php echo $i; ?></div>

                    <select class="wc-select" data-slot="<?php echo $i; ?>" aria-label="Slot <?php echo $i; ?> widget">
                        <option value="">— Empty —</option>
                        <?php foreach ($widget_def as $key => $def): ?>
                        <option value="<?php echo $key; ?>"><?php echo $def['icon'] . ' ' . $def['label']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Zone picker (zone_lead, zone_rotation) -->
                    <div class="wc-extra wc-extra--zone" data-slot="<?php echo $i; ?>" style="display:none;">
                        <label class="wc-label">Zone</label>
                        <select class="wc-zone-id" aria-label="Zone">
                            <?php foreach ($zones as $z): ?>
                            <option value="<?php echo (int)$z['zone_id']; ?>"><?php echo htmlspecialchars($z['zone_name']); ?></option>
                            <?php endforeach; ?>
                            <?php if (empty($zones)): ?>
                            <option value="1">Zone 1</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Ride picker (ride_status) -->
                    <div class="wc-extra wc-extra--ride" data-slot="<?php echo $i; ?>" style="display:none;">
                        <label class="wc-label">Ride</label>
                        <select class="wc-ride-id" aria-label="Ride">
                            <option value="">— Select ride —</option>
                        </select>
                    </div>

                    <!-- Quick link config -->
                    <div class="wc-extra wc-extra--link" data-slot="<?php echo $i; ?>" style="display:none;">
                        <label class="wc-label">Label</label>
                        <input type="text" class="wc-link-label" placeholder="My Page" aria-label="Link label" />
                        <label class="wc-label" style="margin-top:4px;">URL</label>
                        <input type="text" class="wc-link-url" placeholder="/OpPilot/page.php" aria-label="Link URL" />
                    </div>
                </div>
                <?php endfor; ?>
            </div>

            <div class="wc-actions">
                <button class="wc-save-btn" id="wcSaveBtn" type="button">Save Widget Layout</button>
                <span class="wc-save-msg" id="wcSaveMsg"></span>
            </div>
        </section>

    </div><!-- /.acc-body -->

</div><!-- /.content -->
</div><!-- /.main -->

<script>
// ── Logout confirmation ───────────────────────────────────────
(function () {
    var modal      = document.getElementById('logoutModal');
    var logoutBtn  = document.getElementById('logoutBtn');
    var confirmBtn = document.getElementById('logoutConfirmBtn');
    var cancelBtn  = document.getElementById('logoutCancelBtn');

    logoutBtn.addEventListener('click', function () {
        modal.style.display = 'flex';
    });
    cancelBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });
    modal.addEventListener('click', function (e) {
        if (e.target === modal) modal.style.display = 'none';
    });
    confirmBtn.addEventListener('click', function () {
        document.getElementById('logoutForm').submit();
    });
})();

(function () {
    var WIDGET_API  = '<?php echo htmlspecialchars(url_path("acc-sets/navbar-api.php")); ?>';
    var PROFILE_API = '<?php echo htmlspecialchars(url_path("acc-sets/profile-api.php")); ?>';

    // Rides keyed by zone_id, pre-loaded from server
    var zoneRides = <?php echo json_encode($zone_rides); ?>;

    var widgetConfigs = <?php echo json_encode(array_map(function($k, $v){
        return ['key' => $k, 'config_fields' => $v['config']];
    }, array_keys($widget_def), $widget_def)); ?>;

    // Build a map: widget_key → config_fields[]
    var configMap = {};
    widgetConfigs.forEach(function(w){ configMap[w.key] = w.config_fields; });

    // ── Populate ride dropdown for a slot based on zone ───────
    function populateRides(slotEl, zoneId, selectedRideId) {
        var rideSelect = slotEl.querySelector('.wc-ride-id');
        rideSelect.innerHTML = '<option value="">— Select ride —</option>';
        var rides = zoneRides[zoneId] || [];
        rides.forEach(function(r) {
            var opt = document.createElement('option');
            opt.value = r.ride_id;
            opt.textContent = r.ride_name;
            if (selectedRideId && String(r.ride_id) === String(selectedRideId)) opt.selected = true;
            rideSelect.appendChild(opt);
        });
    }

    // ── Show/hide extra config fields when select changes ─────
    function applyExtras(slotEl, key) {
        var fields   = configMap[key] || [];
        var zoneDiv  = slotEl.querySelector('.wc-extra--zone');
        var rideDiv  = slotEl.querySelector('.wc-extra--ride');
        var linkDiv  = slotEl.querySelector('.wc-extra--link');
        zoneDiv.style.display = fields.indexOf('zone_id') !== -1 ? '' : 'none';
        rideDiv.style.display = fields.indexOf('ride_id') !== -1 ? '' : 'none';
        linkDiv.style.display = (fields.indexOf('label') !== -1 || fields.indexOf('url') !== -1) ? '' : 'none';
    }

    document.querySelectorAll('.wc-select').forEach(function(sel) {
        var slotEl = sel.closest('.wc-slot');
        sel.addEventListener('change', function() { applyExtras(slotEl, sel.value); });
    });

    // When zone changes for a ride_status slot, refresh the ride list
    document.querySelectorAll('.wc-zone-id').forEach(function(zoneSel) {
        var slotEl = zoneSel.closest('.wc-slot');
        zoneSel.addEventListener('change', function() {
            var key = slotEl.querySelector('.wc-select').value;
            if (configMap[key] && configMap[key].indexOf('ride_id') !== -1) {
                populateRides(slotEl, zoneSel.value, null);
            }
        });
    });

    // ── Load saved widget prefs and populate UI ───────────────
    fetch(WIDGET_API + '?action=load')
        .then(function(r){ return r.ok ? r.json() : []; })
        .then(function(slots) {
            slots.forEach(function(slot, i) {
                var idx    = slot.slot_index || (i + 1);
                var slotEl = document.querySelector('.wc-slot[data-slot="' + idx + '"]');
                if (!slotEl) return;
                var sel = slotEl.querySelector('.wc-select');
                sel.value = slot.widget_key || '';
                applyExtras(slotEl, sel.value);

                var cfg = slot.widget_config || {};
                if (cfg.zone_id) {
                    slotEl.querySelector('.wc-zone-id').value = cfg.zone_id;
                    // If ride_id is also expected, populate rides then set value
                    if (configMap[sel.value] && configMap[sel.value].indexOf('ride_id') !== -1) {
                        populateRides(slotEl, cfg.zone_id, cfg.ride_id || null);
                    }
                }
                if (cfg.label) slotEl.querySelector('.wc-link-label').value = cfg.label;
                if (cfg.url)   slotEl.querySelector('.wc-link-url').value   = cfg.url;
            });
        })
        .catch(function() {});

    // ── Save widget layout ────────────────────────────────────
    document.getElementById('wcSaveBtn').addEventListener('click', function() {
        var payload = [];
        for (var i = 1; i <= 9; i++) {
            var slotEl = document.querySelector('.wc-slot[data-slot="' + i + '"]');
            var key    = slotEl.querySelector('.wc-select').value || null;
            var cfg    = null;

            if (key) {
                var fields = configMap[key] || [];
                cfg = {};
                if (fields.indexOf('zone_id') !== -1) cfg.zone_id = parseInt(slotEl.querySelector('.wc-zone-id').value, 10) || 1;
                if (fields.indexOf('ride_id') !== -1) cfg.ride_id = parseInt(slotEl.querySelector('.wc-ride-id').value, 10) || 0;
                if (fields.indexOf('label')   !== -1) cfg.label   = slotEl.querySelector('.wc-link-label').value.trim();
                if (fields.indexOf('url')     !== -1) cfg.url     = slotEl.querySelector('.wc-link-url').value.trim();
                if (Object.keys(cfg).length === 0) cfg = null;
            }

            payload.push({ slot_index: i, widget_key: key, widget_config: cfg });
        }

        var btn = document.getElementById('wcSaveBtn');
        var msg = document.getElementById('wcSaveMsg');
        btn.disabled = true;
        msg.textContent = 'Saving…';
        msg.className = 'wc-save-msg';

        fetch(WIDGET_API + '?action=save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(function(r){ return r.json(); })
        .then(function(data) {
            if (data.ok) {
                msg.textContent = 'Saved! Reload the page to see changes in the widget bar.';
                msg.className = 'wc-save-msg wc-save-msg--ok';
            } else {
                msg.textContent = 'Error: ' + (data.error || 'Unknown error');
                msg.className = 'wc-save-msg wc-save-msg--err';
            }
        })
        .catch(function() {
            msg.textContent = 'Network error – could not save.';
            msg.className = 'wc-save-msg wc-save-msg--err';
        })
        .finally(function() { btn.disabled = false; });
    });

    // ═══════════════════════════════════════════════════════════
    // ── Profile Section ────────────────────────────────────────
    // ═══════════════════════════════════════════════════════════

    var profName        = document.getElementById('profName');
    var profInitials    = document.getElementById('profInitials');
    var profAvatarImg   = document.getElementById('profAvatarImg');
    var profRole        = document.getElementById('profRole');
    var profPerms       = document.getElementById('profPerms');
    var profStatusMsg   = document.getElementById('profStatusMsg');
    var profNameDisplay = document.getElementById('profNameDisplay');
    var profNameEdit    = document.getElementById('profNameEdit');
    var profNameInput   = document.getElementById('profNameInput');
    var profPicInput    = document.getElementById('profPicInput');
    var profColorInput  = document.getElementById('profColorInput');
    var profColorHex    = document.getElementById('profColorHex');
    var profColorSaveBtn= document.getElementById('profColorSaveBtn');

    function normalizeHexColor(hex, fallback) {
        var value = (hex || '').trim().toUpperCase();
        return /^#[0-9A-F]{6}$/.test(value) ? value : fallback;
    }

    function mixHex(hex, mix, ratio) {
        var c = hex.replace('#', '');
        var r = parseInt(c.slice(0, 2), 16);
        var g = parseInt(c.slice(2, 4), 16);
        var b = parseInt(c.slice(4, 6), 16);
        var rr = Math.round(r * (1 - ratio) + mix[0] * ratio);
        var gg = Math.round(g * (1 - ratio) + mix[1] * ratio);
        var bb = Math.round(b * (1 - ratio) + mix[2] * ratio);
        return '#' + [rr, gg, bb].map(function(n){ return n.toString(16).padStart(2, '0'); }).join('');
    }

    function hexToRgba(hex, alpha) {
        var c = hex.replace('#', '');
        var r = parseInt(c.slice(0, 2), 16);
        var g = parseInt(c.slice(2, 4), 16);
        var b = parseInt(c.slice(4, 6), 16);
        return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
    }

    function applyThemeColor(hex) {
        var root = document.documentElement;
        root.style.setProperty('--teal', hex);
        root.style.setProperty('--teal-light', mixHex(hex, [255, 255, 255], 0.18));
        root.style.setProperty('--teal-glow', hexToRgba(hex, 0.18));
        root.style.setProperty('--teal-dim', hexToRgba(hex, 0.08));
    }

    function getInitials(name) {
        if (!name) return '?';
        var parts = name.trim().split(/\s+/);
        return parts.length >= 2
            ? (parts[0][0] + parts[parts.length - 1][0]).toUpperCase()
            : name.slice(0, 2).toUpperCase();
    }

    function setProfilePic(url) {
        if (url) {
            profAvatarImg.src = url;
            profAvatarImg.style.display = '';
            profInitials.style.display = 'none';
        } else {
            profAvatarImg.style.display = 'none';
            profInitials.style.display = '';
        }
    }

    function showProfMsg(text, isErr) {
        profStatusMsg.textContent = text;
        profStatusMsg.className = 'prof-status-msg' + (isErr ? ' prof-status-msg--err' : ' prof-status-msg--ok');
        if (text) setTimeout(function() { profStatusMsg.textContent = ''; profStatusMsg.className = 'prof-status-msg'; }, 4000);
    }

    // Load profile data
    fetch(PROFILE_API + '?action=load')
        .then(function(r){ return r.ok ? r.json() : {}; })
        .then(function(data) {
            var name = data.acc_name || '';
            profName.textContent = name || '—';
            profNameInput.value  = name;
            profInitials.textContent = getInitials(name);
            setProfilePic(data.acc_profile_pic || null);

            var startColor = normalizeHexColor(data.acc_primary_color, '#1A8F7A');
            profColorHex.value = startColor;
            profColorInput.value = startColor;
            applyThemeColor(startColor);

            var roleText = [];
            if (data.acc_job_title) roleText.push(data.acc_job_title);
            if (data.acc_tier)      roleText.push(data.acc_tier);
            profRole.textContent = roleText.join(' · ') || 'No title set';

            if (data.perms && data.perms.length > 0) {
                var html = '<span class="prof-perms-label">Permission groups:</span>';
                data.perms.forEach(function(p) {
                    html += ' <span class="prof-perm-badge">' + p + '</span>';
                });
                profPerms.innerHTML = html;
            } else {
                profPerms.innerHTML = '<span class="prof-perms-label" style="opacity:0.5;">No groups assigned</span>';
            }
        })
        .catch(function() { profName.textContent = '—'; });

    // Edit name
    document.getElementById('profNameEditBtn').addEventListener('click', function() {
        profNameDisplay.style.display = 'none';
        profNameEdit.style.display = 'flex';
        profNameInput.focus();
    });

    document.getElementById('profNameCancelBtn').addEventListener('click', function() {
        profNameEdit.style.display = 'none';
        profNameDisplay.style.display = 'flex';
    });

    document.getElementById('profNameSaveBtn').addEventListener('click', function() {
        var newName = profNameInput.value.trim();
        if (!newName) return;
        var btn = this;
        btn.disabled = true;
        fetch(PROFILE_API + '?action=save_name', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ acc_name: newName })
        })
        .then(function(r){ return r.json(); })
        .then(function(data) {
            if (data.ok) {
                profName.textContent = newName;
                profInitials.textContent = getInitials(newName);
                profNameEdit.style.display = 'none';
                profNameDisplay.style.display = 'flex';
                showProfMsg('Name updated.', false);
            } else {
                showProfMsg('Error: ' + (data.error || 'Unknown'), true);
            }
        })
        .catch(function() { showProfMsg('Network error.', true); })
        .finally(function() { btn.disabled = false; });
    });

    // Profile picture upload
    profPicInput.addEventListener('change', function() {
        if (!this.files || !this.files[0]) return;
        var fd = new FormData();
        fd.append('pic', this.files[0]);
        showProfMsg('Uploading…', false);
        fetch(PROFILE_API + '?action=save_pic', { method: 'POST', body: fd })
            .then(function(r){ return r.json(); })
            .then(function(data) {
                if (data.ok) {
                    setProfilePic(data.url);
                    showProfMsg('Profile picture updated.', false);
                } else {
                    showProfMsg('Error: ' + (data.error || 'Unknown'), true);
                }
            })
            .catch(function() { showProfMsg('Upload failed.', true); });
        this.value = '';
    });

    // Color picker + hex input sync
    profColorInput.addEventListener('input', function() {
        profColorHex.value = normalizeHexColor(profColorInput.value, '#1A8F7A');
        applyThemeColor(profColorHex.value);
    });

    profColorHex.addEventListener('input', function() {
        var cleaned = ('#' + profColorHex.value.replace(/[^0-9a-fA-F]/g, '').replace(/^#/, '').slice(0, 6)).toUpperCase();
        if (cleaned.length <= 7) profColorHex.value = cleaned;
        var normalized = normalizeHexColor(cleaned, '');
        if (normalized) {
            profColorInput.value = normalized;
            applyThemeColor(normalized);
        }
    });

    profColorSaveBtn.addEventListener('click', function() {
        var color = normalizeHexColor(profColorHex.value, '');
        if (!color) {
            showProfMsg('Please enter a valid hex color like #1A8F7A.', true);
            return;
        }

        profColorSaveBtn.disabled = true;
        fetch(PROFILE_API + '?action=save_color', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ acc_primary_color: color })
        })
        .then(function(r){ return r.json(); })
        .then(function(data) {
            if (data.ok) {
                var saved = normalizeHexColor(data.acc_primary_color, color);
                profColorHex.value = saved;
                profColorInput.value = saved;
                applyThemeColor(saved);
                showProfMsg('Primary color updated.', false);
            } else {
                showProfMsg('Error: ' + (data.error || 'Unknown'), true);
            }
        })
        .catch(function() { showProfMsg('Network error.', true); })
        .finally(function() { profColorSaveBtn.disabled = false; });
    });
})();
</script>

</body>
</html>
