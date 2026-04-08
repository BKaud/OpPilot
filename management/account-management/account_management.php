<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>OPilot – Account Management</title>
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
                <h1>Account Management</h1>
                <div class="breadcrumb">Admin › Management › <span>Account Management</span></div>
            </div>
            <div class="header-controls"><span class="mode-badge">Live</span></div>
        </div>

        <div class="dashboard-body" style="padding:18px;">
            <div class="zone-area">
                <div class="attraction-card" style="width:100%;">
                    <div class="card-thumb" style="height:84px; background:linear-gradient(135deg,#a3cbe6,#3aa0d6);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" style="width:44px;height:44px;">
                            <path d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3" />
                            <path d="M6 11c-1.66 0-3-1.34-3-3s1.34-3 3-3" />
                            <path d="M2 20c0-3.31 4.03-6 9-6s9 2.69 9 6" />
                        </svg>
                    </div>
                    <div class="card-body">
                        <div class="card-name">Account Management</div>
                        <div class="card-meta"><span>Users & teams</span></div>
                        <div style="margin-top:8px; color:var(--text-muted); font-size:13px;">
                            Manage user accounts: invite, disable, view activity, reset passwords and assign
                            roles/tiers.
                        </div>
                        <div style="margin-top:12px; display:flex; gap:8px;">
                            <a class="btn btn-teal" href="management.html">Back</a>
                            <a class="btn btn-gray" href="#">Invite User</a>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top:16px; color:var(--text-muted);">(Placeholder) Replace with user table and detail
                views.</div>
        </div>
    </div>
    </div>
</body>

</html>