<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Operator Rotation Manager</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="../../assets/css/theme.css" />
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar">
    <div id="navbar-logo" class="navbar-logo">
      <img id="logoanim" src="../../assets/images/icons/compassanim.gif" alt="OPilot Logo" />
      <img id="logotext" class="logoText" src="../../assets/images/oppilottext.png" />
    </div>
    <div class="navbar-login">
      <div class="login-fields">
        <input type="text" placeholder="Username" />
        <input type="password" placeholder="Password" />
      </div>
      <button class="login-btn">Login</button>
    </div>
  </nav>

  <div class="main">
    <!-- Enhanced Sidebar with Navigation -->
    <aside id="sidebar" class="sidebar closed">
      <div class="nav-section">
        <div class="nav-upper">
          <!-- Homepage -->
          <div class="nav-item">
            <a href="#" class="nav-link active">
              <div class="nav-icon"><img src="../../assets/images/icons/homepage.png"></div>
              <span class="nav-text">Homepage</span>
            </a>
          </div>

          <!-- Zones (Expandable) -->
          <div class="nav-item expandable" id="zones">
            <a href="#" class="nav-link expandable">
              <div class="nav-icon"><img src="../../assets/images/icons/zones.png"></div>
              <span class="nav-text">Zones</span>
            </a>
            <div class="sub-nav" id="zones-sub">
              <!-- Rides 1 Zone -->
              <div class="zone-item expandable" id="rides1-zone">
                <a href="#" class="sub-nav-link expandable">
                  <span class="nav-text">Rides 1</span>
                </a>
                <div class="zone-sub-nav" id="rides1-sub">
                  <a href="#" class="zone-sub-link">
                    <span class="nav-text">Dashboard</span>
                  </a>
                  <a href="#" class="zone-sub-link">
                    <span class="nav-text">Edit Mode</span>
                  </a>
                  <a href="#" class="zone-sub-link">
                    <span class="nav-text">Config</span>
                  </a>
                  <a href="#" class="zone-sub-link">
                    <span class="nav-text">Settings</span>
                  </a>
                </div>
              </div>

              <!-- Example of another zone -->
              <div class="zone-item expandable" id="rides2-zone">
                <a href="#" class="sub-nav-link expandable">
                  <span class="nav-text">Rides 2</span>
                </a>
                <div class="zone-sub-nav" id="rides2-sub">
                  <a href="#" class="zone-sub-link">
                    <span class="nav-text">Dashboard</span>
                  </a>
                  <a href="#" class="zone-sub-link">
                    <span class="nav-text">Edit Mode</span>
                  </a>
                  <a href="#" class="zone-sub-link">
                    <span class="nav-text">Config</span>
                  </a>
                  <a href="#" class="zone-sub-link">
                    <span class="nav-text">Settings</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="nav-lower">
          <!-- Bottom Navigation Items -->
          <div class="bottom-section">
            <div class="nav-item">
              <a href="#" class="nav-link">
                <div class="nav-icon"><img src="../../assets/images/icons/accsett.png"></div>
                <span class="nav-text">Account Settings</span>
              </a>
            </div>
            <div class="nav-item">
              <a href="#" class="nav-link">
                <div class="nav-icon"><img src="../../assets/images/icons/changelog.png"></div>
                <span class="nav-text">Changelog</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <script>
      // Rotation slider functionality
      const slider = document.getElementById('rotationSlider');
      const valueDisplay = document.getElementById('rotationValue');

      slider.addEventListener('input', function () {
        valueDisplay.textContent = this.value + '%';
      });

      // Tab filtering
      const tabs = document.querySelectorAll('.tab');
      const rideCards = document.querySelectorAll('.ride-card');

      tabs.forEach(tab => {
        tab.addEventListener('click', function () {
          // Remove active class from all tabs
          tabs.forEach(t => t.classList.remove('active'));
          // Add active to clicked tab
          this.classList.add('active');

          const filter = this.textContent.toLowerCase();

          rideCards.forEach(card => {
            if (filter === 'all') {
              card.style.display = 'block';
            } else {
              const status = card.querySelector('.ride-status');
              if (status.textContent.toLowerCase().includes(filter) ||
                (filter === 'vacant' && card.querySelector('.vacant-indicator'))) {
                card.style.display = 'block';
              } else {
                card.style.display = 'none';
              }
            }
          });
        });
      });

      // Add hover effects and interactions
      document.querySelectorAll('.ride-card').forEach(card => {
        card.addEventListener('click', function () {
          // Could open detailed view modal
          console.log('Opening detailed view for:', this.querySelector('.ride-name').textContent);
        });
      });
      document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const logoAnim = document.getElementById('logoanim');
        const logoText = document.getElementById('logotext');

        // Sidebar hover functionality
        sidebar.addEventListener('mouseover', () => {
          const isOpen = sidebar.classList.toggle('open');
          sidebar.classList.toggle('closed', !isOpen);
          logoText.classList.remove('logoText');
          logoText.classList.add('act');
        });

        sidebar.addEventListener('mouseout', () => {
          logoText.classList.remove('act');
          logoText.classList.add('logoText');
        });

        // Zone expansion functionality - FIXED
        document.getElementById('zones').addEventListener('click', function (e) {
          // Only handle clicks on the main zones link, not child elements
          if (e.target.closest('.nav-link') === this.querySelector('.nav-link')) {
            e.preventDefault();
            e.stopPropagation(); // Prevent event bubbling

            const subNav = document.getElementById('zones-sub');
            const expandable = this.querySelector('.nav-link');

            if (subNav.classList.contains('expanded')) {
              subNav.classList.remove('expanded');
              expandable.classList.remove('expanded');
            } else {
              subNav.classList.add('expanded');
              expandable.classList.add('expanded');
            }
          }
        });

        // Individual zone expansion (Rides 1, Rides 2, etc.) - FIXED
        document.querySelectorAll('.zone-item').forEach(zoneItem => {
          zoneItem.addEventListener('click', function (e) {
            // Only handle clicks on the zone's own expandable link
            if (e.target.closest('.sub-nav-link') === this.querySelector('.sub-nav-link')) {
              e.preventDefault();
              e.stopPropagation(); // Prevent event bubbling to parent zones

              const zoneSubNav = this.querySelector('.zone-sub-nav');
              const expandable = this.querySelector('.sub-nav-link');

              if (zoneSubNav.classList.contains('expanded')) {
                zoneSubNav.classList.remove('expanded');
                expandable.classList.remove('expanded');
              } else {
                zoneSubNav.classList.add('expanded');
                expandable.classList.add('expanded');
              }
            }
          });
        });

        // Navigation link clicks
        document.querySelectorAll('.nav-link, .sub-nav-link, .zone-sub-link').forEach(link => {
          link.addEventListener('click', function (e) {
            if (!this.classList.contains('expandable')) {
              e.stopPropagation(); // Prevent bubbling for non-expandable links
              // Remove active class from all nav items
              document.querySelectorAll('.nav-link, .sub-nav-link, .zone-sub-link').forEach(item => {
                item.classList.remove('active');
              });
              // Add active class to clicked item
              this.classList.add('active');
            }
          });
        });

        // Edit mode toggle (works from any Edit Mode link)
        document.addEventListener('click', function (e) {
          if (e.target.textContent.trim() === 'Edit Mode') {
            e.preventDefault();
            e.stopPropagation();
            document.body.classList.toggle('edit-mode');
          }
        });

        // Toggle Zones Collapsibility
        const zones = document.getElementById('zones');
        const zonesSub = document.getElementById('zones-sub');
        zones.addEventListener('click', function (e) {
          e.preventDefault();
          zonesSub.classList.toggle('collapsed');
        });
      });
    </script>
    <script type="text/javascript" src="layoutedit.js"></script>
</body>

</html>