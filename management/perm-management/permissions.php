<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>OPilot – Permissions</title>
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
                <h1>Permissions</h1>
                <div class="breadcrumb">Admin › Management › <span>Permissions</span></div>
            </div>
            <div class="header-controls">
                <span class="mode-badge">Live</span>
            </div>
        </div>

        <div class="dashboard-body" style="padding:18px;">
            <div class="zone-area">
                <div class="attraction-card" style="width:100%; min-width:auto;">
                    <div class="card-thumb" style="height:84px; background:linear-gradient(135deg,#6fb4a3,#1a8f7a);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" style="width:44px;height:44px;">
                            <path d="M12 2a4 4 0 014 4v2a4 4 0 01-8 0V6a4 4 0 014-4z" />
                            <path d="M6 20v-2a6 6 0 0112 0v2" />
                        </svg>
                    </div>
                    <div class="card-body">
                        <div class="card-name">Permissions</div>
                        <div class="card-meta"><span>Overview & management</span></div>
                        <div style="margin-top:8px; color:var(--text-muted); font-size:13px;">
                            This page will list individual permissions that can be granted to users or tiers. Add, edit,
                            or remove permissions here.
                        </div>

                        <div style="margin-top:12px; display:flex; gap:8px;">
                            <a class="btn btn-teal" href="management.html">Back</a>
                            <a class="btn btn-gray" href="#">Create Permission</a>
                        </div>
                    </div>
                </div>
            </div>

            <div style="height:20px;"></div>
            <div style="color:var(--text-muted); font-size:13px;">
                (Placeholder) Replace with a table or form to manage permission records.
            </div>
        </div>
    </div>
    </div>
</body>

</html>