<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OPilot – Management</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/theme.css" />
    <link rel="stylesheet" href="style.css?v5" />
</head>
<body>
<?php
require_once __DIR__ . '/../../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$sessionUser  = $_SESSION['user']      ?? 'Guest';
$sessionOrg   = $_SESSION['org_id']    ?? '—';
$sessionPerm  = $_SESSION['perm_group'] ?? '—';
$nameParts = preg_split('/[\s.]+/', trim($sessionUser));
$initials  = strtoupper(substr($nameParts[0] ?? 'G', 0, 1));
if (isset($nameParts[1])) $initials .= strtoupper(substr($nameParts[1], 0, 1));

require_once __DIR__ . '/../../partials/sidebar.php';
?>
    <!-- CONTENT -->
    <div class="content">

        <div class="page-header">
            <div>
                <h1>Management</h1>
                <div class="breadcrumb">Admin › <span id="breadcrumbSection">Management</span></div>
            </div>
            <div class="header-controls">
                <button id="headerSaveBtn" class="btn-mgmt" type="button" style="display:none">Save Changes</button>
            </div>
        </div>

        <div class="mgmt-body">

            <!-- Left: configuration panel -->
            <div class="mgmt-config-panel" id="mgmtConfigPanel">

                <!-- ══ DEFAULT EMPTY STATE ══ -->
                <div class="mgmt-panel" id="panel-default">
                    <div class="config-empty-state">
                        <div class="config-empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="3"/>
                                <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                            </svg>
                        </div>
                        <div class="config-empty-title">Management Configuration</div>
                        <div class="config-empty-sub">Select a section from the menu to begin configuring.</div>
                    </div>
                </div>

                <!-- ══ ORGANIZATION PANEL ══ -->
                <div class="mgmt-panel" id="panel-org" style="display:none">
                    <div class="panel-inner">

                        <div id="orgLoading" class="panel-loading">Loading organization data…</div>

                        <div id="orgReadonlyBanner" class="panel-readonly-banner" style="display:none">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                            Read-only — only the organization owner can make changes.
                        </div>

                        <div id="orgLayout" class="org-layout" style="display:none">

                            <!-- Identity card -->
                            <div class="org-identity-card">
                                <div class="org-pic-wrap">
                                    <img id="orgPicImg" src="" alt="Org picture" class="org-pic-img" style="display:none" />
                                    <div id="orgPicPlaceholder" class="org-pic-placeholder">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40">
                                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 010 7.75"/>
                                        </svg>
                                    </div>
                                    <label id="picUploadLabel" class="org-pic-upload-overlay" title="Change org picture" style="display:none">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        <span>Upload</span>
                                        <input type="file" id="picFileInput" accept="image/*" style="display:none" />
                                    </label>
                                </div>
                                <div id="picMsg" class="field-msg" style="display:none"></div>
                                <div class="org-id-name" id="cardOrgName">—</div>
                                <div class="org-id-code">
                                    <span class="org-id-code-label">CODE</span>
                                    <span id="cardOrgCode">—</span>
                                </div>
                                <div class="org-id-owner">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                                    Owner: <span id="cardOwnerName">—</span>
                                </div>
                            </div>

                            <!-- Edit form -->
                            <div class="org-edit-panel">
                                <div class="mgmt-section">
                                    <div class="mgmt-section-title">Identity</div>
                                    <div class="mgmt-field">
                                        <label class="mgmt-label" for="inputOrgName">Organization Name</label>
                                        <input type="text" id="inputOrgName" class="mgmt-input" maxlength="200" placeholder="My Organization" disabled />
                                    </div>
                                    <div class="mgmt-field">
                                        <label class="mgmt-label" for="inputOrgCode">
                                            Login Code
                                            <span class="mgmt-label-hint">(3–30 chars, letters / numbers / - _)</span>
                                        </label>
                                        <input type="text" id="inputOrgCode" class="mgmt-input mgmt-input-code" maxlength="30" placeholder="MYORG" disabled />
                                    </div>
                                    <div id="infoMsg" class="field-msg" style="display:none"></div>
                                    <button id="btnSaveInfo" class="btn-mgmt" style="display:none" disabled>Save Changes</button>
                                </div>

                                <div class="mgmt-section">
                                    <div class="mgmt-section-title">Ownership</div>
                                    <div class="mgmt-section-sub">Transferring ownership grants full management access to another member. You will lose owner privileges immediately.</div>
                                    <div class="mgmt-field">
                                        <label class="mgmt-label" for="selectOwner">Owner Account</label>
                                        <select id="selectOwner" class="mgmt-input" disabled>
                                            <option value="">Loading…</option>
                                        </select>
                                    </div>
                                    <div id="ownerMsg" class="field-msg" style="display:none"></div>
                                    <button id="btnSaveOwner" class="btn-mgmt btn-mgmt-danger" style="display:none" disabled>Transfer Ownership</button>
                                </div>
                            </div>
                        </div>

                        <div id="orgError" class="panel-error" style="display:none"></div>
                    </div>
                </div>

                <!-- ══ ZONE MANAGEMENT PANEL ══ -->
                <div class="mgmt-panel" id="panel-zones" style="display:none">
                    <div class="panel-inner">
                        <div class="zone-page-intro">
                            <div class="zone-intro-title">Organization Zones</div>
                            <div class="zone-intro-subtitle">Edit zone name, zone lead, permission group, and icon.</div>
                        </div>
                        <div class="zone-list-shell">
                            <div class="zone-list-head">
                                <div class="zone-col-name">Zone</div>
                                <div class="zone-col-lead">Zone Lead</div>
                                <div class="zone-col-perm">Permission Group</div>
                                <div class="zone-col-icon">Icon</div>
                                <div class="zone-col-actions">Actions</div>
                            </div>
                            <div id="zoneRows" class="zone-list-body">
                                <div class="zone-loading">Loading zones…</div>
                            </div>
                        </div>
                        <div id="zoneMsg" class="zone-msg" aria-live="polite"></div>
                    </div>
                </div>

                <!-- ══ ACCOUNT MANAGEMENT PANEL ══ -->
                <div class="mgmt-panel" id="panel-accounts" style="display:none">
                    <div class="panel-inner acct-panel-inner">

                        <!-- ── Job Positions manager ── -->
                        <div class="acct-pos-section">
                            <div class="acct-pos-section-hdr">
                                <div>
                                    <div class="acct-pos-section-title">Job Positions</div>
                                    <div class="acct-pos-section-sub">Define positions for your org. Each position can default to a permission group.</div>
                                </div>
                                <button id="btnTogglePositions" class="btn-mgmt" type="button" style="align-self:flex-start">Manage Positions</button>
                            </div>

                            <div id="positionsArea" style="display:none">
                                <!-- Create form -->
                                <div class="acct-pos-create-row">
                                    <input id="newPosName" class="mgmt-input" type="text" placeholder="Position name…" maxlength="100" />
                                    <select id="newPosPermtier" class="mgmt-input acct-pos-perm-select">
                                        <option value="">Default permission group (optional)</option>
                                    </select>
                                    <button id="btnCreatePos" class="btn-mgmt" type="button">Add</button>
                                </div>
                                <div id="posCreateMsg" class="field-msg"></div>

                                <!-- Position list -->
                                <div id="positionList" class="acct-pos-list">
                                    <div class="acct-pos-empty">No positions yet.</div>
                                </div>
                            </div>
                        </div>

                        <!-- ── Account list ── -->
                        <div class="acct-users-shell">
                            <div class="acct-users-head">
                                <div class="acct-col-avatar"></div>
                                <div class="acct-col-username">Username</div>
                                <div class="acct-col-displayname">Display Name</div>
                                <div class="acct-col-position">Job Position</div>
                                <div class="acct-col-permgroup">Permission Group</div>
                            </div>
                            <div id="accountRows" class="acct-users-body">
                                <div class="acct-loading">Loading accounts…</div>
                            </div>
                        </div>

                        <div id="acctMsg" class="acct-msg" aria-live="polite"></div>

                    </div>
                </div>

                <!-- ══ PERMISSIONS PANEL ══ -->
                <div class="mgmt-panel" id="panel-perms" style="display:none">
                    <div class="panel-inner">
                        <div class="placeholder-panel">
                            <div class="placeholder-icon" style="background:linear-gradient(135deg,#6fb4a3,#1a8f7a)">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" width="40" height="40"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            </div>
                            <div class="placeholder-title">Permission Management</div>
                            <div class="placeholder-sub">Define individual permissions that can be assigned to users or permission tiers. Coming soon.</div>
                        </div>
                    </div>
                </div>

                <!-- ══ PERMISSION GROUPS PANEL ══ -->
                <div class="mgmt-panel" id="panel-perm-groups" style="display:none">
                    <div class="panel-inner">
                        <div class="placeholder-panel">
                            <div class="placeholder-icon" style="background:linear-gradient(135deg,#9ad1be,#22b09a)">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" width="40" height="40"><path d="M12 2l3 6 6 .9-4.5 4 1 6L12 17l-5.5 2.9 1-6L3 9.6l6.2-.9L12 2z"/></svg>
                            </div>
                            <div class="placeholder-title">Permission Groups</div>
                            <div class="placeholder-sub">Create roles (tiers) and assign sets of permissions to many users at once. Coming soon.</div>
                        </div>
                    </div>
                </div>

            </div><!-- /.mgmt-config-panel -->

            <!-- Right: nav button column -->
            <aside class="mgmt-nav">
                <div class="mgmt-nav-label">Management Console</div>

                <button class="mgmt-nav-btn" type="button" data-section="org">
                    <span class="mgmt-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                            <path d="M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </span>
                    <span class="mgmt-nav-text">Organization Management</span>
                </button>

                <button class="mgmt-nav-btn" type="button" data-section="perms">
                    <span class="mgmt-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                    </span>
                    <span class="mgmt-nav-text">Permission Management</span>
                </button>

                <button class="mgmt-nav-btn" type="button" data-section="perm-groups">
                    <span class="mgmt-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 2l3 6 6 .9-4.5 4.4 1 6.2L12 16.9l-5.5 2.6 1-6.2L3 8.9 9 8z"/>
                        </svg>
                    </span>
                    <span class="mgmt-nav-text">Permission Groups Management</span>
                </button>

                <button class="mgmt-nav-btn" type="button" data-section="accounts">
                    <span class="mgmt-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>
                    <span class="mgmt-nav-text">Account Management</span>
                </button>

                <button class="mgmt-nav-btn" type="button" data-section="zones">
                    <span class="mgmt-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M3 8.7C3 7.2 3 6.5 3.4 6.1a2 2 0 01.5-.4C4.4 5.5 5.1 5.7 6.5 6.2c1.1.4 1.6.5 2.2.5h.3c.5-.1 1-.4 1.9-1L12.6 4.6c1.2-.8 1.8-1.2 2.4-1.3.7-.1 1.4.1 2.8.6l1.2.4c1 .3 1.5.5 1.8.9.3.4.3.9.3 2v8.1c0 1.5 0 2.2-.4 2.6a2 2 0 01-.5.4c-.5.2-1.2 0-2.5-.5-1.1-.4-1.6-.5-2.2-.5h-.3c-.5.1-1 .4-1.9 1L12 17.4c-1.2.8-1.8 1.2-2.5 1.3-.7.1-1.4-.1-2.8-.6l-1.1-.4c-1-.3-1.5-.5-1.8-.9-.3-.4-.3-.9-.3-2V8.7z"/>
                            <path d="M9 6.6V20.5M15 3V17"/>
                        </svg>
                    </span>
                    <span class="mgmt-nav-text">Zone Management</span>
                </button>

                <!-- Signed-in user card -->
                <div class="mgmt-user-card">
                    <div class="mgmt-user-avatar"><?php echo htmlspecialchars($initials); ?></div>
                    <div class="mgmt-user-info">
                        <div class="mgmt-user-name"><?php echo htmlspecialchars($sessionUser); ?></div>
                        <div class="mgmt-user-tags mgmt-user-tags-vertical">
                            <span class="mgmt-user-tag">
                                <span class="tag-label">Org</span>
                                <span class="tag-value"><?php echo htmlspecialchars($sessionOrg); ?></span>
                            </span>
                        </div>
                        <div class="mgmt-user-tags mgmt-user-tags-vertical">
                            <span class="mgmt-user-tag">
                                <span class="tag-label">Perm Groups</span>
                                <span class="tag-value"><?php echo htmlspecialchars($sessionPerm); ?></span>
                            </span>
                        </div>
                    </div>
                </div>
            </aside>

        </div>

    </div>
    </div><!-- /.main -->

<script>
(function () {
    'use strict';

    // API paths relative to this page
    const ORG_API   = '../org-manangement/api.php';
    const ZONE_API  = '../zone-management/api.php';
    const ACCT_API  = '../account-management/api.php';

    const sectionLabels = {
        'org':         'Organization Management',
        'zones':       'Zone Management',
        'accounts':    'Account Management',
        'perms':       'Permission Management',
        'perm-groups': 'Permission Groups',
    };

    const inited = {};

    // ── Section switcher ──────────────────────────────────────────────────────
    function switchSection(name) {
        document.querySelectorAll('.mgmt-panel').forEach(function (p) {
            p.style.display = 'none';
        });
        const target = document.getElementById('panel-' + name);
        if (target) target.style.display = '';

        document.querySelectorAll('.mgmt-nav-btn').forEach(function (b) {
            b.classList.toggle('is-active', b.dataset.section === name);
        });

        const label = sectionLabels[name] || 'Management';
        document.getElementById('breadcrumbSection').textContent = label;

        // Persist selection so reloading returns to the same section
        history.replaceState(null, '', '#' + name);

        // Show save button only for accounts section
        var hSaveBtn = document.getElementById('headerSaveBtn');
        if (hSaveBtn) hSaveBtn.style.display = (name === 'accounts') ? '' : 'none';

        if (!inited[name]) {
            inited[name] = true;
            if (name === 'org')      initOrg();
            if (name === 'zones')    initZones();
            if (name === 'accounts') initAccounts();
        }
    }

    document.querySelectorAll('.mgmt-nav-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const section = btn.getAttribute('data-section');
            if (section) switchSection(section);
        });
    });

    // Restore section from URL hash on page load
    (function () {
        var hash = location.hash.replace('#', '');
        if (hash && sectionLabels[hash]) {
            switchSection(hash);
        }
    }());

    // ══════════════════════════════════════════════════════════════════════════
    // ORGANIZATION SECTION
    // ══════════════════════════════════════════════════════════════════════════
    function initOrg() {
        const orgLoading      = document.getElementById('orgLoading');
        const orgLayout       = document.getElementById('orgLayout');
        const orgError        = document.getElementById('orgError');
        const readonlyBanner  = document.getElementById('orgReadonlyBanner');

        const orgPicImg         = document.getElementById('orgPicImg');
        const orgPicPlaceholder = document.getElementById('orgPicPlaceholder');
        const picUploadLabel    = document.getElementById('picUploadLabel');
        const picFileInput      = document.getElementById('picFileInput');
        const picMsg            = document.getElementById('picMsg');

        const cardOrgName  = document.getElementById('cardOrgName');
        const cardOrgCode  = document.getElementById('cardOrgCode');
        const cardOwnerName = document.getElementById('cardOwnerName');

        const inputOrgName = document.getElementById('inputOrgName');
        const inputOrgCode = document.getElementById('inputOrgCode');
        const infoMsg      = document.getElementById('infoMsg');
        const btnSaveInfo  = document.getElementById('btnSaveInfo');

        const selectOwner  = document.getElementById('selectOwner');
        const ownerMsg     = document.getElementById('ownerMsg');
        const btnSaveOwner = document.getElementById('btnSaveOwner');

        let orgState = { org: null, members: [], isOwner: false };

        async function loadOrg() {
            try {
                const res  = await fetch(ORG_API + '?action=load');
                const data = await res.json();
                if (!data.ok) { showOrgError(data.error || 'Failed to load organization data'); return; }
                orgState.org     = data.org;
                orgState.members = data.members || [];
                orgState.isOwner = !!data.is_owner;
                renderOrg(data.owner_name);
            } catch (e) {
                showOrgError('Network error: ' + e.message);
            } finally {
                orgLoading.style.display = 'none';
            }
        }

        function renderOrg(ownerName) {
            const { org, members, isOwner } = orgState;
            if (org.org_picture) {
                orgPicImg.src = '/' + org.org_picture.replace(/^\//, '');
                orgPicImg.style.display         = 'block';
                orgPicPlaceholder.style.display = 'none';
            }
            cardOrgName.textContent  = org.org_name || '—';
            cardOrgCode.textContent  = org.org_code || '—';
            cardOwnerName.textContent = ownerName   || '—';
            inputOrgName.value = org.org_name || '';
            inputOrgCode.value = org.org_code || '';
            selectOwner.innerHTML = members.map(function (m) {
                return '<option value="' + m.account_id + '"' + (m.account_id === org.org_owner ? ' selected' : '') + '>' + escHtml(m.display) + '</option>';
            }).join('');
            if (!members.length) selectOwner.innerHTML = '<option value="">No members found</option>';

            if (isOwner) {
                inputOrgName.disabled  = false;
                inputOrgCode.disabled  = false;
                selectOwner.disabled   = false;
                btnSaveInfo.style.display  = 'inline-flex';
                btnSaveInfo.disabled       = false;
                btnSaveOwner.style.display = 'inline-flex';
                btnSaveOwner.disabled      = false;
                picUploadLabel.style.display = 'flex';
            } else {
                readonlyBanner.style.display = 'flex';
            }
            orgLayout.style.display = 'flex';
        }

        btnSaveInfo.addEventListener('click', async function () {
            const orgName = inputOrgName.value.trim();
            const orgCode = inputOrgCode.value.trim().toUpperCase();
            if (!orgName) { showFieldMsg(infoMsg, 'Organization name is required.', 'error'); return; }
            if (!/^[A-Z0-9_-]{3,30}$/.test(orgCode)) { showFieldMsg(infoMsg, 'Code must be 3–30 characters (letters, numbers, - _).', 'error'); return; }
            btnSaveInfo.disabled = true; btnSaveInfo.textContent = 'Saving…';
            try {
                const res  = await fetch(ORG_API + '?action=save_info', {
                    method: 'POST', headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ org_name: orgName, org_code: orgCode }),
                });
                const data = await res.json();
                if (data.ok) {
                    orgState.org.org_name = orgName; orgState.org.org_code = orgCode;
                    cardOrgName.textContent = orgName; cardOrgCode.textContent = orgCode;
                    showFieldMsg(infoMsg, 'Changes saved.', 'ok');
                } else {
                    showFieldMsg(infoMsg, data.error || 'Save failed.', 'error');
                }
            } catch (e) { showFieldMsg(infoMsg, 'Network error.', 'error'); }
            finally { btnSaveInfo.disabled = false; btnSaveInfo.textContent = 'Save Changes'; }
        });

        btnSaveOwner.addEventListener('click', async function () {
            const newId   = parseInt(selectOwner.value, 10);
            if (!newId) { showFieldMsg(ownerMsg, 'Please select an account.', 'error'); return; }
            if (newId === orgState.org.org_owner) { showFieldMsg(ownerMsg, 'That account is already the owner.', 'error'); return; }
            const newName = selectOwner.options[selectOwner.selectedIndex]?.text || '';
            if (!confirm('Transfer ownership to "' + newName + '"?\n\nYou will lose owner privileges immediately.')) return;
            btnSaveOwner.disabled = true; btnSaveOwner.textContent = 'Transferring…';
            try {
                const res  = await fetch(ORG_API + '?action=save_owner', {
                    method: 'POST', headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ new_owner_account_id: newId }),
                });
                const data = await res.json();
                if (data.ok) {
                    showFieldMsg(ownerMsg, 'Ownership transferred. Reloading…', 'ok');
                    setTimeout(function () { location.reload(); }, 1500);
                } else {
                    showFieldMsg(ownerMsg, data.error || 'Transfer failed.', 'error');
                    btnSaveOwner.disabled = false; btnSaveOwner.textContent = 'Transfer Ownership';
                }
            } catch (e) {
                showFieldMsg(ownerMsg, 'Network error.', 'error');
                btnSaveOwner.disabled = false; btnSaveOwner.textContent = 'Transfer Ownership';
            }
        });

        picFileInput.addEventListener('change', async function () {
            if (!this.files || !this.files[0]) return;
            const fd = new FormData(); fd.append('pic', this.files[0]);
            showFieldMsg(picMsg, 'Uploading…', 'ok'); picUploadLabel.style.pointerEvents = 'none';
            try {
                const res  = await fetch(ORG_API + '?action=save_pic', { method: 'POST', body: fd });
                const data = await res.json();
                if (data.ok) {
                    orgPicImg.src = data.url + '?t=' + Date.now();
                    orgPicImg.style.display = 'block'; orgPicPlaceholder.style.display = 'none';
                    showFieldMsg(picMsg, 'Picture updated.', 'ok');
                } else { showFieldMsg(picMsg, data.error || 'Upload failed.', 'error'); }
            } catch (e) { showFieldMsg(picMsg, 'Network error.', 'error'); }
            finally { picUploadLabel.style.pointerEvents = ''; this.value = ''; }
        });
        picUploadLabel.addEventListener('click', function (e) { if (e.target !== picFileInput) picFileInput.click(); });

        function showOrgError(msg) { orgError.textContent = msg; orgError.style.display = 'block'; }

        loadOrg();
    }

    // ══════════════════════════════════════════════════════════════════════════
    // ZONE SECTION
    // ══════════════════════════════════════════════════════════════════════════
    function initZones() {
        const iconOptions = [
            { value: 'map-pin', label: 'Map Pin' },
            { value: 'ferris',  label: 'Ferris Wheel' },
            { value: 'coaster', label: 'Coaster' },
            { value: 'water',   label: 'Water Ride' },
            { value: 'family',  label: 'Family Zone' },
            { value: 'star',    label: 'Featured' }
        ];
        let operators = [], permissionGroups = [], zones = [];

        function showZoneMessage(text, type) {
            var el = document.getElementById('zoneMsg');
            if (!el) return;
            el.textContent = text; el.className = 'zone-msg ' + (type || 'info'); el.style.display = 'block';
            clearTimeout(showZoneMessage._t);
            showZoneMessage._t = setTimeout(function () { el.style.display = 'none'; }, 2600);
        }

        function iconSvg(icon) {
            if (icon === 'ferris')  return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="7"/><path d="M12 5v14M5 12h14"/><circle cx="12" cy="12" r="1.4"/></svg>';
            if (icon === 'coaster') return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 16c3-4 6 4 9 0s6 4 9 0"/><path d="M3 19h18"/></svg>';
            if (icon === 'water')   return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3c-3 4-5 6-5 9a5 5 0 0010 0c0-3-2-5-5-9z"/></svg>';
            if (icon === 'family')  return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="8" cy="8" r="2"/><circle cx="16" cy="8" r="2"/><path d="M4 18a4 4 0 018 0M12 18a4 4 0 018 0"/></svg>';
            if (icon === 'star')    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.1L12 17l-5.6 3 1.1-6.1L3 9.6l6.2-.9L12 3z"/></svg>';
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-5.4 7-11a7 7 0 10-14 0c0 5.6 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>';
        }

        function leadOptions(selected) {
            return '<option value="">Unassigned</option>' + operators.map(function (op) {
                var sel = String(op.account_id) === String(selected) ? ' selected' : '';
                return '<option value="' + op.account_id + '"' + sel + '>' + escHtml(op.acc_name) + '</option>';
            }).join('');
        }

        function permissionOptions(selected) {
            return '<option value="">Unassigned</option>' + permissionGroups.map(function (pg) {
                var sel = String(pg.permtier_id) === String(selected) ? ' selected' : '';
                return '<option value="' + pg.permtier_id + '"' + sel + '>' + escHtml(pg.permtier_name) + '</option>';
            }).join('');
        }

        function iconOptionsHtml(selected) {
            return iconOptions.map(function (opt) {
                var sel = opt.value === selected ? ' selected' : '';
                return '<option value="' + opt.value + '"' + sel + '>' + escHtml(opt.label) + '</option>';
            }).join('');
        }

        function renderZones() {
            var container = document.getElementById('zoneRows');
            if (!container) return;
            if (!zones.length) { container.innerHTML = '<div class="zone-empty">No zones found for this organization.</div>'; return; }
            container.innerHTML = zones.map(function (zone) {
                return '<div class="zone-row" data-zone-id="' + zone.zone_id + '">' +
                    '<div class="zone-col-name">' +
                        '<div class="zone-id">#' + zone.zone_id + '</div>' +
                        '<input class="zone-input zone-name" type="text" value="' + escHtml(zone.zone_name) + '" />' +
                        '<div class="zone-meta">' + Number(zone.ride_count || 0) + ' rides linked</div>' +
                    '</div>' +
                    '<div class="zone-col-lead"><select class="zone-input zone-lead">' + leadOptions(zone.zone_lead_account_id) + '</select></div>' +
                    '<div class="zone-col-perm"><select class="zone-input zone-perm">' + permissionOptions(zone.zone_permtier_id) + '</select></div>' +
                    '<div class="zone-col-icon">' +
                        '<div class="icon-preview">' + iconSvg(zone.zone_icon || 'map-pin') + '</div>' +
                        '<select class="zone-input zone-icon">' + iconOptionsHtml(zone.zone_icon || 'map-pin') + '</select>' +
                    '</div>' +
                    '<div class="zone-col-actions"><button class="btn btn-teal zone-save" type="button">Save</button></div>' +
                '</div>';
            }).join('');

            container.querySelectorAll('.zone-row').forEach(function (row) {
                var saveBtn     = row.querySelector('.zone-save');
                var iconSelect  = row.querySelector('.zone-icon');
                var iconPreview = row.querySelector('.icon-preview');
                iconSelect.addEventListener('change', function () { iconPreview.innerHTML = iconSvg(iconSelect.value); });
                row.querySelectorAll('input,select').forEach(function (el) {
                    el.addEventListener('change', function () { row.classList.add('dirty'); });
                    el.addEventListener('input',  function () { row.classList.add('dirty'); });
                });
                saveBtn.addEventListener('click', function () { saveZone(row); });
            });
        }

        async function loadZoneData() {
            try {
                var res  = await fetch(ZONE_API + '?action=getZoneManagementData');
                var data = await res.json();
                if (!data.success) throw new Error(data.error || 'Failed to load zone data');
                operators        = data.operators        || [];
                permissionGroups = data.permissionGroups || [];
                zones            = data.zones            || [];
                renderZones();
            } catch (err) {
                var container = document.getElementById('zoneRows');
                if (container) container.innerHTML = '<div class="zone-empty">' + escHtml(err.message || 'Failed to load') + '</div>';
            }
        }

        async function saveZone(row) {
            var zoneId   = row.getAttribute('data-zone-id');
            var zoneName = row.querySelector('.zone-name').value.trim();
            var zoneLead = row.querySelector('.zone-lead').value;
            var zonePerm = row.querySelector('.zone-perm').value;
            var zoneIcon = row.querySelector('.zone-icon').value;
            if (!zoneName) { showZoneMessage('Zone name cannot be empty.', 'error'); return; }
            var btn = row.querySelector('.zone-save'), oldText = btn.textContent;
            btn.disabled = true; btn.textContent = 'Saving…';
            try {
                var body = new URLSearchParams({ action: 'saveZone', zone_id: zoneId, zone_name: zoneName, zone_lead_account_id: zoneLead, zone_permtier_id: zonePerm, zone_icon: zoneIcon });
                var res  = await fetch(ZONE_API, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: body.toString() });
                var data = await res.json();
                if (!data.success) throw new Error(data.error || 'Save failed');
                row.classList.remove('dirty');
                showZoneMessage('Saved zone ' + zoneName + '.', 'success');
            } catch (err) { showZoneMessage(err.message || 'Failed to save zone.', 'error'); }
            finally { btn.disabled = false; btn.textContent = oldText; }
        }

        loadZoneData();
    }

    // ══════════════════════════════════════════════════════════════════════════
    // ACCOUNT MANAGEMENT SECTION
    // ══════════════════════════════════════════════════════════════════════════
    function initAccounts() {
        var positions  = [];
        var permGroups = [];
        var accounts   = [];

        var positionsArea   = document.getElementById('positionsArea');
        var btnToggle       = document.getElementById('btnTogglePositions');
        var positionList    = document.getElementById('positionList');
        var newPosName      = document.getElementById('newPosName');
        var newPosPermtier  = document.getElementById('newPosPermtier');
        var btnCreatePos    = document.getElementById('btnCreatePos');
        var posCreateMsg    = document.getElementById('posCreateMsg');
        var accountRows     = document.getElementById('accountRows');
        var acctMsg         = document.getElementById('acctMsg');

        // Toggle positions area
        btnToggle.addEventListener('click', function () {
            var open = positionsArea.style.display !== 'none';
            positionsArea.style.display = open ? 'none' : '';
            btnToggle.textContent = open ? 'Manage Positions' : 'Hide Positions';
        });

        // ── Message helpers ───────────────────────────────────────────────────
        function showAcctMsg(text, type) {
            acctMsg.textContent = text;
            acctMsg.className   = 'acct-msg ' + (type || 'info');
            acctMsg.style.display = 'block';
            clearTimeout(showAcctMsg._t);
            showAcctMsg._t = setTimeout(function () { acctMsg.style.display = 'none'; }, 3000);
        }

        // ── Populate shared perm-group dropdowns ──────────────────────────────
        function buildPermOptions(selectedId, includeDefault, defaultLabel) {
            var opts = includeDefault
                ? '<option value="">' + escHtml(defaultLabel || '— Use position default —') + '</option>'
                : '<option value="">Unassigned</option>';
            permGroups.forEach(function (pg) {
                var sel = String(pg.permtier_id) === String(selectedId) ? ' selected' : '';
                opts += '<option value="' + pg.permtier_id + '"' + sel + '>' + escHtml(pg.permtier_name || 'Group ' + pg.permtier_id) + '</option>';
            });
            return opts;
        }

        // ── Render positions panel ─────────────────────────────────────────────
        function renderPositions() {
            // Refresh create-form perm dropdown
            newPosPermtier.innerHTML = '<option value="">Default permission group (optional)</option>' +
                permGroups.map(function (pg) {
                    return '<option value="' + pg.permtier_id + '">' + escHtml(pg.permtier_name || 'Group ' + pg.permtier_id) + '</option>';
                }).join('');

            if (!positions.length) {
                positionList.innerHTML = '<div class="acct-pos-empty">No positions yet — create one above.</div>';
                return;
            }

            positionList.innerHTML = positions.map(function (p) {
                var defLabel = p.default_permtier_name ? escHtml(p.default_permtier_name) : 'None';
                return '<div class="acct-pos-chip" data-pos-id="' + p.ojp_id + '">' +
                    '<div class="acct-pos-chip-name">' +
                        '<input class="mgmt-input acct-pos-chip-input" type="text" value="' + escHtml(p.ojp_name) + '" maxlength="100" />' +
                    '</div>' +
                    '<div class="acct-pos-chip-perm">' +
                        '<select class="mgmt-input acct-pos-chip-select">' + buildPermOptions(p.ojp_default_permtier_id, false, '') + '</select>' +
                    '</div>' +
                    '<div class="acct-pos-chip-actions">' +
                        '<button class="btn-mgmt acct-pos-save-btn" type="button">Save</button>' +
                        '<button class="btn-mgmt btn-mgmt-danger acct-pos-del-btn" type="button">Delete</button>' +
                    '</div>' +
                '</div>';
            }).join('');

            positionList.querySelectorAll('.acct-pos-chip').forEach(function (chip) {
                var posId    = chip.getAttribute('data-pos-id');
                var saveBtn  = chip.querySelector('.acct-pos-save-btn');
                var delBtn   = chip.querySelector('.acct-pos-del-btn');
                var nameInp  = chip.querySelector('.acct-pos-chip-input');
                var permSel  = chip.querySelector('.acct-pos-chip-select');

                saveBtn.addEventListener('click', async function () {
                    var n = nameInp.value.trim();
                    if (!n) { showAcctMsg('Position name cannot be empty.', 'error'); return; }
                    saveBtn.disabled = true; saveBtn.textContent = '…';
                    try {
                        var res  = await fetch(ACCT_API + '?action=updatePosition', {
                            method: 'POST', headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ pos_id: posId, name: n, default_permtier_id: permSel.value }),
                        });
                        var data = await res.json();
                        if (!data.ok) throw new Error(data.error || 'Save failed');
                        var pos = positions.find(function (p) { return String(p.ojp_id) === String(posId); });
                        if (pos) {
                            pos.ojp_name = n;
                            pos.ojp_default_permtier_id = permSel.value || null;
                            var pg = permGroups.find(function (g) { return String(g.permtier_id) === String(permSel.value); });
                            pos.default_permtier_name = pg ? pg.permtier_name : null;
                        }
                        // Re-render account rows so perm badges update
                        renderAccounts();
                        showAcctMsg('Position saved.', 'success');
                    } catch (e) { showAcctMsg(e.message || 'Error saving position.', 'error'); }
                    finally { saveBtn.disabled = false; saveBtn.textContent = 'Save'; }
                });

                delBtn.addEventListener('click', async function () {
                    var posObj = positions.find(function (p) { return String(p.ojp_id) === String(posId); });
                    var posName = posObj ? posObj.ojp_name : posId;
                    if (!confirm('Delete position "' + posName + '"?\n\nUsers assigned this position will have it cleared.')) return;
                    delBtn.disabled = true;
                    try {
                        var res  = await fetch(ACCT_API + '?action=deletePosition', {
                            method: 'POST', headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ pos_id: posId }),
                        });
                        var data = await res.json();
                        if (!data.ok) throw new Error(data.error || 'Delete failed');
                        positions = positions.filter(function (p) { return String(p.ojp_id) !== String(posId); });
                        accounts.forEach(function (a) {
                            if (String(a.acc_job_position_id) === String(posId)) {
                                a.acc_job_position_id = null; a.position_name = null;
                                a.pos_default_permtier_id = null; a.pos_default_permtier_name = null;
                            }
                        });
                        renderPositions();
                        renderAccounts();
                        showAcctMsg('Position deleted.', 'success');
                    } catch (e) { showAcctMsg(e.message || 'Error deleting position.', 'error'); delBtn.disabled = false; }
                });
            });
        }

        // ── Render account rows ───────────────────────────────────────────────
        function renderAccounts() {
            if (!accounts.length) {
                accountRows.innerHTML = '<div class="acct-empty">No accounts found for this organization.</div>';
                return;
            }

            accountRows.innerHTML = accounts.map(function (acc) {
                var initials = (acc.acc_name || acc.username || '?')
                    .split(/[\s.]+/).map(function (w) { return w[0] || ''; }).join('').slice(0, 2).toUpperCase();

                var avatarHtml = acc.acc_profile_pic
                    ? '<img src="/' + escHtml(acc.acc_profile_pic.replace(/^\//, '')) + '" class="acct-avatar-img" alt="' + escHtml(acc.acc_name || '') + '" />'
                    : '<div class="acct-avatar-initials">' + escHtml(initials) + '</div>';

                // Determine effective perm group badge
                var hasPosDefault = acc.pos_default_permtier_id && !acc.acc_permtier_id;
                var effectiveLabel = acc.acc_permtier_id
                    ? escHtml(acc.manual_permtier_name || 'Group ' + acc.acc_permtier_id)
                    : (acc.pos_default_permtier_id
                        ? '<span class="acct-perm-hint">via position: ' + escHtml(acc.pos_default_permtier_name || 'default') + '</span>'
                        : '');

                // Position dropdown
                var posOpts = '<option value="">— Unassigned —</option>' +
                    positions.map(function (p) {
                        var sel = String(p.ojp_id) === String(acc.acc_job_position_id) ? ' selected' : '';
                        return '<option value="' + p.ojp_id + '"' + sel + '>' + escHtml(p.ojp_name) + '</option>';
                    }).join('');

                // Perm group dropdown — includes "Use position default" option
                var permOpts = buildPermOptions(acc.acc_permtier_id, true, '— Use position default —');

                return '<div class="acct-row" data-account-id="' + acc.account_id + '">' +
                    '<div class="acct-col-avatar">' +
                        '<div class="acct-avatar">' + avatarHtml + '</div>' +
                    '</div>' +
                    '<div class="acct-col-username">' +
                        '<span class="acct-username">' + escHtml(acc.username || '') + '</span>' +
                    '</div>' +
                    '<div class="acct-col-displayname">' +
                        '<span class="acct-displayname">' + escHtml(acc.acc_name || '') + '</span>' +
                    '</div>' +
                    '<div class="acct-col-position">' +
                        '<select class="zone-input acct-pos-select">' + posOpts + '</select>' +
                    '</div>' +
                    '<div class="acct-col-permgroup">' +
                        '<select class="zone-input acct-perm-select">' + permOpts + '</select>' +
                        '<div class="acct-perm-effective">' + effectiveLabel + '</div>' +
                    '</div>' +
                '</div>';
            }).join('');

            accountRows.querySelectorAll('.acct-row').forEach(function (row) {
                var posSel  = row.querySelector('.acct-pos-select');
                var permSel = row.querySelector('.acct-perm-select');
                var effDiv  = row.querySelector('.acct-perm-effective');

                posSel.addEventListener('change', function () {
                    row.classList.add('dirty');
                    if (!permSel.value) {
                        var pos = positions.find(function (p) { return String(p.ojp_id) === String(posSel.value); });
                        effDiv.innerHTML = (pos && pos.pos_default_permtier_id)
                            ? '<span class="acct-perm-hint">via position: ' + escHtml(pos.default_permtier_name || 'default') + '</span>'
                            : '';
                    }
                });

                permSel.addEventListener('change', function () {
                    row.classList.add('dirty');
                    if (!permSel.value) {
                        var pos = positions.find(function (p) { return String(p.ojp_id) === String(posSel.value); });
                        effDiv.innerHTML = (pos && pos.ojp_default_permtier_id)
                            ? '<span class="acct-perm-hint">via position: ' + escHtml(pos.default_permtier_name || 'default') + '</span>'
                            : '';
                    } else {
                        var pg = permGroups.find(function (g) { return String(g.permtier_id) === String(permSel.value); });
                        effDiv.textContent = pg ? (pg.permtier_name || 'Group ' + pg.permtier_id) : '';
                    }
                });
            });
        }

        // ── Create position ───────────────────────────────────────────────────
        btnCreatePos.addEventListener('click', async function () {
            var name = newPosName.value.trim();
            if (!name) { showFieldMsg(posCreateMsg, 'Position name is required.', 'error'); return; }
            btnCreatePos.disabled = true; btnCreatePos.textContent = '…';
            try {
                var res  = await fetch(ACCT_API + '?action=createPosition', {
                    method: 'POST', headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name: name, default_permtier_id: newPosPermtier.value || null }),
                });
                var data = await res.json();
                if (!data.ok) throw new Error(data.error || 'Create failed');
                positions.push(data.position);
                newPosName.value = '';
                newPosPermtier.value = '';
                renderPositions();
                renderAccounts();
                showFieldMsg(posCreateMsg, 'Position "' + name + '" created.', 'ok');
            } catch (e) { showFieldMsg(posCreateMsg, e.message || 'Error.', 'error'); }
            finally { btnCreatePos.disabled = false; btnCreatePos.textContent = 'Add'; }
        });

        newPosName.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') btnCreatePos.click();
        });

        // ── Save row helper ───────────────────────────────────────────────────
        async function saveRow(row) {
            var accountId = row.getAttribute('data-account-id');
            var posSel    = row.querySelector('.acct-pos-select');
            var permSel   = row.querySelector('.acct-perm-select');

            var r1 = await fetch(ACCT_API + '?action=saveUserPosition', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ account_id: accountId, job_position_id: posSel.value || null }),
            });
            var d1 = await r1.json();
            if (!d1.ok) throw new Error(d1.error || 'Position save failed');

            var r2 = await fetch(ACCT_API + '?action=saveUserPermtier', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ account_id: accountId, permtier_id: permSel.value || null }),
            });
            var d2 = await r2.json();
            if (!d2.ok) throw new Error(d2.error || 'Permission save failed');

            var acc = accounts.find(function (a) { return String(a.account_id) === String(accountId); });
            if (acc) {
                acc.acc_job_position_id = posSel.value || null;
                acc.acc_permtier_id     = permSel.value || null;
                var pos = positions.find(function (p) { return String(p.ojp_id) === String(posSel.value); });
                acc.position_name             = pos ? pos.ojp_name : null;
                acc.pos_default_permtier_id   = pos ? pos.ojp_default_permtier_id : null;
                acc.pos_default_permtier_name = pos ? pos.default_permtier_name : null;
                var pg = permGroups.find(function (g) { return String(g.permtier_id) === String(permSel.value); });
                acc.manual_permtier_name = pg ? pg.permtier_name : null;
            }
            row.classList.remove('dirty');
            return acc ? (acc.acc_name || acc.username || 'user') : 'user';
        }

        // ── Header save button ────────────────────────────────────────────────
        var headerSaveBtn = document.getElementById('headerSaveBtn');
        headerSaveBtn.addEventListener('click', async function () {
            var dirtyRows = Array.from(accountRows.querySelectorAll('.acct-row.dirty'));
            if (!dirtyRows.length) { showAcctMsg('No unsaved changes.', 'info'); return; }
            headerSaveBtn.disabled = true; headerSaveBtn.textContent = 'Saving…';
            var errors = [], saved = [];
            for (var i = 0; i < dirtyRows.length; i++) {
                try { saved.push(await saveRow(dirtyRows[i])); }
                catch (e) { errors.push(e.message || 'Save failed'); }
            }
            headerSaveBtn.disabled = false; headerSaveBtn.textContent = 'Save Changes';
            if (errors.length) { showAcctMsg(errors[0], 'error'); }
            else { showAcctMsg('Saved ' + saved.length + ' user' + (saved.length !== 1 ? 's' : '') + '.', 'success'); }
        });

        // ── Initial load ──────────────────────────────────────────────────────
        async function loadAll() {
            try {
                var res  = await fetch(ACCT_API + '?action=load');
                var data = await res.json();
                if (!data.ok) throw new Error(data.error || 'Failed to load');
                accounts   = data.accounts   || [];
                positions  = data.positions  || [];
                permGroups = data.permGroups || [];
                renderPositions();
                renderAccounts();
            } catch (e) {
                accountRows.innerHTML = '<div class="acct-empty">' + escHtml(e.message || 'Failed to load accounts') + '</div>';
            }
        }

        loadAll();
    }

    // ── Shared helpers ────────────────────────────────────────────────────────
    function showFieldMsg(el, msg, type) {
        el.textContent = msg; el.className = 'field-msg field-msg-' + type; el.style.display = 'block';
        clearTimeout(el._t);
        el._t = setTimeout(function () { el.style.display = 'none'; }, 3500);
    }

    function escHtml(str) {
        return String(str ?? '').replace(/[&<>"']/g, function (c) {
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c];
        });
    }

})();
</script>

</body>

</html>