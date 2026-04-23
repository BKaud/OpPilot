<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OPilot – Dashboard</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
<?php
require_once __DIR__ . '/../bootstrap.php';
require_once APP_ROOT . '/partials/sidebar.php';
?>

<div class="content-wrapper demo-dashboard" >
  <div class="dashboard-container">
    <!-- Top Stats Bar -->
    <div class="stats-bar">
      <div class="stat-card">
        <div class="stat-label">PVE</div>
        <div class="stat-value">CPU 1%</div>
        <div class="stat-detail">13th Gen Intel | Core i7 @ 3500k</div>
        <div class="stat-row">
          <span>Mem 97%</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-label">NAS</div>
        <div class="stat-value">1.018 GiB Used</div>
        <div class="stat-detail">70 TiB Free</div>
        <div class="stat-row">
          <span>70.6 TiB Total</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-label">Internal</div>
        <div class="stat-value">9 kbit/s TX</div>
        <div class="stat-detail"></div>
      </div>

      <div class="stat-card">
        <div class="stat-label">vmkrl</div>
        <div class="stat-value">2 kbit/s RX</div>
        <div class="stat-detail"></div>
      </div>

      <div class="stat-card">
        <div class="stat-label">External</div>
        <div class="stat-value">540 kbit/s TX</div>
        <div class="stat-detail"></div>
      </div>

      <div class="stat-card">
        <div class="stat-label">emplsd</div>
        <div class="stat-value">50 kbit/s RX</div>
        <div class="stat-detail"></div>
      </div>

      <div class="stat-card weather-stat">
        <div class="weather-icon">☀️</div>
        <div class="weather-info">
          <div class="stat-label">Current 13.1°F</div>
          <div class="stat-detail">Clear</div>
        </div>
      </div>
    </div>

    <!-- Services Grid -->
    <div class="services-grid">
      <!-- Plex Card -->
      <div class="service-card plex-card">
        <div class="card-header">
          <div class="card-icon">⏰</div>
          <div class="card-title">
            <h3>Current Time</h3>
          </div>
        </div>
        <div class="card-status">Running</div>
        <div class="card-details">
          <div id="current-time-clock" class="clock-display"></div>
          <div class="progress-bar"></div>
        </div>
      </div>

      <!-- Emby Card -->
      <div class="service-card emby-card">
        <div class="card-header">
          <div class="card-icon">📅</div>
          <div class="card-title">
            <h3>Current Date</h3>
          </div>
        </div>
        <div class="card-status">Running</div>
        <div class="card-details">
          <div id="current-date-display" class="date-display"></div>
        </div>
      </div>

      <!-- Overseerr Card -->
      <div class="service-card overseerr-card">
        <div class="card-header">
          <div class="card-icon">👤</div>
          <div class="card-title">
            <h3>Current User</h3>
            <p>Request movies and TV shows</p>
          </div>
        </div>
        <div class="card-stats">
          <div class="stat">
            <span class="number">0</span>
            <span class="label">PENDING</span>
          </div>
          <div class="stat">
            <span class="number">22</span>
            <span class="label">AVAILABLE</span>
          </div>
        </div>
      </div>

      <!-- Radarr Card -->
      <div class="service-card radarr-card">
        <div class="card-header">
          <div class="card-icon">📊</div>
          <div class="card-title">
            <h3>Ride Status</h3>
            <p>Request and manage movies</p>
          </div>
        </div>
        <div class="card-stats">
          <div class="stat">
            <span class="number">65</span>
            <span class="label">WANTED</span>
          </div>
          <div class="stat">
            <span class="number">256</span>
            <span class="label">MOVIES</span>
          </div>
        </div>
      </div>

      <!-- Sonarr Card -->
      <div class="service-card sonarr-card">
        <div class="card-header">
          <div class="card-icon">✅</div>
          <div class="card-title">
            <h3>Open Rides Count</h3>
            <p>Request and manage TV shows</p>
          </div>
        </div>
        <div class="card-stats">
          <div class="stat">
            <span class="number">508</span>
            <span class="label">WANTED</span>
          </div>
          <div class="stat">
            <span class="number">11</span>
            <span class="label">SERIES</span>
          </div>
        </div>
      </div>

      <!-- SABnzbd Card -->
      <div class="service-card sabnzbd-card">
        <div class="card-header">
          <div class="card-icon">⭐</div>
          <div class="card-title">
            <h3>Zone Lead</h3>
            <p>Usenet downloader</p>
          </div>
        </div>
        <div class="card-stats">
          <div class="stat">
            <span class="number">0 b/s</span>
            <span class="label">RATE</span>
          </div>
          <div class="stat">
            <span class="number">0</span>
            <span class="label">QUEUE</span>
          </div>
        </div>
      </div>

      <!-- Deluge Card -->
      <div class="service-card deluge-card">
        <div class="card-header">
          <div class="card-icon">🔄</div>
          <div class="card-title">
            <h3>Zone Rotation Timer</h3>
            <p>Torrent downloader</p>
          </div>
        </div>
        <div class="card-stats">
          <div class="stat">
            <span class="number">0 B/s</span>
            <span class="label">DOWNLOAD</span>
          </div>
          <div class="stat">
            <span class="number">211 kB/s</span>
            <span class="label">UPLOAD</span>
          </div>
        </div>
      </div>

      <!-- Prowlarr Card -->
      <div class="service-card prowlarr-card">
        <div class="card-header">
          <div class="card-icon">🏢</div>
          <div class="card-title">
            <h3>Organisation Name</h3>
            <p>Indexer and manager</p>
          </div>
        </div>
        <div class="card-stats">
          <div class="stat">
            <span class="number">312</span>
            <span class="label">GRABS</span>
          </div>
          <div class="stat">
            <span class="number">890</span>
            <span class="label">QUERIES</span>
          </div>
        </div>
      </div>

      <!-- Proxmox VE Card -->
      <div class="service-card proxmox-card">
        <div class="card-header">
          <div class="card-icon">🔗</div>
          <div class="card-title">
            <h3>Quick Link</h3>
            <p>Virtualization platform</p>
          </div>
        </div>
        <div class="card-stats">
          <div class="stat">
            <span class="number">4 / 5</span>
            <span class="label">VMS</span>
          </div>
          <div class="stat">
            <span class="number">2%</span>
            <span class="label">CPU</span>
          </div>
          <div class="stat">
            <span class="number">96%</span>
            <span class="label">MEM</span>
          </div>
        </div>
      </div>

      
  </div>
</div>

<script>
  // Update time every second
  function updateTime() {
    const now = new Date();
    const time = now.toLocaleTimeString('en-US', { hour12: false });
    const date = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    document.getElementById('current-time-clock').textContent = time;
    document.getElementById('current-date-display').textContent = date;
  }
  
  updateTime();
  setInterval(updateTime, 1000);
</script>

</body>

</html>