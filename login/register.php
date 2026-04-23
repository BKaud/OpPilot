<?php
require_once '../DBfiles/db_config.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();

$errors    = [];
$php_state = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['final_submit'])) {

    $org_name        = trim($_POST['org_name']        ?? '');
    $org_description = trim($_POST['org_description'] ?? '');
    $org_color       = trim($_POST['org_color']       ?? '#1a8f7a');
    $org_code        = strtoupper(trim($_POST['org_code'] ?? ''));
    $owner_name      = trim($_POST['owner_name']      ?? '');
    $owner_email     = trim($_POST['owner_email']     ?? '');
    $owner_username  = trim($_POST['owner_username']  ?? '');
    $owner_password  =       $_POST['owner_password'] ?? '';
    $workers_json    =       $_POST['workers_json']   ?? '[]';
    $workers         = json_decode($workers_json, true);
    if (!is_array($workers)) $workers = [];

    // Whitelist color values to prevent arbitrary data storage
    $allowed_colors = ['#1a8f7a','#1a6abf','#7c3aed','#c0392b','#e67e22','#e91e8c','#4338ca','#16a34a'];
    if (!in_array($org_color, $allowed_colors, true)) $org_color = '#1a8f7a';

    // Validate
    if (empty($org_name))    $errors[] = 'Organization name is required.';
    if (empty($org_code) || !preg_match('/^[A-Z0-9_-]{3,30}$/', $org_code))
                              $errors[] = 'Organization code must be 3–30 characters (letters, numbers, - _).';
    if (empty($owner_name))  $errors[] = 'Owner full name is required.';
    if (empty($owner_email) || !filter_var($owner_email, FILTER_VALIDATE_EMAIL))
                              $errors[] = 'A valid owner email is required.';
    if (empty($owner_username)) $errors[] = 'Owner username is required.';
    if (strlen($owner_password) < 6) $errors[] = 'Password must be at least 6 characters.';

    if (empty($errors)) {
        $conn = getDbConnection();

        $st = $conn->prepare('SELECT account_id FROM account WHERE username = ?');
        $st->bind_param('s', $owner_username);
        $st->execute();
        $st->store_result();
        if ($st->num_rows > 0) $errors[] = 'That username is already taken.';
        $st->close();

        $st = $conn->prepare('SELECT org_id FROM organization WHERE org_code = ?');
        $st->bind_param('s', $org_code);
        $st->execute();
        $st->store_result();
        if ($st->num_rows > 0) $errors[] = 'That organization code is already in use.';
        $st->close();

        if (empty($errors)) {
            $conn->begin_transaction();
            try {
                $now = date('Y-m-d H:i:s');

                // --- Owner account ---
                $res      = $conn->query('SELECT COALESCE(MAX(account_id),100) AS m FROM account');
                $owner_id = (int)$res->fetch_assoc()['m'] + 1;
                $pw_hash  = password_hash($owner_password, PASSWORD_DEFAULT);

                $st = $conn->prepare(
                  'INSERT INTO account (account_id,acc_name,username,password,email,acc_create_date,acc_is_active,acc_tier,acc_primary_color)
                   VALUES (?,?,?,?,?,?,1,"Owner",?)'
                );
                 $owner_primary_color = '#1a8f7a';
                 $st->bind_param('issssss', $owner_id, $owner_name, $owner_username, $pw_hash, $owner_email, $now, $owner_primary_color);
                $st->execute(); $st->close();

                // --- Organization ---
                $res    = $conn->query('SELECT COALESCE(MAX(org_id),0) AS m FROM organization');
                $org_id = (int)$res->fetch_assoc()['m'] + 1;

                $st = $conn->prepare(
                    'INSERT INTO organization (org_id,org_name,org_description,org_color,org_owner,org_code)
                     VALUES (?,?,?,?,?,?)'
                );
                $st->bind_param('isssis', $org_id, $org_name, $org_description, $org_color, $owner_id, $org_code);
                $st->execute(); $st->close();

                // --- Link owner to org ---
                $res  = $conn->query('SELECT COALESCE(MAX(org_acc_id),0) AS m FROM org_acc');
                $oa   = (int)$res->fetch_assoc()['m'] + 1;
                $st   = $conn->prepare('INSERT INTO org_acc (org_acc_id,org_acc_org_id,org_acc_acc_id) VALUES (?,?,?)');
                $st->bind_param('iii', $oa, $org_id, $owner_id);
                $st->execute(); $st->close();

                // --- Worker accounts ---
                foreach ($workers as $w) {
                    $wu = trim($w['username'] ?? '');
                    $wp =      $w['password'] ?? '';
                    $we = trim($w['email']    ?? '');
                    $wn = trim($w['name']     ?? $wu);
                    if (empty($wu) || empty($wp)) continue;

                    $res  = $conn->query('SELECT COALESCE(MAX(account_id),100) AS m FROM account');
                    $wid  = (int)$res->fetch_assoc()['m'] + 1;
                    $wh   = password_hash($wp, PASSWORD_DEFAULT);

                    $st = $conn->prepare(
                        'INSERT INTO account (account_id,acc_name,username,password,email,acc_create_date,acc_is_active,acc_tier,acc_primary_color)
                      VALUES (?,?,?,?,?,?,1,"Tier 1",?)'
                    );
                    $worker_primary_color = '#1a8f7a';
                    $st->bind_param('issssss', $wid, $wn, $wu, $wh, $we, $now, $worker_primary_color);
                    $st->execute(); $st->close();

                    $res = $conn->query('SELECT COALESCE(MAX(org_acc_id),0) AS m FROM org_acc');
                    $oa  = (int)$res->fetch_assoc()['m'] + 1;
                    $st  = $conn->prepare('INSERT INTO org_acc (org_acc_id,org_acc_org_id,org_acc_acc_id) VALUES (?,?,?)');
                    $st->bind_param('iii', $oa, $org_id, $wid);
                    $st->execute(); $st->close();
                }

                $conn->commit();

                $_SESSION['user']       = $owner_username;
                $_SESSION['account_id'] = $owner_id;
                $_SESSION['org_id']     = $org_id;
                $_SESSION['acc_primary_color'] = '#1a8f7a';
                header('Location: ../zone-manager/dashboard/dashboard.php');
                exit();

            } catch (Exception $e) {
                $conn->rollback();
                $errors[] = 'Registration failed. Please try again. (' . $e->getMessage() . ')';
            }
        }
        $conn->close();
    }

    // Re-hydrate JS state so user doesn't lose their input
    $php_state = [
        'org_name'        => $org_name,
        'org_description' => $org_description,
        'org_color'       => $org_color,
        'org_code'        => $org_code,
        'owner_name'      => $owner_name,
        'owner_email'     => $owner_email,
        'owner_username'  => $owner_username,
        'workers'         => $workers,
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Set Up OpPilot</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/theme.css" />
  <link rel="stylesheet" href="register.css" />
  <style>
    /* Override theme.css overflow:hidden so the wizard page can scroll on small screens */
    html, body { overflow: auto !important; height: auto !important; min-height: 100vh; }
  </style>
</head>
<body class="wizard-page">

<div class="wizard-outer">
  <div class="wizard-card">

    <!-- ── Header ── -->
    <div class="wizard-header">
      <div class="wizard-logo">Op<span>Pilot</span></div>
      <div class="wizard-progress" id="wizard-progress"><!-- built by JS --></div>
    </div>

    <!-- ── Body ── -->
    <div class="wizard-body">

      <?php if (!empty($errors)): ?>
      <div class="wizard-error-banner">
        <strong>Please fix the following:</strong>
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?php echo htmlspecialchars($e); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <!-- ════ STEP 1: Welcome ════ -->
      <div class="wizard-step active" id="step-1">
        <div class="welcome-icon">
          <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="19" cy="13" r="10" stroke="currentColor" stroke-width="2.4" fill="none"/>
            <path d="M5 31 Q11 23 19 26 Q27 23 33 31" stroke="currentColor" stroke-width="2.4" fill="none" stroke-linecap="round"/>
            <circle cx="7" cy="31" r="2.6" fill="currentColor"/>
            <circle cx="31" cy="31" r="2.6" fill="currentColor"/>
            <path d="M16 10 L19 7 L22 10" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <h2 class="step-title">Welcome to OpPilot</h2>
        <p class="step-sub">Let's get your organization set up in just a few steps.</p>
        <ul class="welcome-checklist">
          <li>
            <span class="check-num">1</span>
            <div>
              <div style="font-weight:700;font-size:1rem;margin-bottom:0.25rem;">Create your organization</div>
              <div style="font-size:0.82rem;color:#888;">Name, description, and color scheme</div>
            </div>
          </li>
          <li>
            <span class="check-num">2</span>
            <div>
              <div style="font-weight:700;font-size:1rem;margin-bottom:0.25rem;">Set up the owner account</div>
              <div style="font-size:0.82rem;color:#888;">Your login credentials as administrator</div>
            </div>
          </li>
          <li>
            <span class="check-num">3</span>
            <div>
              <div style="font-weight:700;font-size:1rem;margin-bottom:0.25rem;">Invite your team <em style="color:#555;font-size:0.85em;font-style:normal;">(optional)</em></div>
              <div style="font-size:0.82rem;color:#888;">Add staff accounts or do it later</div>
            </div>
          </li>
        </ul>
        <div class="wizard-nav">
          <a class="btn-next" href="login.php" style="text-decoration:none;">← Log In</a>
          <button class="btn-next" onclick="goTo(2)">Get Started →</button>
        </div>
      </div>

      <!-- ════ STEP 2: Org Profile ════ -->
      <div class="wizard-step" id="step-2">
        <h2 class="step-title">Your Organization</h2>
        <p class="step-sub">Give your organization a name, description, and a color scheme.</p>

        <div class="org-avatar-wrap">
          <div class="org-avatar" id="org-avatar">?</div>
          <div class="org-avatar-hint">Profile photo can be changed later in Settings</div>
        </div>

        <div class="wizard-field" id="field-org-name">
          <label for="inp-org-name">Organization Name <span style="color:var(--accent-red)">*</span></label>
          <input type="text" id="inp-org-name" placeholder="e.g. Everest Theme Park" maxlength="200" oninput="updateAvatar()" />
          <div class="field-err">Organization name is required.</div>
        </div>

        <div class="wizard-field" id="field-org-code">
          <label for="inp-org-code">Organization Code <span style="color:var(--accent-red)">*</span></label>
          <input type="text" id="inp-org-code" placeholder="e.g. EVERPK" maxlength="30"
            oninput="this.value=this.value.toUpperCase().replace(/[^A-Z0-9_-]/g,'')" />
          <div style="font-size:0.78rem;color:#888;margin-top:0.3rem;">3–30 characters: letters, numbers, hyphens, underscores. Members use this code to log in.</div>
          <div class="field-err">A unique code of 3–30 characters (letters, numbers, - _) is required.</div>
        </div>

        <div class="wizard-field">
          <label for="inp-org-desc">Description</label>
          <textarea id="inp-org-desc" placeholder="A brief description of your organization…" rows="3" maxlength="500"></textarea>
        </div>

        <div class="color-label">Color Scheme</div>
        <div class="color-swatches" id="color-swatches"><!-- built by JS --></div>

        <div class="wizard-nav">
          <button class="btn-back" onclick="goTo(1)">← Back</button>
          <button class="btn-next" onclick="validateStep(2)">Next →</button>
        </div>
      </div>

      <!-- ════ STEP 3: Owner Account ════ -->
      <div class="wizard-step" id="step-3">
        <h2 class="step-title">Owner Account</h2>
        <p class="step-sub">This will be the primary administrator for your organization.</p>

        <div class="wizard-field" id="field-owner-name">
          <label for="inp-owner-name">Full Name <span style="color:var(--accent-red)">*</span></label>
          <input type="text" id="inp-owner-name" placeholder="e.g. Jordan Smith" maxlength="100" />
          <div class="field-err">Full name is required.</div>
        </div>

        <div class="wizard-field" id="field-owner-email">
          <label for="inp-owner-email">Email Address <span style="color:var(--accent-red)">*</span></label>
          <input type="email" id="inp-owner-email" placeholder="you@example.com" maxlength="255" />
          <div class="field-err">A valid email address is required.</div>
        </div>

        <div class="wizard-field" id="field-owner-username">
          <label for="inp-owner-username">Username <span style="color:var(--accent-red)">*</span></label>
          <input type="text" id="inp-owner-username" placeholder="username" maxlength="100" oninput="this.value=this.value.replace(/\s/g,'')" />
          <div class="field-err">Username is required.</div>
        </div>

        <div class="wizard-field" id="field-owner-password">
          <label for="inp-owner-password">Password <span style="color:var(--accent-red)">*</span></label>
          <input type="password" id="inp-owner-password" placeholder="At least 6 characters" />
          <div class="field-err">Password must be at least 6 characters.</div>
        </div>

        <div class="wizard-field" id="field-owner-confirm">
          <label for="inp-owner-confirm">Confirm Password <span style="color:var(--accent-red)">*</span></label>
          <input type="password" id="inp-owner-confirm" placeholder="Repeat your password" />
          <div class="field-err">Passwords do not match.</div>
        </div>

        <div class="wizard-nav">
          <button class="btn-back" onclick="goTo(2)">← Back</button>
          <button class="btn-next" onclick="validateStep(3)">Next →</button>
        </div>
      </div>

      <!-- ════ STEP 4: Team Members ════ -->
      <div class="wizard-step" id="step-4">
        <h2 class="step-title">Add Team Members</h2>
        <p class="step-sub">Create accounts for your staff, or skip this and do it later in Account Management.</p>

        <div class="worker-list" id="worker-list"><!-- rows added by JS --></div>
        <button class="btn-add-worker" type="button" onclick="addWorkerRow()">
          <span style="font-size:1.1rem;line-height:1">+</span> Add Member
        </button>
        <div style="flex:1"></div>

        <div class="wizard-nav">
          <button class="btn-back" onclick="goTo(3)">← Back</button>
          <div style="display:flex;align-items:center;gap:1rem;">
            <button class="btn-skip" type="button" onclick="submitWizard()">Skip for now</button>
            <button class="btn-next" type="button" onclick="submitWizard()">Finish &amp; Launch →</button>
          </div>
        </div>
      </div>

    </div><!-- /wizard-body -->
  </div><!-- /wizard-card -->
</div><!-- /wizard-outer -->

<!-- Hidden form — populated and submitted by JS -->
<form id="final-form" method="POST" action="register.php" style="display:none">
  <input type="hidden" name="final_submit"    value="1">
  <input type="hidden" name="org_name"        id="hf-org-name">
  <input type="hidden" name="org_description" id="hf-org-desc">
  <input type="hidden" name="org_color"       id="hf-org-color">
  <input type="hidden" name="org_code"        id="hf-org-code">
  <input type="hidden" name="owner_name"      id="hf-owner-name">
  <input type="hidden" name="owner_email"     id="hf-owner-email">
  <input type="hidden" name="owner_username"  id="hf-owner-username">
  <input type="hidden" name="owner_password"  id="hf-owner-password">
  <input type="hidden" name="workers_json"    id="hf-workers-json">
</form>

<script>
// ── State ──────────────────────────────────────────────────
let currentStep   = 1;
let selectedColor = '#1a8f7a';
let workerSeq     = 0;

const COLORS = [
  { hex: '#1a8f7a', name: 'Teal'   },
  { hex: '#1a6abf', name: 'Blue'   },
  { hex: '#7c3aed', name: 'Purple' },
  { hex: '#c0392b', name: 'Red'    },
  { hex: '#e67e22', name: 'Orange' },
  { hex: '#e91e8c', name: 'Pink'   },
  { hex: '#4338ca', name: 'Indigo' },
  { hex: '#16a34a', name: 'Green'  },
];

// ── Init ───────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
  buildProgress();
  buildColorSwatches();
  updateAvatar();

  <?php if ($php_state): ?>
  // Re-hydrate after a PHP validation error
  const s = <?php echo json_encode($php_state); ?>;
  document.getElementById('inp-org-name').value      = s.org_name        || '';
  document.getElementById('inp-org-code').value      = s.org_code        || '';
  document.getElementById('inp-org-desc').value      = s.org_description || '';
  document.getElementById('inp-owner-name').value    = s.owner_name      || '';
  document.getElementById('inp-owner-email').value   = s.owner_email     || '';
  document.getElementById('inp-owner-username').value= s.owner_username  || '';
  if (s.org_color) selectColor(s.org_color);
  if (Array.isArray(s.workers)) s.workers.forEach(w => addWorkerRow(w));
  updateAvatar();
  goTo(4);
  <?php endif; ?>
});

// ── Color swatches ─────────────────────────────────────────
function buildColorSwatches() {
  const c = document.getElementById('color-swatches');
  c.innerHTML = '';
  COLORS.forEach(col => {
    const d = document.createElement('div');
    d.className  = 'color-swatch' + (col.hex === selectedColor ? ' selected' : '');
    d.style.background = col.hex;
    d.title      = col.name;
    d.dataset.color = col.hex;
    d.addEventListener('click', () => selectColor(col.hex));
    c.appendChild(d);
  });
}

function selectColor(hex) {
  if (!COLORS.find(c => c.hex === hex)) return;
  selectedColor = hex;
  document.querySelectorAll('.color-swatch').forEach(sw => {
    const on = sw.dataset.color === hex;
    sw.classList.toggle('selected', on);
    sw.style.boxShadow = on
      ? `0 0 0 3px var(--bg-card), 0 0 0 5px ${hex}`
      : '';
  });
  document.getElementById('org-avatar').style.background = hex;
}

// ── Avatar preview ─────────────────────────────────────────
function updateAvatar() {
  const name   = (document.getElementById('inp-org-name')?.value || '').trim();
  const avatar = document.getElementById('org-avatar');
  if (!avatar) return;
  avatar.style.background = selectedColor;
  if (!name) { avatar.textContent = '?'; return; }
  const words    = name.split(/\s+/).filter(Boolean);
  const initials = words.length >= 2
    ? (words[0][0] + words[1][0]).toUpperCase()
    : name.slice(0, 2).toUpperCase();
  avatar.textContent = initials;
}

// ── Progress bar ───────────────────────────────────────────
function buildProgress() {
  const labels = ['Org', 'Owner', 'Team'];
  const wrap   = document.getElementById('wizard-progress');
  wrap.innerHTML = '';
  labels.forEach((lbl, i) => {
    const stepNum = i + 2; // steps 2, 3, 4
    const g = document.createElement('div');
    g.className = 'prog-step';

    const dotWrap = document.createElement('div');
    dotWrap.className = 'prog-dot-wrap';

    const dot = document.createElement('div');
    dot.className = 'prog-dot';
    dot.id        = 'prog-' + stepNum;
    dot.textContent = i + 1;
    dotWrap.appendChild(dot);

    const lblEl = document.createElement('div');
    lblEl.className = 'prog-label';
    lblEl.id        = 'prog-lbl-' + stepNum;
    lblEl.textContent = lbl;
    dotWrap.appendChild(lblEl);

    g.appendChild(dotWrap);

    if (i < labels.length - 1) {
      const line = document.createElement('div');
      line.className = 'prog-line';
      line.id = 'prog-line-' + stepNum;
      g.appendChild(line);
    }
    wrap.appendChild(g);
  });
  updateProgress();
}

function updateProgress() {
  for (let s = 2; s <= 4; s++) {
    const dot  = document.getElementById('prog-' + s);
    const line = document.getElementById('prog-line-' + s);
    const lbl  = document.getElementById('prog-lbl-' + s);
    if (!dot) continue;
    dot.classList.remove('active', 'done');
    if      (s < currentStep)  dot.classList.add('done');
    else if (s === currentStep) dot.classList.add('active');
    if (line) line.classList.toggle('done', s < currentStep);
    if (lbl)  lbl.style.color = s <= currentStep ? 'var(--teal)' : '#555';
  }
}

// ── Navigation ─────────────────────────────────────────────
function goTo(n) {
  document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));
  document.getElementById('step-' + n).classList.add('active');
  currentStep = n;
  updateProgress();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Validation ─────────────────────────────────────────────
function setFieldError(id, hasError) {
  document.getElementById(id)?.classList.toggle('has-error', hasError);
}

function validateStep(step) {
  if (step === 2) {
    const nameOk = document.getElementById('inp-org-name').value.trim() !== '';
    setFieldError('field-org-name', !nameOk);

    const code   = document.getElementById('inp-org-code').value.trim();
    const codeOk = /^[A-Z0-9_-]{3,30}$/.test(code);
    setFieldError('field-org-code', !codeOk);

    if (nameOk && codeOk) goTo(3);
    return;
  }

  if (step === 3) {
    let ok = true;

    const name = document.getElementById('inp-owner-name').value.trim();
    setFieldError('field-owner-name', !name);
    if (!name) ok = false;

    const email = document.getElementById('inp-owner-email').value.trim();
    const emailOk = email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    setFieldError('field-owner-email', !emailOk);
    if (!emailOk) ok = false;

    const uname = document.getElementById('inp-owner-username').value.trim();
    setFieldError('field-owner-username', !uname);
    if (!uname) ok = false;

    const pw = document.getElementById('inp-owner-password').value;
    const pwOk = pw.length >= 6;
    setFieldError('field-owner-password', !pwOk);
    if (!pwOk) ok = false;

    const cpw = document.getElementById('inp-owner-confirm').value;
    const cpwOk = pw && cpw === pw;
    setFieldError('field-owner-confirm', !cpwOk);
    if (!cpwOk) ok = false;

    if (ok) goTo(4);
  }
}

// ── Worker rows ────────────────────────────────────────────
function esc(str) {
  return String(str || '')
    .replace(/&/g,'&amp;').replace(/"/g,'&quot;')
    .replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function addWorkerRow(data) {
  workerSeq++;
  const id  = workerSeq;
  const row = document.createElement('div');
  row.className = 'worker-row';
  row.id = 'worker-' + id;
  row.innerHTML =
    `<input type="text"     placeholder="Full Name"        class="w-name"     value="${esc(data?.name    )}">` +
    `<input type="text"     placeholder="Username *"       class="w-username"  value="${esc(data?.username)}">` +
    `<input type="password" placeholder="Password *"       class="w-password"  value="${esc(data?.password)}">` +
    `<input type="email"    placeholder="Email (optional)" class="w-email"     value="${esc(data?.email   )}">` +
    `<button type="button" class="worker-remove" title="Remove" onclick="removeWorker(${id})">✕</button>`;
  document.getElementById('worker-list').appendChild(row);
}

function removeWorker(id) {
  document.getElementById('worker-' + id)?.remove();
}

// ── Final submit ───────────────────────────────────────────
function submitWizard() {
  const workers = [];
  document.querySelectorAll('.worker-row').forEach(row => {
    const username = row.querySelector('.w-username')?.value.trim() || '';
    const password = row.querySelector('.w-password')?.value        || '';
    const email    = row.querySelector('.w-email')?.value.trim()    || '';
    const name     = row.querySelector('.w-name')?.value.trim()     || '';
    if (username || password) workers.push({ name, username, password, email });
  });

  document.getElementById('hf-org-name').value     = document.getElementById('inp-org-name').value.trim();
  document.getElementById('hf-org-desc').value     = document.getElementById('inp-org-desc').value.trim();
  document.getElementById('hf-org-color').value    = selectedColor;
  document.getElementById('hf-org-code').value     = document.getElementById('inp-org-code').value.trim();
  document.getElementById('hf-owner-name').value   = document.getElementById('inp-owner-name').value.trim();
  document.getElementById('hf-owner-email').value  = document.getElementById('inp-owner-email').value.trim();
  document.getElementById('hf-owner-username').value = document.getElementById('inp-owner-username').value.trim();
  document.getElementById('hf-owner-password').value = document.getElementById('inp-owner-password').value;
  document.getElementById('hf-workers-json').value = JSON.stringify(workers);

  document.getElementById('final-form').submit();
}
</script>
</body>
</html>
