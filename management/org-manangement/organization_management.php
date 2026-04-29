<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>OPilot – Organization Management</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/theme.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../partials/sidebar.php';
?>

<div class="content">
    <div class="page-header">
        <div>
            <h1>Organization Management</h1>
            <div class="breadcrumb">Admin › Management › <span>Organization Management</span></div>
        </div>
        <div class="header-controls"><span class="mode-badge">Live</span></div>
    </div>

    <div class="org-page-body">

        <!-- Loading state -->
        <div id="orgLoading" class="org-loading">Loading organization data…</div>

        <!-- Non-owner notice -->
        <div id="orgReadonlyBanner" class="org-readonly-banner" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            You are viewing this page in read-only mode. Only the organization owner can make changes.
        </div>

        <!-- Main layout: identity card left, form right -->
        <div id="orgLayout" class="org-layout" style="display:none">

            <!-- Left: identity card -->
            <div class="org-identity-card">
                <div class="org-pic-wrap" id="orgPicWrap">
                    <img id="orgPicImg" src="" alt="Org picture" class="org-pic-img" style="display:none" />
                    <div id="orgPicPlaceholder" class="org-pic-placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                            <path d="M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </div>
                    <!-- Upload overlay (owner only) -->
                    <label id="picUploadLabel" class="org-pic-upload-overlay" title="Change org picture" style="display:none">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <span>Upload</span>
                        <input type="file" id="picFileInput" accept="image/*" style="display:none" />
                    </label>
                </div>
                <div id="picMsg" class="org-field-msg" style="display:none"></div>

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

            <!-- Right: edit form -->
            <div class="org-edit-panel">

                <!-- Section: Identity -->
                <div class="org-section">
                    <div class="org-section-title">Identity</div>

                    <div class="org-field">
                        <label class="org-label" for="inputOrgName">Organization Name</label>
                        <input type="text" id="inputOrgName" class="org-input" maxlength="200" placeholder="My Organization" disabled />
                    </div>

                    <div class="org-field">
                        <label class="org-label" for="inputOrgCode">
                            Login Code
                            <span class="org-label-hint">(3–30 chars, letters / numbers / - _)</span>
                        </label>
                        <input type="text" id="inputOrgCode" class="org-input org-input-code" maxlength="30"
                               placeholder="MYORG" disabled />
                    </div>

                    <div id="infoMsg" class="org-field-msg" style="display:none"></div>

                    <button id="btnSaveInfo" class="btn-org-save" style="display:none" disabled>
                        Save Changes
                    </button>
                </div>

                <!-- Section: Ownership -->
                <div class="org-section">
                    <div class="org-section-title">Ownership</div>
                    <div class="org-section-sub">
                        Transferring ownership grants full management access to another member.
                        You will lose owner privileges immediately.
                    </div>

                    <div class="org-field">
                        <label class="org-label" for="selectOwner">Owner Account</label>
                        <select id="selectOwner" class="org-input" disabled>
                            <option value="">Loading…</option>
                        </select>
                    </div>

                    <div id="ownerMsg" class="org-field-msg" style="display:none"></div>

                    <button id="btnSaveOwner" class="btn-org-save btn-org-danger" style="display:none" disabled>
                        Transfer Ownership
                    </button>
                </div>

            </div>
        </div>

        <div id="orgError" class="org-error" style="display:none"></div>

    </div><!-- /.org-page-body -->
</div><!-- /.content -->
</div><!-- /.main -->

<script>
(function () {
    'use strict';

    const API = 'api.php';

    // Elements
    const loading         = document.getElementById('orgLoading');
    const layout          = document.getElementById('orgLayout');
    const errorEl         = document.getElementById('orgError');
    const readonlyBanner  = document.getElementById('orgReadonlyBanner');

    const orgPicImg       = document.getElementById('orgPicImg');
    const orgPicPlaceholder = document.getElementById('orgPicPlaceholder');
    const picUploadLabel  = document.getElementById('picUploadLabel');
    const picFileInput    = document.getElementById('picFileInput');
    const picMsg          = document.getElementById('picMsg');

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

    let state = { org: null, members: [], isOwner: false };

    // ── Load ─────────────────────────────────────────────────────────────────
    async function load() {
        try {
            const res  = await fetch(API + '?action=load');
            const data = await res.json();

            if (!data.ok) {
                showError(data.error || 'Failed to load organization data');
                return;
            }

            state.org      = data.org;
            state.members  = data.members  || [];
            state.isOwner  = !!data.is_owner;

            render(data.owner_name);
        } catch (e) {
            showError('Network error: ' + e.message);
        } finally {
            loading.style.display = 'none';
        }
    }

    function render(ownerName) {
        const { org, members, isOwner } = state;

        // Identity card
        if (org.org_picture) {
            orgPicImg.src = '/' + org.org_picture.replace(/^\//, '');
            orgPicImg.style.display   = 'block';
            orgPicPlaceholder.style.display = 'none';
        }
        cardOrgName.textContent  = org.org_name  || '—';
        cardOrgCode.textContent  = org.org_code  || '—';
        cardOwnerName.textContent = ownerName    || '—';

        // Form fields
        inputOrgName.value = org.org_name || '';
        inputOrgCode.value = org.org_code || '';

        // Owner dropdown
        selectOwner.innerHTML = members.map(m =>
            `<option value="${m.account_id}"${m.account_id === org.org_owner ? ' selected' : ''}>${esc(m.display)}</option>`
        ).join('');
        if (!members.length) {
            selectOwner.innerHTML = '<option value="">No members found</option>';
        }

        if (isOwner) {
            // Enable editing
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

        layout.style.display = 'flex';
    }

    // ── Save info ─────────────────────────────────────────────────────────────
    btnSaveInfo.addEventListener('click', async function () {
        const orgName = inputOrgName.value.trim();
        const orgCode = inputOrgCode.value.trim().toUpperCase();

        if (!orgName) { showMsg(infoMsg, 'Organization name is required.', 'error'); return; }
        if (!/^[A-Z0-9_-]{3,30}$/.test(orgCode)) {
            showMsg(infoMsg, 'Code must be 3–30 characters (letters, numbers, - _).', 'error');
            return;
        }

        btnSaveInfo.disabled = true;
        btnSaveInfo.textContent = 'Saving…';

        try {
            const res  = await fetch(API + '?action=save_info', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ org_name: orgName, org_code: orgCode }),
            });
            const data = await res.json();

            if (data.ok) {
                state.org.org_name = orgName;
                state.org.org_code = orgCode;
                cardOrgName.textContent = orgName;
                cardOrgCode.textContent = orgCode;
                showMsg(infoMsg, 'Changes saved.', 'ok');
            } else {
                showMsg(infoMsg, data.error || 'Save failed.', 'error');
            }
        } catch (e) {
            showMsg(infoMsg, 'Network error.', 'error');
        } finally {
            btnSaveInfo.disabled = false;
            btnSaveInfo.textContent = 'Save Changes';
        }
    });

    // ── Save owner ────────────────────────────────────────────────────────────
    btnSaveOwner.addEventListener('click', async function () {
        const newId = parseInt(selectOwner.value, 10);
        if (!newId) { showMsg(ownerMsg, 'Please select an account.', 'error'); return; }
        if (newId === state.org.org_owner) {
            showMsg(ownerMsg, 'That account is already the owner.', 'error');
            return;
        }

        const newName = selectOwner.options[selectOwner.selectedIndex]?.text || '';
        if (!confirm(`Transfer ownership to "${newName}"?\n\nYou will lose owner privileges immediately.`)) return;

        btnSaveOwner.disabled = true;
        btnSaveOwner.textContent = 'Transferring…';

        try {
            const res  = await fetch(API + '?action=save_owner', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ new_owner_account_id: newId }),
            });
            const data = await res.json();

            if (data.ok) {
                showMsg(ownerMsg, 'Ownership transferred. Reloading…', 'ok');
                setTimeout(() => location.reload(), 1500);
            } else {
                showMsg(ownerMsg, data.error || 'Transfer failed.', 'error');
                btnSaveOwner.disabled = false;
                btnSaveOwner.textContent = 'Transfer Ownership';
            }
        } catch (e) {
            showMsg(ownerMsg, 'Network error.', 'error');
            btnSaveOwner.disabled = false;
            btnSaveOwner.textContent = 'Transfer Ownership';
        }
    });

    // ── Picture upload ────────────────────────────────────────────────────────
    picFileInput.addEventListener('change', async function () {
        if (!this.files || !this.files[0]) return;

        const fd = new FormData();
        fd.append('pic', this.files[0]);

        showMsg(picMsg, 'Uploading…', 'ok');
        picUploadLabel.style.pointerEvents = 'none';

        try {
            const res  = await fetch(API + '?action=save_pic', { method: 'POST', body: fd });
            const data = await res.json();

            if (data.ok) {
                orgPicImg.src = data.url + '?t=' + Date.now();
                orgPicImg.style.display      = 'block';
                orgPicPlaceholder.style.display = 'none';
                showMsg(picMsg, 'Picture updated.', 'ok');
            } else {
                showMsg(picMsg, data.error || 'Upload failed.', 'error');
            }
        } catch (e) {
            showMsg(picMsg, 'Network error.', 'error');
        } finally {
            picUploadLabel.style.pointerEvents = '';
            this.value = '';
        }
    });

    // Clicking the label triggers the hidden file input
    picUploadLabel.addEventListener('click', function (e) {
        if (e.target !== picFileInput) picFileInput.click();
    });

    // ── Helpers ───────────────────────────────────────────────────────────────
    function showError(msg) {
        errorEl.textContent = msg;
        errorEl.style.display = 'block';
    }

    function showMsg(el, msg, type) {
        el.textContent = msg;
        el.className   = 'org-field-msg org-msg-' + type;
        el.style.display = 'block';
        clearTimeout(el._t);
        el._t = setTimeout(() => { el.style.display = 'none'; }, 3500);
    }

    function esc(str) {
        return String(str ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));
    }

    load();
})();
</script>

</body>
</html>