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
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../partials/sidebar.php';

$username = $_SESSION['user'] ?? 'Guest';

// Get organization from query parameter (or we could get it from user's primary org)
$org_id = $_GET['org_id'] ?? null;

// For now, if no org_id is provided, show a message
if (!$org_id) {
    echo '<div class="content"><div class="page-header"><h1>Organization Management</h1></div>';
    echo '<div style="padding:24px; color: var(--text-muted);">No organization selected. Please select an organization from the dashboard.</div></div>';
    echo '</body></html>';
    exit;
}
?>

    <div class="content">
        <div class="page-header">
            <div>
                <h1>Organization Management</h1>
                <div class="breadcrumb">Admin › Management › <span id="orgBreadcrumb">Organization</span></div>
            </div>
            <div class="header-controls"><span class="mode-badge">Live</span></div>
        </div>

        <div class="dashboard-body" style="padding:24px;">
            <div class="org-settings-container">

                <!-- ── Profile Section ────────────────────────────── -->
                <section class="org-section org-section--profile">
                    <div class="org-section-head">
                        <div class="org-section-title">Organization Profile</div>
                        <div class="org-section-sub">Name, profile picture, and branding</div>
                    </div>

                    <div class="org-profile-box" id="orgProfileBox">
                        <!-- Profile Picture -->
                        <div class="org-avatar-wrap">
                            <div class="org-avatar" id="orgAvatar">
                                <span class="org-initials" id="orgInitials">ORG</span>
                            </div>
                            <div class="org-avatar-controls">
                                <label class="btn btn-sm btn-teal">
                                    Change Picture
                                    <input type="file" id="orgPicInput" accept="image/*" style="display:none;" />
                                </label>
                                <button type="button" class="btn btn-sm btn-gray" id="orgRemovePicBtn" style="display:none;">Remove</button>
                            </div>
                            <div class="org-avatar-hint">JPG, PNG, GIF, or WebP • Max 5MB</div>
                        </div>

                        <!-- Organization Name -->
                        <div class="org-form-group">
                            <label for="orgName">Organization Name</label>
                            <input type="text" id="orgName" maxlength="200" placeholder="Enter organization name" />
                            <div class="org-field-hint">1–200 characters</div>
                        </div>

                        <div class="org-form-row">
                            <button type="button" class="btn btn-teal" id="orgSaveNameBtn">Save Name</button>
                            <span class="org-status-msg" id="orgNameStatus"></span>
                        </div>
                    </div>
                </section>

                <!-- ── Color Customization Section ────────────────── -->
                <section class="org-section org-section--branding">
                    <div class="org-section-head">
                        <div class="org-section-title">Branding</div>
                        <div class="org-section-sub">Organization color theme</div>
                    </div>

                    <div class="org-branding-box">
                        <div class="org-form-group">
                            <label for="orgColor">Primary Color</label>
                            <div class="org-color-picker-wrap">
                                <input type="color" id="orgColorPicker" />
                                <input type="text" id="orgColorHex" maxlength="7" placeholder="#1A8F7A" readonly />
                            </div>
                            <div class="org-field-hint">Choose your organization's primary brand color</div>
                        </div>

                        <div class="org-color-preview">
                            <div class="org-color-sample" id="orgColorSample" style="background-color:#1a8f7a;"></div>
                            <div class="org-preview-label">Color Preview</div>
                        </div>

                        <div class="org-form-row">
                            <button type="button" class="btn btn-teal" id="orgSaveColorBtn">Save Color</button>
                            <span class="org-status-msg" id="orgColorStatus"></span>
                        </div>
                    </div>
                </section>

                <!-- ── Additional Settings (placeholder for future) ── -->
                <section class="org-section org-section--additional">
                    <div class="org-section-head">
                        <div class="org-section-title">Additional Settings</div>
                        <div class="org-section-sub">Coming soon: billing, integrations, and more</div>
                    </div>
                    <div style="padding:16px; background:#f5f5f5; border-radius:6px; color:var(--text-muted);">
                        More organization settings are coming in future updates.
                    </div>
                </section>

            </div>
        </div>
    </div>

    <script>
    const ORG_ID = <?php echo json_encode($org_id); ?>;
    const API_BASE = '<?php echo url_path('/management/org-manangement/api.php'); ?>';

    class OrgManager {
        constructor() {
            this.orgData = {};
            this.init();
        }

        async init() {
            await this.loadOrgData();
            this.setupEventListeners();
        }

        async loadOrgData() {
            try {
                const resp = await fetch(`${API_BASE}?action=load&org_id=${ORG_ID}`);
                if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
                this.orgData = await resp.json();
                this.renderOrgData();
            } catch (err) {
                console.error('Failed to load organization:', err);
                this.showError('Failed to load organization data');
            }
        }

        renderOrgData() {
            const { org_name, org_profile_pic, org_color } = this.orgData;

            // Update breadcrumb
            document.getElementById('orgBreadcrumb').textContent = org_name || 'Organization';

            // Update name field
            document.getElementById('orgName').value = org_name || '';

            // Update color
            const color = org_color || '#1a8f7a';
            document.getElementById('orgColorPicker').value = color;
            document.getElementById('orgColorHex').value = color.toUpperCase();
            document.getElementById('orgColorSample').style.backgroundColor = color;

            // Update avatar
            if (org_profile_pic) {
                document.getElementById('orgAvatar').style.backgroundImage = `url(${org_profile_pic})`;
                document.getElementById('orgAvatar').style.backgroundSize = 'cover';
                document.getElementById('orgAvatar').style.backgroundPosition = 'center';
                document.getElementById('orgInitials').style.display = 'none';
                document.getElementById('orgRemovePicBtn').style.display = 'inline-block';
            } else {
                const initials = (org_name || 'ORG').split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 3);
                document.getElementById('orgInitials').textContent = initials;
            }
        }

        setupEventListeners() {
            // Name save
            document.getElementById('orgSaveNameBtn').addEventListener('click', () => this.saveName());
            document.getElementById('orgName').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.saveName();
            });

            // Picture upload
            document.getElementById('orgPicInput').addEventListener('change', (e) => this.uploadPic(e));
            document.getElementById('orgRemovePicBtn').addEventListener('click', () => this.removePic());

            // Color picker
            document.getElementById('orgColorPicker').addEventListener('input', (e) => {
                const color = e.target.value.toUpperCase();
                document.getElementById('orgColorHex').value = color;
                document.getElementById('orgColorSample').style.backgroundColor = color;
            });
            document.getElementById('orgSaveColorBtn').addEventListener('click', () => this.saveColor());
        }

        async saveName() {
            const name = document.getElementById('orgName').value.trim();
            if (!name) {
                this.showStatus('orgNameStatus', 'Please enter an organization name', 'error');
                return;
            }

            try {
                const resp = await fetch(`${API_BASE}?action=save_name&org_id=${ORG_ID}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ org_name: name })
                });

                if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
                const data = await resp.json();
                if (data.ok) {
                    this.showStatus('orgNameStatus', 'Organization name saved', 'success');
                    this.orgData.org_name = name;
                    document.getElementById('orgBreadcrumb').textContent = name;
                } else {
                    this.showStatus('orgNameStatus', data.error || 'Failed to save', 'error');
                }
            } catch (err) {
                console.error('Save name error:', err);
                this.showStatus('orgNameStatus', 'Error saving name', 'error');
            }
        }

        async uploadPic(event) {
            const file = event.target.files?.[0];
            if (!file) return;

            if (file.size > 5 * 1024 * 1024) {
                this.showStatus('orgNameStatus', 'File must be under 5MB', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('pic', file);
            formData.append('action', 'save_pic');
            formData.append('org_id', ORG_ID);

            try {
                const resp = await fetch(API_BASE, {
                    method: 'POST',
                    body: formData
                });

                if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
                const data = await resp.json();
                if (data.ok) {
                    this.showStatus('orgNameStatus', 'Profile picture updated', 'success');
                    this.orgData.org_profile_pic = data.url;
                    this.renderOrgData();
                } else {
                    this.showStatus('orgNameStatus', data.error || 'Failed to upload', 'error');
                }
            } catch (err) {
                console.error('Upload error:', err);
                this.showStatus('orgNameStatus', 'Error uploading picture', 'error');
            }
        }

        async removePic() {
            if (!confirm('Remove the organization profile picture?')) return;

            try {
                const resp = await fetch(`${API_BASE}?action=save_pic&org_id=${ORG_ID}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ org_profile_pic: null })
                });

                if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
                this.orgData.org_profile_pic = null;
                this.renderOrgData();
                this.showStatus('orgNameStatus', 'Profile picture removed', 'success');
            } catch (err) {
                console.error('Remove pic error:', err);
                this.showStatus('orgNameStatus', 'Error removing picture', 'error');
            }
        }

        async saveColor() {
            const color = document.getElementById('orgColorPicker').value.toUpperCase();

            try {
                const resp = await fetch(`${API_BASE}?action=save_color&org_id=${ORG_ID}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ org_color: color })
                });

                if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
                const data = await resp.json();
                if (data.ok) {
                    this.showStatus('orgColorStatus', 'Organization color saved', 'success');
                    this.orgData.org_color = color;
                } else {
                    this.showStatus('orgColorStatus', data.error || 'Failed to save', 'error');
                }
            } catch (err) {
                console.error('Save color error:', err);
                this.showStatus('orgColorStatus', 'Error saving color', 'error');
            }
        }

        showStatus(elementId, message, type) {
            const el = document.getElementById(elementId);
            el.textContent = message;
            el.className = `org-status-msg org-status-${type}`;
            setTimeout(() => {
                el.textContent = '';
                el.className = 'org-status-msg';
            }, 4000);
        }

        showError(msg) {
            const el = document.getElementById('orgNameStatus');
            el.textContent = msg;
            el.className = 'org-status-msg org-status-error';
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => new OrgManager());
    } else {
        new OrgManager();
    }
    </script>
</body>

</html>