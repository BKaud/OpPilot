<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OPilot – Account Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="style.css" />
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
    'current_time'  => ['label' => 'Current Time',       'icon' => '⏱', 'config' => []],
    'current_date'  => ['label' => 'Current Date',       'icon' => '📅', 'config' => []],
    'current_user'  => ['label' => 'Current User',       'icon' => '👤', 'config' => []],
    'ride_status'   => ['label' => 'Ride Status Summary','icon' => '🎢', 'config' => []],
    'open_rides'    => ['label' => 'Open Rides Count',   'icon' => '✅', 'config' => []],
    'zone_lead'     => ['label' => 'Zone Lead',          'icon' => '⭐', 'config' => ['zone_id']],
    'zone_rotation' => ['label' => 'Zone Rotation Timer','icon' => '🔄', 'config' => ['zone_id', 'minutes']],
    'org_name'      => ['label' => 'Organisation Name',  'icon' => '🏢', 'config' => []],
    'quick_link'    => ['label' => 'Quick Link',         'icon' => '🔗', 'config' => ['label', 'url']],
];
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

        <!-- ── Navbar Widget Configuration ──────────────────── -->
        <section class="acc-section">
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

                    <!-- Minutes picker (zone_rotation) -->
                    <div class="wc-extra wc-extra--minutes" data-slot="<?php echo $i; ?>" style="display:none;">
                        <label class="wc-label">Interval (mins)</label>
                        <input type="number" class="wc-minutes" min="1" max="480" value="30" aria-label="Rotation minutes" />
                    </div>

                    <!-- Quick link config -->
                    <div class="wc-extra wc-extra--link" data-slot="<?php echo $i; ?>" style="display:none;">
                        <label class="wc-label">Label</label>
                        <input type="text" class="wc-link-label" placeholder="My Page" aria-label="Link label" />
                        <label class="wc-label" style="margin-top:4px;">URL</label>
                        <input type="text" class="wc-link-url" placeholder="/OPilot/page.php" aria-label="Link URL" />
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
(function () {
    var API_BASE = '<?php echo htmlspecialchars(url_path("acc-sets/navbar-api.php")); ?>';

    var widgetConfigs = <?php echo json_encode(array_map(function($k, $v){ return ['key' => $k, 'config_fields' => $v['config']]; }, array_keys($widget_def), $widget_def)); ?>;

    // Build a map: widget_key → config_fields[]
    var configMap = {};
    widgetConfigs.forEach(function(w){ configMap[w.key] = w.config_fields; });

    // ── Show/hide extra config fields when select changes ─────
    function applyExtras(slotEl, key) {
        var fields    = configMap[key] || [];
        var zoneDiv   = slotEl.querySelector('.wc-extra--zone');
        var minsDiv   = slotEl.querySelector('.wc-extra--minutes');
        var linkDiv   = slotEl.querySelector('.wc-extra--link');
        zoneDiv.style.display  = fields.indexOf('zone_id')  !== -1 ? '' : 'none';
        minsDiv.style.display  = fields.indexOf('minutes')  !== -1 ? '' : 'none';
        linkDiv.style.display  = (fields.indexOf('label') !== -1 || fields.indexOf('url') !== -1) ? '' : 'none';
    }

    document.querySelectorAll('.wc-select').forEach(function(sel) {
        var slot = sel.closest('.wc-slot');
        sel.addEventListener('change', function() { applyExtras(slot, sel.value); });
    });

    // ── Load saved prefs and populate UI ─────────────────────
    fetch(API_BASE + '?action=load')
        .then(function(r){ return r.ok ? r.json() : []; })
        .then(function(slots) {
            slots.forEach(function(slot, i) {
                var idx  = slot.slot_index || (i + 1);
                var slotEl = document.querySelector('.wc-slot[data-slot="' + idx + '"]');
                if (!slotEl) return;
                var sel = slotEl.querySelector('.wc-select');
                sel.value = slot.widget_key || '';
                applyExtras(slotEl, sel.value);

                var cfg = slot.widget_config || {};
                if (cfg.zone_id)  slotEl.querySelector('.wc-zone-id').value    = cfg.zone_id;
                if (cfg.minutes)  slotEl.querySelector('.wc-minutes').value     = cfg.minutes;
                if (cfg.label)    slotEl.querySelector('.wc-link-label').value  = cfg.label;
                if (cfg.url)      slotEl.querySelector('.wc-link-url').value    = cfg.url;
            });
        })
        .catch(function() {});

    // ── Save ─────────────────────────────────────────────────
    document.getElementById('wcSaveBtn').addEventListener('click', function() {
        var payload = [];
        for (var i = 1; i <= 9; i++) {
            var slotEl = document.querySelector('.wc-slot[data-slot="' + i + '"]');
            var key    = slotEl.querySelector('.wc-select').value || null;
            var cfg    = null;

            if (key) {
                var fields = configMap[key] || [];
                cfg = {};
                if (fields.indexOf('zone_id')  !== -1) cfg.zone_id  = parseInt(slotEl.querySelector('.wc-zone-id').value, 10) || 1;
                if (fields.indexOf('minutes')  !== -1) cfg.minutes  = parseInt(slotEl.querySelector('.wc-minutes').value,  10) || 30;
                if (fields.indexOf('label')    !== -1) cfg.label    = slotEl.querySelector('.wc-link-label').value.trim();
                if (fields.indexOf('url')      !== -1) cfg.url      = slotEl.querySelector('.wc-link-url').value.trim();
                if (Object.keys(cfg).length === 0) cfg = null;
            }

            payload.push({ slot_index: i, widget_key: key, widget_config: cfg });
        }

        var btn = document.getElementById('wcSaveBtn');
        var msg = document.getElementById('wcSaveMsg');
        btn.disabled = true;
        msg.textContent = 'Saving…';
        msg.className = 'wc-save-msg';

        fetch(API_BASE + '?action=save', {
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
})();
</script>

</body>
</html>
