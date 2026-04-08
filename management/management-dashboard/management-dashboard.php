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
    <link rel="stylesheet" href="style.css?v=2" />
</head>
<body>
<?php
require_once __DIR__ . '/../../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$sessionUser  = $_SESSION['user']      ?? 'Guest';
$sessionOrg   = $_SESSION['org_id']    ?? '—';
$sessionPerm  = $_SESSION['perm_group'] ?? '—';
// Build initials (up to 2 chars) for avatar
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
                <div class="breadcrumb">Admin › <span>Management</span></div>
            </div>
            <div class="header-controls">
                <span class="mode-badge">Live</span>
            </div>
        </div>

        <div class="mgmt-body">

            <!-- Left: configuration panel -->
            <div class="mgmt-config-panel" id="mgmtConfigPanel">
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

            <!-- Right: nav button column -->
            <aside class="mgmt-nav">
                <div class="mgmt-nav-label">Management Console</div>

                <button class="mgmt-nav-btn is-active" type="button" data-section="org">
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
    document.querySelectorAll('.mgmt-nav-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.mgmt-nav-btn').forEach(function(b) {
                b.classList.remove('is-active');
            });
            btn.classList.add('is-active');
        });
    });
</script>

</body>

</html>