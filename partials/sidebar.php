<?php
// partials/sidebar.php
// Expects bootstrap.php to have been included earlier so BASE_PATH, APP_ROOT and $currentPath are available.

// Defensive defaults
if (!defined('BASE_PATH')) define('BASE_PATH', '');
if (!defined('APP_ROOT')) define('APP_ROOT', __DIR__ . '/..');
if (!isset($currentPath)) $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

// Only define url_path() if it doesn't exist already
if (!function_exists('url_path')) {
    function url_path($path) {
        $base = rtrim(BASE_PATH, '/');
        $p = ltrim($path, '/');
        return ($base === '' ? '' : $base) . '/' . $p;
    }
}

// Only define nav_active() if it doesn't exist already
if (!function_exists('nav_active')) {
    function nav_active($relativePath) {
        global $currentPath;
        $target = rtrim(parse_url(url_path($relativePath), PHP_URL_PATH), '/');
        $cur = rtrim($currentPath ?? '/', '/');
        if ($cur === '') $cur = '/';
        return ($cur === $target || strpos($cur, $target . '/') === 0) ? 'active' : '';
    }
}
?>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="navbar-logo">
    <div class="logo-icon"></div>
    <span class="logo-name">O<span>P</span>ilot</span>
  </div>
  <div class="navbar-login">
    <input type="text" placeholder="Username" />
    <input type="password" placeholder="Password" />
    <button class="login-btn">Login</button>
  </div>
</nav>

<div class="main">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="nav-section">
      <div class="nav-upper">
        <div class="nav-item">
          <a href="<?php echo htmlspecialchars(url_path('home/home.php')); ?>" class="nav-link <?php echo nav_active('home/home.php'); ?>">
            <div class="nav-icon">
              <!-- home.svg inline -->
              <svg class="filter-999" style="width:22px; height:22px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2796 3.71579C12.097 3.66261 11.903 3.66261 11.7203 3.71579C11.6678 3.7311 11.5754 3.7694 11.3789 3.91817C11.1723 4.07463 10.9193 4.29855 10.5251 4.64896L5.28544 9.3064C4.64309 9.87739 4.46099 10.0496 4.33439 10.24C4.21261 10.4232 4.12189 10.6252 4.06588 10.8379C4.00765 11.0591 3.99995 11.3095 3.99995 12.169V17.17C3.99995 18.041 4.00076 18.6331 4.03874 19.0905C4.07573 19.536 4.14275 19.7634 4.22513 19.9219C4.41488 20.2872 4.71272 20.5851 5.07801 20.7748C5.23658 20.8572 5.46397 20.9242 5.90941 20.9612C6.36681 20.9992 6.95893 21 7.82995 21H7.99995V18C7.99995 15.7909 9.79081 14 12 14C14.2091 14 16 15.7909 16 18V21H16.17C17.041 21 17.6331 20.9992 18.0905 20.9612C18.5359 20.9242 18.7633 20.8572 18.9219 20.7748C19.2872 20.5851 19.585 20.2872 19.7748 19.9219C19.8572 19.7634 19.9242 19.536 19.9612 19.0905C19.9991 18.6331 20 18.041 20 17.17V12.169C20 11.3095 19.9923 11.0591 19.934 10.8379C19.878 10.6252 19.7873 10.4232 19.6655 10.24C19.5389 10.0496 19.3568 9.87739 18.7145 9.3064L13.4748 4.64896C13.0806 4.29855 12.8276 4.07463 12.621 3.91817C12.4245 3.7694 12.3321 3.7311 12.2796 3.71579ZM11.1611 1.79556C11.709 1.63602 12.2909 1.63602 12.8388 1.79556C13.2189 1.90627 13.5341 2.10095 13.8282 2.32363C14.1052 2.53335 14.4172 2.81064 14.7764 3.12995L20.0432 7.81159C20.0716 7.83679 20.0995 7.86165 20.1272 7.88619C20.6489 8.34941 21.0429 8.69935 21.3311 9.13277C21.5746 9.49916 21.7561 9.90321 21.8681 10.3287C22.0006 10.832 22.0004 11.359 22 12.0566C22 12.0936 22 12.131 22 12.169V17.212C22 18.0305 22 18.7061 21.9543 19.2561C21.9069 19.8274 21.805 20.3523 21.5496 20.8439C21.1701 21.5745 20.5744 22.1701 19.8439 22.5496C19.3522 22.805 18.8274 22.9069 18.256 22.9543C17.706 23 17.0305 23 16.2119 23H15.805C15.7972 23 15.7894 23 15.7814 23C15.6603 23 15.5157 23.0001 15.3883 22.9895C15.2406 22.9773 15.0292 22.9458 14.8085 22.8311C14.5345 22.6888 14.3111 22.4654 14.1688 22.1915C14.0542 21.9707 14.0227 21.7593 14.0104 21.6116C13.9998 21.4843 13.9999 21.3396 13.9999 21.2185L14 18C14 16.8954 13.1045 16 12 16C10.8954 16 9.99995 16.8954 9.99995 18L9.99996 21.2185C10 21.3396 10.0001 21.4843 9.98949 21.6116C9.97722 21.7593 9.94572 21.9707 9.83107 22.1915C9.68876 22.4654 9.46538 22.6888 9.19142 22.8311C8.9707 22.9458 8.75929 22.9773 8.6116 22.9895C8.48423 23.0001 8.33959 23 8.21847 23C8.21053 23 8.20268 23 8.19495 23H7.78798C6.96944 23 6.29389 23 5.74388 22.9543C5.17253 22.9069 4.64769 22.805 4.15605 22.5496C3.42548 22.1701 2.8298 21.5745 2.4503 20.8439C2.19492 20.3523 2.09305 19.8274 2.0456 19.2561C1.99993 18.7061 1.99994 18.0305 1.99995 17.212L1.99995 12.169C1.99995 12.131 1.99993 12.0936 1.99992 12.0566C1.99955 11.359 1.99928 10.832 2.1318 10.3287C2.24383 9.90321 2.42528 9.49916 2.66884 9.13277C2.95696 8.69935 3.35105 8.34941 3.87272 7.8862C3.90036 7.86165 3.92835 7.83679 3.95671 7.81159L9.22354 3.12996C9.58274 2.81064 9.89467 2.53335 10.1717 2.32363C10.4658 2.10095 10.781 1.90627 11.1611 1.79556Z" fill="#0F1729" />
              </svg>
            </div>
            <span class="nav-text">Homepage</span>
          </a>
        </div>

        <div class="nav-item expandable" id="zones">
          <a href="<?php echo htmlspecialchars(url_path('zones-dash/zone-dash.php')); ?>" class="nav-link" id="zones-toggle">
            <div class="nav-icon">
              <!-- zones icon -->
              <svg class="filter-999" style="width:22px; height:22px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 8.70938C3 7.23584 3 6.49907 3.39264 6.06935C3.53204 5.91678 3.70147 5.79466 3.89029 5.71066C4.42213 5.47406 5.12109 5.70705 6.51901 6.17302C7.58626 6.52877 8.11989 6.70665 8.6591 6.68823C8.85714 6.68147 9.05401 6.65511 9.24685 6.60952C9.77191 6.48541 10.2399 6.1734 11.176 5.54937L12.5583 4.62778C13.7574 3.82843 14.3569 3.42876 15.0451 3.3366C15.7333 3.24444 16.4168 3.47229 17.7839 3.92799L18.9487 4.31624C19.9387 4.64625 20.4337 4.81126 20.7169 5.20409C21 5.59692 21 6.11871 21 7.16229V15.2907C21 16.7642 21 17.501 20.6074 17.9307C20.468 18.0833 20.2985 18.2054 20.1097 18.2894C19.5779 18.526 18.8789 18.293 17.481 17.827C16.4137 17.4713 15.8801 17.2934 15.3409 17.3118C15.1429 17.3186 14.946 17.3449 14.7532 17.3905C14.2281 17.5146 13.7601 17.8266 12.824 18.4507L11.4417 19.3722C10.2426 20.1716 9.64311 20.5713 8.95493 20.6634C8.26674 20.7556 7.58319 20.5277 6.21609 20.072L5.05132 19.6838C4.06129 19.3538 3.56627 19.1888 3.28314 18.7959C3 18.4031 3 17.8813 3 16.8377V8.70938Z" stroke="#1C274C" stroke-width="1.5" />
                <path d="M9 6.63867V20.5" stroke="#1C274C" stroke-width="1.5" />
                <path d="M15 3V17" stroke="#1C274C" stroke-width="1.5" />
              </svg>
            </div> 
            <span class="nav-text">Zones</span>
          </a>

          <div class="sub-nav expanded" id="zones-sub">
            <div class="zone-item" id="rides1-zone">
              <a href="<?php echo htmlspecialchars(url_path('zones-dash/zone-dash.php')); ?>" class="sub-nav-link">Zones Dashboard</a>
            </div>

            <div class="zone-item expandable" id="rides1-zone">
              <a href="#" class="sub-nav-link expandable">Rides 1</a>
              <div class="zone-sub-nav expanded" id="rides1-sub">
                <a href="<?php echo htmlspecialchars(url_path('zone-manager/dashboard/dashboard.php')); ?>" class="zone-sub-link active">Dashboard</a>
                <a href="<?php echo htmlspecialchars(url_path('zone-manager/EditMode/editmode.php')); ?>" class="zone-sub-link">Edit Mode</a>
                <a href="<?php echo htmlspecialchars(url_path('zone-manager/confignsettings/settings.php')); ?>" class="zone-sub-link">Settings & Config</a>
              </div>
            </div>

            <div class="zone-item expandable" id="rides2-zone">
              <a href="#" class="sub-nav-link expandable">Rides 2</a>
              <div class="zone-sub-nav" id="rides2-sub">
                <a href="<?php echo htmlspecialchars(url_path('zone-manager/dashboard/dashboard.php')); ?>" class="zone-sub-link active">Dashboard</a>
                <a href="<?php echo htmlspecialchars(url_path('zone-manager/EditMode/editmode.php')); ?>" class="zone-sub-link">Edit Mode</a>
                <a href="<?php echo htmlspecialchars(url_path('zone-manager/confignsettings/settings.php')); ?>" class="zone-sub-link">Settings & Config</a>
              </div>
            </div>
          </div>
        </div>

        <div class="nav-item expandable" id="management">
          <a href="#" class="nav-link" id="management-toggle">
            <div class="nav-icon">
              <!-- manage.svg -->
              <svg class="filter-999" style="width:22px; height:22px;" fill="#000000" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <path d="M40,47H8a2,2,0,0,1-2-2V3A2,2,0,0,1,8,1H40a2,2,0,0,1,2,2V45A2,2,0,0,1,40,47ZM10,43H38V5H10Z" />
                <path d="M15,19a2,2,0,0,1-1.41-3.41l4-4a2,2,0,0,1,2.31-.37l2.83,1.42,5-4.16A2,2,0,0,1,30.2,8.4l4,3a2,2,0,1,1-2.4,3.2l-2.73-2.05-4.79,4a2,2,0,0,1-2.17.25L19.4,15.43l-3,3A2,2,0,0,1,15,19Z" />
                <circle cx="15" cy="24" r="2" />
                <circle cx="15" cy="31" r="2" />
                <circle cx="15" cy="38" r="2" />
                <path d="M33,26H22a2,2,0,0,1,0-4H33a2,2,0,0,1,0,4Z" />
                <path d="M33,33H22a2,2,0,0,1,0-4H33a2,2,0,0,1,0,4Z" />
                <path d="M33,40H22a2,2,0,0,1,0-4H33a2,2,0,0,1,0,4Z" />
              </svg>
            </div>
            <span class="nav-text">Management</span>
          </a>
          <div class="sub-nav" id="management-sub">
            <a href="<?php echo htmlspecialchars(url_path('management/management-dashboard/management-dashboard.php')); ?>" class="zone-sub-link">Dashboard</a>
            <a href="<?php echo htmlspecialchars(url_path('management/account-management/account_management.php')); ?>" class="zone-sub-link">Accounts</a>
            <a href="<?php echo htmlspecialchars(url_path('management/org-manangement/organization_management.php')); ?>" class="zone-sub-link">Organization</a>
            <a href="<?php echo htmlspecialchars(url_path('management/perm-management/permissions.php')); ?>" class="zone-sub-link">Permissions</a>
            <a href="<?php echo htmlspecialchars(url_path('management/perm-tier-management/permissions_tiers.php')); ?>" class="zone-sub-link">Permission Groups</a>
            <a href="<?php echo htmlspecialchars(url_path('management/zone-management/zone_management.php')); ?>" class="zone-sub-link">Zones</a>
          </div>
        </div>
      </div>

      <div class="nav-lower">
        <div class="nav-item">
          <a href="<?php echo htmlspecialchars(url_path('acc-sets/account-settings.php')); ?>" class="nav-link <?php echo nav_active('acc-sets/account-settings.php'); ?>">
            <div class="nav-icon">
              <!-- acc.svg -->
              <svg class="filter-999" style="width:20px; height:20px;" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path transform="translate(-84,-1999)" fill="#000" d="M100.562548,2016.99998 L87.4381713,2016.99998 C86.7317804,2016.99998 86.2101535,2016.30298 86.4765813,2015.66198 C87.7127655,2012.69798 90.6169306,2010.99998 93.9998492,2010.99998 C97.3837885,2010.99998 100.287954,2012.69798 101.524138,2015.66198 C101.790566,2016.30298 101.268939,2016.99998 100.562548,2016.99998 M89.9166645,2004.99998 C89.9166645,2002.79398 91.7489936,2000.99998 93.9998492,2000.99998 C96.2517256,2000.99998 98.0830339,2002.79398 98.0830339,2004.99998 C98.0830339,2007.20598 96.2517256,2008.99998 93.9998492,2008.99998 C91.7489936,2008.99998 89.9166645,2007.20598 89.9166645,2004.99998 M103.955674,2016.63598 C103.213556,2013.27698 100.892265,2010.79798 97.837022,2009.67298 C99.4560048,2008.39598 100.400241,2006.33098 100.053171,2004.06998 C99.6509769,2001.44698 97.4235996,1999.34798 94.7348224,1999.04198 C91.0232075,1998.61898 87.8750721,2001.44898 87.8750721,2004.99998 C87.8750721,2006.88998 88.7692896,2008.57398 90.1636971,2009.67298 C87.1074334,2010.79798 84.7871636,2013.27698 84.044024,2016.63598 C83.7745338,2017.85698 84.7789973,2018.99998 86.0539717,2018.99998 L101.945727,2018.99998 C103.221722,2018.99998 104.226185,2017.85698 103.955674,2016.63598" />
              </svg>
            </div>
            <span class="nav-text">Account Settings</span>
          </a>
        </div>

        <div class="nav-item">
          <a href="<?php echo htmlspecialchars(url_path('changelog/changelog.php')); ?>" class="nav-link <?php echo nav_active('changelog/changelog.php'); ?>">
            <div class="nav-icon">
              <!-- changelog.svg -->
              <svg class="filter-999" style="width:25px; height:25px;" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg" fill="none">
                <path stroke="#535358" stroke-linejoin="round" stroke-width="2" d="M6 5a2 2 0 012-2h16a2 2 0 012 2v22a2 2 0 01-2 2H8a2 2 0 01-2-2V5z" />
                <path stroke="#535358" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9h4M10 16h12M10 20h12M10 24h4" />
                <circle cx="22" cy="9" r="1" fill="#535358" />
              </svg>
            </div>
            <span class="nav-text">Changelog</span>
          </a>
        </div>
      </div>
    </div>
  </aside>

<!-- Optional: put the JS that toggles expansion in a single file and include it once per page -->
<script>
  // Minimal client-side toggles (won't duplicate because partial is included once)
  document.addEventListener('DOMContentLoaded', function() {
    // Zones dropdown
    var zonesToggle = document.getElementById('zones-toggle');
    if (zonesToggle) {
      zonesToggle.addEventListener('click', function(e) {
        e.preventDefault();
        var zonesSub = document.getElementById('zones-sub');
        if (zonesSub) zonesSub.classList.toggle('expanded');
      });
    }
    document.querySelectorAll('.zone-item .sub-nav-link.expandable').forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        var parent = link.closest('.zone-item');
        var sub = parent.querySelector('.zone-sub-nav');
        if (sub) sub.classList.toggle('expanded');
      });
    });
    // Management dropdown
    var managementToggle = document.getElementById('management-toggle');
    if (managementToggle) {
      managementToggle.addEventListener('click', function(e) {
        e.preventDefault();
        var managementSub = document.getElementById('management-sub');
        if (managementSub) managementSub.classList.toggle('expanded');
      });
    }
  });
</script>