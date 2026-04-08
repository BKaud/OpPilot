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

        <div class="dashboard-body" style="padding:18px;">
            <div class="zone-area">
                <div class="attraction-card" style="width:100%;">
                    <div class="card-thumb" style="height:84px; background:linear-gradient(135deg,#cfa3d6,#9b6fb0);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" style="width:44px;height:44px;">
                            <path d="M3 7h18" />
                            <path d="M5 21h14v-8H5z" />
                            <circle cx="12" cy="4" r="2" />
                        </svg>
                    </div>
                    <div class="card-body">
                        <div class="card-name">Organization Management</div>
                        <div class="card-meta"><span>Org-wide settings</span></div>
                        <div style="margin-top:8px; color:var(--text-muted); font-size:13px;">
                            Billing, integrations, global policies and other organization-level settings live here.
                        </div>
                        <div style="margin-top:12px; display:flex; gap:8px;">
                            <a class="btn btn-teal" href="management.html">Back</a>
                            <a class="btn btn-gray" href="#">Edit Organization</a>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top:16px; color:var(--text-muted);">(Placeholder) Add billing and organization settings
                UI here.</div>
        </div>
    </div>
    </div>
</body>

</html>