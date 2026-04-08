<?php
/**
 * partials/navbar-widgets.php
 *
 * Renders the customisable widget bar that appears below the main navbar.
 * Expects bootstrap.php to have been included (provides $mysqli, BASE_PATH).
 * Reads the user's saved slot layout from navbar_prefs, then outputs HTML for
 * each occupied slot.  Empty slots are hidden.
 *
 * Available widget keys:
 *   current_time    – live clock with seconds (JS)
 *   current_date    – today's date
 *   current_user    – logged-in user name from session
 *   ride_status     – up / maint / down counts
 *   open_rides      – count of rides with status = 'up'
 *   zone_lead       – lead staff member of a zone  (config: zone_id)
 *   zone_rotation   – countdown timer (config: minutes)
 *   org_name        – organisation name
 *   quick_link      – custom link  (config: label, url)
 */

if (session_status() === PHP_SESSION_NONE) session_start();

$nb_user = $_SESSION['user'] ?? null;

// ── Default slot layout (all empty) ──────────────────────────
$nb_slots = array_fill(1, 9, ['widget_key' => null, 'widget_config' => null]);

// ── Load user prefs from DB ───────────────────────────────────
if ($nb_user && isset($mysqli) && $mysqli) {
    $stmt = $mysqli->prepare(
        'SELECT slot_index, widget_key, widget_config FROM navbar_prefs WHERE pref_username = ? ORDER BY slot_index'
    );
    if ($stmt) {
        $stmt->bind_param('s', $nb_user);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $idx = (int)$row['slot_index'];
            if ($idx >= 1 && $idx <= 9) {
                $nb_slots[$idx] = [
                    'widget_key'    => $row['widget_key'],
                    'widget_config' => $row['widget_config'] ? json_decode($row['widget_config'], true) : [],
                ];
            }
        }
        $stmt->close();
    }
}

// ── Pre-fetch data needed by widgets ─────────────────────────
$nb_ride_counts    = ['up' => 0, 'maint' => 0, 'down' => 0];
$nb_rides          = [];   // [ride_id => ['name'=>str,'status'=>str]]
$nb_org_name       = null;
$nb_zone_leads     = [];   // [zone_id => acc_name]
$nb_zones_list     = [];   // [zone_id => zone_name]
$nb_zone_rotation  = [];   // [zone_id => ['mins'=>int,'start'=>str|null]]

// Check which widgets are actually in use
$active_keys = array_column(array_values($nb_slots), 'widget_key');

if (isset($mysqli) && $mysqli) {

    if (in_array('ride_status', $active_keys) || in_array('open_rides', $active_keys)) {
        // Aggregate counts for the summary variant
        $r = $mysqli->query("SELECT ride_status, COUNT(*) AS cnt FROM ride GROUP BY ride_status");
        if ($r) {
            while ($row = $r->fetch_assoc()) {
                $nb_ride_counts[$row['ride_status']] = (int)$row['cnt'];
            }
        }
        // Individual ride data for the specific-ride variant
        $r = $mysqli->query("SELECT ride_id, ride_name, ride_status FROM ride");
        if ($r) {
            while ($row = $r->fetch_assoc()) {
                $nb_rides[(int)$row['ride_id']] = [
                    'name'   => $row['ride_name'],
                    'status' => $row['ride_status'],
                ];
            }
        }
    }

    if (in_array('org_name', $active_keys) && isset($_SESSION['org_id'])) {
        $org_id = (int)$_SESSION['org_id'];
        $stmt = $mysqli->prepare("SELECT org_name FROM organization WHERE org_id = ?");
        if ($stmt) {
            $stmt->bind_param('i', $org_id);
            $stmt->execute();
            $stmt->bind_result($nb_org_name);
            $stmt->fetch();
            $stmt->close();
        }
    }

    if (in_array('zone_lead', $active_keys) || in_array('zone_rotation', $active_keys)) {
        // Load zone names + rotation settings (columns added by profile_rotation_migration.sql)
        $r = $mysqli->query(
            "SELECT zone_id, zone_name,
                    COALESCE(zone_rotation_mins, 30) AS zone_rotation_mins,
                    zone_rotation_start
             FROM zone"
        );
        if ($r) {
            while ($row = $r->fetch_assoc()) {
                $zid = (int)$row['zone_id'];
                $nb_zones_list[$zid]    = $row['zone_name'];
                $nb_zone_rotation[$zid] = [
                    'mins'  => max(1, (int)$row['zone_rotation_mins']),
                    'start' => $row['zone_rotation_start'],
                ];
            }
        }
        // Lead = first staffed ride_pos in the zone's rides (posholder with lowest pos_order)
        $r = $mysqli->query(
            "SELECT zr.zone_ride_zone_id AS zone_id, a.acc_name
             FROM zone_ride zr
             JOIN ride_pos rp ON rp.ride_pos_ride_id = zr.zone_ride_ride_id
             JOIN position  p  ON p.pos_id            = rp.ride_pos_pos_id
             JOIN account   a  ON a.account_id         = rp.ride_pos_posholder
             WHERE rp.ride_pos_posholder IS NOT NULL
             ORDER BY zr.zone_ride_zone_id, p.pos_order"
        );
        if ($r) {
            while ($row = $r->fetch_assoc()) {
                $zid = (int)$row['zone_id'];
                if (!isset($nb_zone_leads[$zid])) {
                    $nb_zone_leads[$zid] = $row['acc_name'];
                }
            }
        }
    }
}

// ── Widget renderer ───────────────────────────────────────────
function nb_render_widget(string $key, array $cfg, array $ctx): string {
    $html = '';
    switch ($key) {

        case 'current_time':
            $html  = '<div class="nb-widget nb-widget--time" title="Current time">';
            $html .= '<span class="nb-w-icon">&#9201;</span>';
            $html .= '<span class="nb-w-val" id="nb-clock">--:--:--</span>';
            $html .= '</div>';
            break;

        case 'current_date':
            $date  = date('D, M j');
            $html  = '<div class="nb-widget nb-widget--date" title="Today\'s date">';
            $html .= '<span class="nb-w-icon">&#128197;</span>';
            $html .= '<span class="nb-w-val">' . htmlspecialchars($date) . '</span>';
            $html .= '</div>';
            break;

        case 'current_user':
            $user  = $ctx['user'] ?? 'Guest';
            $html  = '<div class="nb-widget nb-widget--user" title="Logged-in user">';
            $html .= '<span class="nb-w-icon">&#128100;</span>';
            $html .= '<span class="nb-w-val">' . htmlspecialchars($user) . '</span>';
            $html .= '</div>';
            break;

        case 'ride_status':
            $ride_id = (int)($cfg['ride_id'] ?? 0);
            if ($ride_id > 0 && isset($ctx['rides'][$ride_id])) {
                // Specific ride status view
                $rd     = $ctx['rides'][$ride_id];
                $rname  = htmlspecialchars($rd['name'] ?? 'Ride');
                $rstatus = strtolower($rd['status'] ?? 'down');
                $pill_class = 'nb-pill--' . $rstatus;
                $label  = strtoupper($rstatus);
                $html  = '<div class="nb-widget nb-widget--ridestat" title="' . $rname . ' status">';
                $html .= '<span class="nb-w-label">' . $rname . '</span>';
                $html .= '<span class="nb-w-pill ' . $pill_class . '">' . $label . '</span>';
                $html .= '</div>';
            } else {
                // Summary view (no specific ride configured)
                $c     = $ctx['ride_counts'];
                $html  = '<div class="nb-widget nb-widget--rides" title="Ride status overview">';
                $html .= '<span class="nb-w-label">Rides</span>';
                $html .= '<span class="nb-w-pill nb-pill--up">'    . $c['up']    . ' Up</span>';
                $html .= '<span class="nb-w-pill nb-pill--maint">' . $c['maint'] . ' Maint</span>';
                $html .= '<span class="nb-w-pill nb-pill--down">'  . $c['down']  . ' Down</span>';
                $html .= '</div>';
            }
            break;

        case 'open_rides':
            $cnt   = $ctx['ride_counts']['up'];
            $html  = '<div class="nb-widget nb-widget--openrides" title="Open rides">';
            $html .= '<span class="nb-w-label">Open Rides</span>';
            $html .= '<span class="nb-w-val nb-w-big">' . $cnt . '</span>';
            $html .= '</div>';
            break;

        case 'zone_lead':
            $zid   = (int)($cfg['zone_id'] ?? 0);
            $zname = $ctx['zones_list'][$zid]  ?? "Zone $zid";
            $lead  = $ctx['zone_leads'][$zid]  ?? '—';
            $html  = '<div class="nb-widget nb-widget--lead" title="Zone lead">';
            $html .= '<span class="nb-w-label">' . htmlspecialchars($zname) . ' Lead</span>';
            $html .= '<span class="nb-w-val">'   . htmlspecialchars($lead)  . '</span>';
            $html .= '</div>';
            break;

        case 'zone_rotation':
            $zid   = (int)($cfg['zone_id'] ?? 0);
            $zname = $ctx['zones_list'][$zid] ?? ($zid ? "Zone $zid" : 'Rotation');
            // Read rotation interval and start from zone settings
            $rot   = $ctx['zone_rotation'][$zid] ?? ['mins' => 30, 'start' => null];
            $rot_mins  = max(1, $rot['mins']);
            $cycle_sec = $rot_mins * 60;
            if (!empty($rot['start'])) {
                $elapsed   = max(0, time() - strtotime($rot['start']));
                $remaining = $cycle_sec - ($elapsed % $cycle_sec);
            } else {
                $remaining = $cycle_sec; // no start set – show full duration
            }
            $uid   = 'nb-rot-' . $zid;
            $html  = '<div class="nb-widget nb-widget--rotation" title="Rotation countdown" id="' . $uid . '">';
            $html .= '<span class="nb-w-label">' . htmlspecialchars($zname) . '</span>';
            $html .= '<span class="nb-w-val nb-countdown" data-seconds="' . (int)$remaining . '" data-cycle="' . $cycle_sec . '">--:--</span>';
            $html .= '</div>';
            break;

        case 'org_name':
            $name  = $ctx['org_name'] ?? ($_SESSION['org_id'] ?? '—');
            $html  = '<div class="nb-widget nb-widget--org" title="Organisation">';
            $html .= '<span class="nb-w-icon">&#127970;</span>';
            $html .= '<span class="nb-w-val">' . htmlspecialchars((string)$name) . '</span>';
            $html .= '</div>';
            break;

        case 'quick_link':
            $label = htmlspecialchars($cfg['label'] ?? 'Link');
            $url   = htmlspecialchars($cfg['url']   ?? '#');
            $html  = '<div class="nb-widget nb-widget--link">';
            $html .= '<a href="' . $url . '" class="nb-w-link">&#128279; ' . $label . '</a>';
            $html .= '</div>';
            break;

        default:
            $html = '';
    }
    return $html;
}

// ── Build context array ───────────────────────────────────────
$nb_ctx = [
    'user'          => $nb_user,
    'ride_counts'   => $nb_ride_counts,
    'rides'         => $nb_rides,
    'org_name'      => $nb_org_name,
    'zone_leads'    => $nb_zone_leads,
    'zones_list'    => $nb_zones_list,
    'zone_rotation' => $nb_zone_rotation,
];

// ── Determine if any slot is occupied ────────────────────────
$nb_has_widgets = !empty(array_filter($active_keys));
if (!$nb_has_widgets) return; // nothing to render

?>
<div class="widget-bar" id="widgetBar">
<?php for ($i = 1; $i <= 9; $i++):
    $slot = $nb_slots[$i];
    if (empty($slot['widget_key'])) continue;
    echo nb_render_widget(
        (string)$slot['widget_key'],
        (array)($slot['widget_config'] ?? []),
        $nb_ctx
    );
endfor; ?>
</div>

<script>
(function () {
    // ── Live clock ────────────────────────────────────────────
    var clockEl = document.getElementById('nb-clock');
    if (clockEl) {
        function tickClock() {
            var now = new Date();
            var h = String(now.getHours()).padStart(2, '0');
            var m = String(now.getMinutes()).padStart(2, '0');
            var s = String(now.getSeconds()).padStart(2, '0');
            clockEl.textContent = h + ':' + m + ':' + s;
        }
        tickClock();
        setInterval(tickClock, 1000);
    }

    // ── Rotation countdowns ───────────────────────────────────
    // data-seconds = server-computed time remaining in current cycle
    // data-cycle   = full cycle duration in seconds (for auto-reset)
    var countdowns = document.querySelectorAll('.nb-countdown');
    var countdownState = [];

    countdowns.forEach(function (el) {
        var remaining = parseInt(el.getAttribute('data-seconds'), 10) || 1800;
        var cycle     = parseInt(el.getAttribute('data-cycle'),   10) || remaining;
        countdownState.push({ el: el, remaining: remaining, cycle: cycle });
    });

    if (countdownState.length) {
        function tickCountdowns() {
            countdownState.forEach(function (state) {
                if (state.remaining <= 0) state.remaining = state.cycle;
                state.remaining--;
                var m = Math.floor(state.remaining / 60);
                var s = state.remaining % 60;
                state.el.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                state.el.style.color = state.remaining <= 60 ? '#c0392b' : '';
            });
        }
        tickCountdowns();
        setInterval(tickCountdowns, 1000);
    }
})();
</script>
