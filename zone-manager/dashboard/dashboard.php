<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>OPilot – Zone Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="../../assets/css/theme.css" />
<link rel="stylesheet" href="style.css" />
</head>
<body>

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
          <a href="#" class="nav-link">
            <div class="nav-icon">
              <!-- home.svg -->
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2796 3.71579C12.097 3.66261 11.903 3.66261 11.7203 3.71579C11.6678 3.7311 11.5754 3.7694 11.3789 3.91817C11.1723 4.07463 10.9193 4.29855 10.5251 4.64896L5.28544 9.3064C4.64309 9.87739 4.46099 10.0496 4.33439 10.24C4.21261 10.4232 4.12189 10.6252 4.06588 10.8379C4.00765 11.0591 3.99995 11.3095 3.99995 12.169V17.17C3.99995 18.041 4.00076 18.6331 4.03874 19.0905C4.07573 19.536 4.14275 19.7634 4.22513 19.9219C4.41488 20.2872 4.71272 20.5851 5.07801 20.7748C5.23658 20.8572 5.46397 20.9242 5.90941 20.9612C6.36681 20.9992 6.95893 21 7.82995 21H7.99995V18C7.99995 15.7909 9.79081 14 12 14C14.2091 14 16 15.7909 16 18V21H16.17C17.041 21 17.6331 20.9992 18.0905 20.9612C18.5359 20.9242 18.7633 20.8572 18.9219 20.7748C19.2872 20.5851 19.585 20.2872 19.7748 19.9219C19.8572 19.7634 19.9242 19.536 19.9612 19.0905C19.9991 18.6331 20 18.041 20 17.17V12.169C20 11.3095 19.9923 11.0591 19.934 10.8379C19.878 10.6252 19.7873 10.4232 19.6655 10.24C19.5389 10.0496 19.3568 9.87739 18.7145 9.3064L13.4748 4.64896C13.0806 4.29855 12.8276 4.07463 12.621 3.91817C12.4245 3.7694 12.3321 3.7311 12.2796 3.71579ZM11.1611 1.79556C11.709 1.63602 12.2909 1.63602 12.8388 1.79556C13.2189 1.90627 13.5341 2.10095 13.8282 2.32363C14.1052 2.53335 14.4172 2.81064 14.7764 3.12995L20.0432 7.81159C20.0716 7.83679 20.0995 7.86165 20.1272 7.88619C20.6489 8.34941 21.0429 8.69935 21.3311 9.13277C21.5746 9.49916 21.7561 9.90321 21.8681 10.3287C22.0006 10.832 22.0004 11.359 22 12.0566C22 12.0936 22 12.131 22 12.169V17.212C22 18.0305 22 18.7061 21.9543 19.2561C21.9069 19.8274 21.805 20.3523 21.5496 20.8439C21.1701 21.5745 20.5744 22.1701 19.8439 22.5496C19.3522 22.805 18.8274 22.9069 18.256 22.9543C17.706 23 17.0305 23 16.2119 23H15.805C15.7972 23 15.7894 23 15.7814 23C15.6603 23 15.5157 23.0001 15.3883 22.9895C15.2406 22.9773 15.0292 22.9458 14.8085 22.8311C14.5345 22.6888 14.3111 22.4654 14.1688 22.1915C14.0542 21.9707 14.0227 21.7593 14.0104 21.6116C13.9998 21.4843 13.9999 21.3396 13.9999 21.2185L14 18C14 16.8954 13.1045 16 12 16C10.8954 16 9.99995 16.8954 9.99995 18L9.99996 21.2185C10 21.3396 10.0001 21.4843 9.98949 21.6116C9.97722 21.7593 9.94572 21.9707 9.83107 22.1915C9.68876 22.4654 9.46538 22.6888 9.19142 22.8311C8.9707 22.9458 8.75929 22.9773 8.6116 22.9895C8.48423 23.0001 8.33959 23 8.21847 23C8.21053 23 8.20268 23 8.19495 23H7.78798C6.96944 23 6.29389 23 5.74388 22.9543C5.17253 22.9069 4.64769 22.805 4.15605 22.5496C3.42548 22.1701 2.8298 21.5745 2.4503 20.8439C2.19492 20.3523 2.09305 19.8274 2.0456 19.2561C1.99993 18.7061 1.99994 18.0305 1.99995 17.212L1.99995 12.169C1.99995 12.131 1.99993 12.0936 1.99992 12.0566C1.99955 11.359 1.99928 10.832 2.1318 10.3287C2.24383 9.90321 2.42528 9.49916 2.66884 9.13277C2.95696 8.69935 3.35105 8.34941 3.87272 7.8862C3.90036 7.86165 3.92835 7.83679 3.95671 7.81159L9.22354 3.12996C9.58274 2.81064 9.89467 2.53335 10.1717 2.32363C10.4658 2.10095 10.781 1.90627 11.1611 1.79556Z" fill="#0F1729"/></svg>
            </div>
            <span class="nav-text">Homepage</span>
          </a>
        </div>
        <div class="nav-item expandable" id="zones">
          <a href="#" class="nav-link" id="zones-toggle">
            <div class="nav-icon">
              <!-- zones.svg -->
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8.70938C3 7.23584 3 6.49907 3.39264 6.06935C3.53204 5.91678 3.70147 5.79466 3.89029 5.71066C4.42213 5.47406 5.12109 5.70705 6.51901 6.17302C7.58626 6.52877 8.11989 6.70665 8.6591 6.68823C8.85714 6.68147 9.05401 6.65511 9.24685 6.60952C9.77191 6.48541 10.2399 6.1734 11.176 5.54937L12.5583 4.62778C13.7574 3.82843 14.3569 3.42876 15.0451 3.3366C15.7333 3.24444 16.4168 3.47229 17.7839 3.92799L18.9487 4.31624C19.9387 4.64625 20.4337 4.81126 20.7169 5.20409C21 5.59692 21 6.11871 21 7.16229V15.2907C21 16.7642 21 17.501 20.6074 17.9307C20.468 18.0833 20.2985 18.2054 20.1097 18.2894C19.5779 18.526 18.8789 18.293 17.481 17.827C16.4137 17.4713 15.8801 17.2934 15.3409 17.3118C15.1429 17.3186 14.946 17.3449 14.7532 17.3905C14.2281 17.5146 13.7601 17.8266 12.824 18.4507L11.4417 19.3722C10.2426 20.1716 9.64311 20.5713 8.95493 20.6634C8.26674 20.7556 7.58319 20.5277 6.21609 20.072L5.05132 19.6838C4.06129 19.3538 3.56627 19.1888 3.28314 18.7959C3 18.4031 3 17.8813 3 16.8377V8.70938Z" stroke="#1C274C" stroke-width="1.5"/><path d="M9 6.63867V20.5" stroke="#1C274C" stroke-width="1.5"/><path d="M15 3V17" stroke="#1C274C" stroke-width="1.5"/></svg>
            </div>
            <span class="nav-text">Zones</span>
          </a>
          <div class="sub-nav expanded" id="zones-sub">
            <!-- Zone Dashboard section -->
            <div class="zone-dashboard-section" style="margin: 8px 0 8px 16px;">
              <a href="dashboard.php" class="zone-dashboard-link" style="display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--teal);">
                <span class="zone-dashboard-icon" style="display: flex; align-items: center;">
                  <!-- zonedash.svg -->
                  <svg width="16" height="16" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 5.75C9.91421 5.75 10.25 5.41421 10.25 5C10.25 4.58579 9.91421 4.25 9.5 4.25V5.75ZM4.75 11C4.75 11.4142 5.08579 11.75 5.5 11.75C5.91421 11.75 6.25 11.4142 6.25 11H4.75ZM9.5 4.25C9.08579 4.25 8.75 4.58579 8.75 5C8.75 5.41421 9.08579 5.75 9.5 5.75V4.25ZM18.75 11C18.75 11.4142 19.0858 11.75 19.5 11.75C19.9142 11.75 20.25 11.4142 20.25 11H18.75ZM10.25 5C10.25 4.58579 9.91421 4.25 9.5 4.25C9.08579 4.25 8.75 4.58579 8.75 5H10.25ZM8.75 11C8.75 11.4142 9.08579 11.75 9.5 11.75C9.91421 11.75 10.25 11.4142 10.25 11H8.75ZM9.5 11.75C9.91421 11.75 10.25 11.4142 10.25 11C10.25 10.5858 9.91421 10.25 9.5 10.25V11.75ZM5.5 10.25C5.08579 10.25 4.75 10.5858 4.75 11C4.75 11.4142 5.08579 11.75 5.5 11.75V10.25ZM9.5 10.25C9.08579 10.25 8.75 10.5858 8.75 11C8.75 11.4142 9.08579 11.75 9.5 11.75V10.25ZM19.5 11.75C19.9142 11.75 20.25 11.4142 20.25 11C20.25 10.5858 19.9142 10.25 19.5 10.25V11.75ZM6.25 11C6.25 10.5858 5.91421 10.25 5.5 10.25C5.08579 10.25 4.75 10.5858 4.75 11H6.25ZM20.25 11C20.25 10.5858 19.9142 10.25 19.5 10.25C19.0858 10.25 18.75 10.5858 18.75 11H20.25ZM9.5 4.25C6.87665 4.25 4.75 6.37665 4.75 9H6.25C6.25 7.20507 7.70507 5.75 9.5 5.75V4.25ZM4.75 9V11H6.25V9H4.75ZM9.5 5.75H15.5V4.25H9.5V5.75ZM15.5 5.75C17.2949 5.75 18.75 7.20507 18.75 9H20.25C20.25 6.37665 18.1234 4.25 15.5 4.25V5.75ZM18.75 9V11H20.25V9H18.75ZM8.75 5V11H10.25V5H8.75ZM9.5 10.25H5.5V11.75H9.5V10.25ZM9.5 11.75H19.5V10.25H9.5V11.75ZM4.75 11V15H6.25V11H4.75ZM4.75 15C4.75 17.6234 6.87665 19.75 9.5 19.75V18.25C7.70507 18.25 6.25 16.7949 6.25 15H4.75ZM9.5 19.75H15.5V18.25H9.5V19.75ZM15.5 19.75C18.1234 19.75 20.25 17.6234 20.25 15H18.75C18.75 16.7949 17.2949 18.25 15.5 18.25V19.75ZM20.25 15V11H18.75V15H20.25Z" fill="#000000"/></svg>
                </span>
                <span>Zone Dashboard</span>
              </a>
            </div>
            <div class="zone-item expandable" id="rides1-zone">
              <a href="#" class="sub-nav-link expandable">Rides 1</a>
              <div class="zone-sub-nav expanded" id="rides1-sub">
                <a href="dashboard.php" class="zone-sub-link active">Dashboard</a>
                <a href="../EditMode/editmode.php" class="zone-sub-link">Edit Mode</a>
                <a href="../confignsettings/settings.php" class="zone-sub-link">Settings & Config</a>
              </div>
            </div>
            <div class="zone-item expandable" id="rides2-zone">
              <a href="#" class="sub-nav-link expandable">Rides 2</a>
              <div class="zone-sub-nav" id="rides2-sub">
                <a href="#" class="zone-sub-link">Dashboard</a>
                <a href="#" class="zone-sub-link">Edit Mode</a>
                <a href="#" class="zone-sub-link">Settings & Config</a>
              </div>
            </div>
          </div>
        </div>
        <div class="nav-item">
          <a href="../../management/management-dashboard/management-dashboard.php" class="nav-link">
            <div class="nav-icon">
              <!-- manage.svg -->
              <svg width="22" height="22" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M40,47H8a2,2,0,0,1-2-2V3A2,2,0,0,1,8,1H40a2,2,0,0,1,2,2V45A2,2,0,0,1,40,47ZM10,43H38V5H10Z"/><path d="M15,19a2,2,0,0,1-1.41-3.41l4-4a2,2,0,0,1,2.31-.37l2.83,1.42,5-4.16A2,2,0,0,1,30.2,8.4l4,3a2,2,0,1,1-2.4,3.2l-2.73-2.05-4.79,4a2,2,0,0,1-2.17.25L19.4,15.43l-3,3A2,2,0,0,1,15,19Z"/><circle cx="15" cy="24" r="2"/><circle cx="15" cy="31" r="2"/><circle cx="15" cy="38" r="2"/><path d="M33,26H22a2,2,0,0,1,0-4H33a2,2,0,0,1,0,4Z"/><path d="M33,33H22a2,2,0,0,1,0-4H33a2,2,0,0,1,0,4Z"/><path d="M33,40H22a2,2,0,0,1,0-4H33a2,2,0,0,1,0,4Z"/></svg>
            </div>
            <span class="nav-text">Management</span>
          </a>
        </div>
      </div>
      <div class="nav-lower">
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon">
              <!-- acc.svg -->
              <svg width="22" height="22" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Dribbble-Light-Preview" transform="translate(-140.000000, -2159.000000)" fill="#000000"><g id="icons" transform="translate(56.000000, 160.000000)"><path d="M100.562548,2016.99998 L87.4381713,2016.99998 C86.7317804,2016.99998 86.2101535,2016.30298 86.4765813,2015.66198 C87.7127655,2012.69798 90.6169306,2010.99998 93.9998492,2010.99998 C97.3837885,2010.99998 100.287954,2012.69798 101.524138,2015.66198 C101.790566,2016.30298 101.268939,2016.99998 100.562548,2016.99998 M89.9166645,2004.99998 C89.9166645,2002.79398 91.7489936,2000.99998 93.9998492,2000.99998 C96.2517256,2000.99998 98.0830339,2002.79398 98.0830339,2004.99998 C98.0830339,2007.20598 96.2517256,2008.99998 93.9998492,2008.99998 C91.7489936,2008.99998 89.9166645,2007.20598 89.9166645,2004.99998 M103.955674,2016.63598 C103.213556,2013.27698 100.892265,2010.79798 97.837022,2009.67298 C99.4560048,2008.39598 100.400241,2006.33098 100.053171,2004.06998 C99.6509769,2001.44698 97.4235996,1999.34798 94.7348224,1999.04198 C91.0232075,1998.61898 87.8750721,2001.44898 87.8750721,2004.99998 C87.8750721,2006.88998 88.7692896,2008.57398 90.1636971,2009.67298 C87.1074334,2010.79798 84.7871636,2013.27698 84.044024,2016.63598 C83.7745338,2017.85698 84.7789973,2018.99998 86.0539717,2018.99998 L101.945727,2018.99998 C103.221722,2018.99998 104.226185,2017.85698 103.955674,2016.63598" id="profile_round-[#1342]"></path></g></g></g></svg>
            </div>
            <span class="nav-text">Account Settings</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon">
              <!-- changelog.svg -->
              <svg width="22" height="22" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path stroke="#535358" stroke-linejoin="round" stroke-width="2" d="M6 5a2 2 0 012-2h16a2 2 0 012 2v22a2 2 0 01-2 2H8a2 2 0 01-2-2V5z"/><path stroke="#535358" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9h4M10 16h12M10 20h12M10 24h4"/><circle cx="22" cy="9" r="1" fill="#535358"/></svg>
            </div>
            <span class="nav-text">Changelog</span>
          </a>
        </div>
      </div>
    </div>
  </aside>

  <!-- CONTENT -->
  <div class="content">
    <div class="page-header">
      <div>
        <h1>Zone Dashboard</h1>
        <div class="breadcrumb">Zones › Rides 1 › <span>Dashboard</span></div>
      </div>
      <div class="header-controls">
        <span class="mode-badge" id="modeBadge">Live</span>
        <button class="btn btn-gray btn-sm" onclick="togglePreviewMode()">Preview Mode</button>
        <button class="btn btn-teal btn-sm">Rotate Now</button>
      </div>
    </div>

    <div class="dashboard-body">

      <!-- ZONE GRID -->
      <div class="zone-area">
        <div class="time-strip">
          <div>
            <div class="time-now" id="timeNow">10:32 AM <span id="timeNote">LIVE</span></div>
            <div class="breadcrumb" style="font-size:10px;">Next rotation in <strong id="rotCountdown">12:44</strong></div>
          </div>
          <div class="time-preview-tag" id="previewTag">⚡ PREVIEW MODE</div>
        </div>

        <!-- Section: Rotation Concepts -->
        <div class="attraction-section">
          <div class="section-label">Rotation Display Ideas</div>
          <div class="attraction-row" id="rotationRow">
            
            <!-- CONCEPT 1: Circular Position Wheel -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #2a9d7f, #1a6f5a); position: relative;">
                <div class="card-status-dot"></div>
                <svg viewBox="0 0 80 80" style="width: 50px; height: 50px; opacity: 0.9;" fill="none" stroke="#fff" stroke-width="1.5">
                  <circle cx="40" cy="40" r="35" />
                  <circle cx="40" cy="40" r="20" />
                  <!-- Position markers -->
                  <circle cx="40" cy="12" r="3" fill="#fff"/>
                  <circle cx="62" cy="40" r="3" fill="#26c9a0"/>
                  <circle cx="40" cy="68" r="3" fill="#fff"/>
                  <circle cx="18" cy="40" r="3" fill="#fff"/>
                  <!-- Pointer -->
                  <line x1="40" y1="40" x2="62" y2="40" stroke="#26c9a0" stroke-width="2"/>
                </svg>
                <div class="card-num">D</div>
              </div>
              <div class="card-body">
                <div class="card-name">Thunder Mountain</div>
                <div class="card-meta"><span>11:00 AM • ROTATION D</span></div>
                <div class="card-positions">
                  <span class="pos-chip assigned">M. Torres (Ride Ops)</span>
                  <span class="pos-chip assigned">D. Reyes (Dispatch)</span>
                  <span class="pos-chip assigned">L. Chen (Station)</span>
                </div>
                <div class="card-operator">Next: Rotation E at 12:00 PM</div>
              </div>
            </div>

            <!-- CONCEPT 2: Timeline Progress View -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #2a7a9d, #1a5a6f); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;">
                <div class="card-status-dot"></div>
                <div style="width: 70%; height: 24px; background: rgba(255,255,255,0.1); border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.2); position: relative;">
                  <div style="height: 100%; width: 65%; background: linear-gradient(90deg, #26c9a0, #1a8f7a); transition: width 0.3s;"></div>
                  <div style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); color: #fff; font-size: 10px; font-weight: bold;">65%</div>
                </div>
                <div class="card-num" style="font-size: 16px; opacity: 0.8;">D</div>
              </div>
              <div class="card-body">
                <div class="card-name">Space Coaster</div>
                <div class="card-meta"><span>11:00 AM • Halfway through cycle</span></div>
                <div class="card-positions">
                  <span class="pos-chip assigned">J. Monroe (Lead)</span>
                  <span class="pos-chip assigned">P. Vega (Control)</span>
                  <span class="pos-chip assigned">A. Kim (Queue)</span>
                  <span class="pos-chip assigned">R. Patel (Station)</span>
                </div>
                <div class="card-operator">Started: 11:00 AM • Est. End: 11:45 AM</div>
              </div>
            </div>

            <!-- CONCEPT 3: Position Grid Layout -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #7a2a9d, #5a1a6f); display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 6px; padding: 10px;">
                <div class="card-status-dot"></div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; width: 100%; max-width: 35px;">
                  <div style="width: 14px; height: 14px; border-radius: 2px; background: #26c9a0; border: 1px solid rgba(255,255,255,0.3);"></div>
                  <div style="width: 14px; height: 14px; border-radius: 2px; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);"></div>
                  <div style="width: 14px; height: 14px; border-radius: 2px; background: #26c9a0; border: 1px solid rgba(255,255,255,0.3);"></div>
                  <div style="width: 14px; height: 14px; border-radius: 2px; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);"></div>
                </div>
                <div class="card-num" style="margin-left: 5px;">D</div>
              </div>
              <div class="card-body">
                <div class="card-name">Bumper Cars</div>
                <div class="card-meta"><span>11:00 AM • 2 of 4 Positions</span></div>
                <div class="card-positions">
                  <span class="pos-chip assigned">✓ S. Brown</span>
                  <span class="pos-chip empty">✗ C. Liu</span>
                  <span class="pos-chip assigned">✓ T. Nair</span>
                  <span class="pos-chip empty">✗ K. Wong</span>
                </div>
                <div class="card-operator">Staffing: 50% • 2 of 4 positions filled</div>
              </div>
            </div>

            <!-- CONCEPT 4: Radial Status Indicator -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #9d7a2a, #6f5a1a); display: flex; align-items: center; justify-content: center; position: relative;">
                <div class="card-status-dot"></div>
                <svg viewBox="0 0 80 80" style="width: 50px; height: 50px;" fill="none">
                  <!-- Outer ring progress -->
                  <circle cx="40" cy="40" r="32" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                  <circle cx="40" cy="40" r="32" stroke="#f59e0b" stroke-width="2" 
                          stroke-dasharray="100" stroke-dashoffset="35" stroke-linecap="round"
                          style="transform: rotate(-90deg); transform-origin: 40px 40px;"/>
                  <!-- Center text -->
                  <text x="40" y="35" text-anchor="middle" font-size="14" font-weight="bold" fill="#fff">ROT</text>
                  <text x="40" y="50" text-anchor="middle" font-size="18" font-weight="bold" fill="#f59e0b">D</text>
                </svg>
                <div class="card-num" style="opacity: 0;"></div>
              </div>
              <div class="card-body">
                <div class="card-name">Log Flume</div>
                <div class="card-meta"><span>11:00 AM • ROTATION D Active</span></div>
                <div class="card-positions">
                  <span class="pos-chip assigned">E. Martinez (Load)</span>
                  <span class="pos-chip assigned">F. Jensen (Unload)</span>
                  <span class="pos-chip assigned">G. Wang (Ops)</span>
                </div>
                <div class="card-operator">Full staffing • All positions filled</div>
              </div>
            </div>

            <!-- CONCEPT 5: Position + Station Layout -->
            <div class="attraction-card">
              <div class="card-thumb" style="background: linear-gradient(135deg, #2a6f9d, #1a4f6f); display: flex; align-items: center; justify-content: center; position: relative;">
                <div class="card-status-dot"></div>
                <div style="text-align: center;">
                  <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: bold; letter-spacing: 0.5px;">ROTATION D</div>
                </div>
              </div>
              <div class="card-body">
                <div class="card-name">Pirate Ship</div>
                <div class="card-meta"><span>ROTATION D • 3 of 4 Positions</span></div>
                
                <!-- Position/Station Boxes - Stacked Vertical -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin: 8px 0;">
                  <!-- Station 1 -->
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.2px;">Station 1</div>
                  </div>
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 600; color: var(--teal);">H. Brown</div>
                  </div>

                  <!-- Station 2 -->
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.2px;">Station 2</div>
                  </div>
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 600; color: var(--teal);">J. Kim</div>
                  </div>

                  <!-- Station 3 -->
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.2px;">Station 3</div>
                  </div>
                  <div style="background: var(--teal-glow); border: 1px solid var(--teal); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 600; color: var(--teal);">M. Lee</div>
                  </div>

                  <!-- Station 4 (Empty) -->
                  <div style="background: rgba(192, 57, 43, 0.1); border: 1px solid rgba(192, 57, 43, 0.3); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 700; color: var(--accent-red); text-transform: uppercase; letter-spacing: 0.2px;">Station 4</div>
                  </div>
                  <div style="background: rgba(192, 57, 43, 0.1); border: 1px solid rgba(192, 57, 43, 0.3); border-radius: 2px; padding: 3px 5px; text-align: center;">
                    <div style="font-size: 7px; font-weight: 600; color: var(--accent-red);">EMPTY</div>
                  </div>
                </div>

                <div class="card-operator" style="border-top: 1px solid #ddd; padding-top: 6px; margin-top: 6px;">Next: Rotation E at 12:00 PM</div>
              </div>
            </div>

          </div>
        </div>

        <!-- Section: Top row -->
        <div class="attraction-section">
          <div class="section-label">Active Attractions</div>
          <div class="attraction-row" id="attractionRow">
            <!-- Cards will be generated dynamically from database -->
          </div>
        </div>

        <!-- Section: Break/Offline -->
        <div class="attraction-section">
          <div class="section-label">Break Pool / Offline</div>
          <div class="attraction-row">
            <div class="attraction-card" style="opacity:0.7;">
              <div class="card-thumb" style="background:linear-gradient(135deg,#888,#666);">
                <div class="card-status-dot off"></div>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                <div class="card-num" style="opacity:0.4;">—</div>
              </div>
              <div class="card-body">
                <div class="card-name" style="color:#777;">Break Pool (3)</div>
                <div class="card-meta"><span>On break</span></div>
                <div class="card-positions">
                  <span class="pos-chip">C. Liu</span>
                  <span class="pos-chip">H. Brown</span>
                  <span class="pos-chip">T. Nair</span>
                </div>
                <div class="card-operator">Returns: 10:45</div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- RESIZE HANDLE -->
      <div id="scheduleResizeHandle" style="width: 20px; height: 50px; background: transparent; cursor: ew-resize; flex: 0 0 20px; display: flex; align-items: center; justify-content: center; border-left: 1px solid #ccc; border-right: 1px solid #ccc; z-index: 100; position: relative; user-select: none; pointer-events: auto;">
        <div style="width: 3px; height: 15px; background: #555; border-radius: 2px; box-shadow: 0 -10px 0 #555, 0 10px 0 #555; pointer-events: none;"></div>
      </div>

      <!-- SCHEDULE SIDEBAR -->
      <div class="schedule-bar" id="scheduleBar">
        <div class="schedule-header">Schedule &amp; Timeline</div>
        <div class="schedule-time-display">
          <div class="sched-clock" id="schedClock">10:32 AM</div>
          <div class="sched-label" id="schedLabelText">Current Time · Live</div>
        </div>

        <div class="timeline-wrap">
          <!-- Schedule list -->
          <div class="schedule-list" id="scheduleList">
            <div class="sched-item">
              <div class="sched-item-time">09:00 AM</div>
              <div class="sched-item-desc">Park Open · All positions fill</div>
              <div class="sched-item-badge">Rotation A</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">09:45 AM</div>
              <div class="sched-item-desc">First break wave begins</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">10:00 AM</div>
              <div class="sched-item-desc">Rotation B · Shift swap</div>
              <div class="sched-item-badge">Rotation B</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">10:15 AM</div>
              <div class="sched-item-desc">Break wave 2</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="now-line" id="nowLine"></div>
            <div class="sched-item active">
              <div class="sched-item-time">10:32 AM</div>
              <div class="sched-item-desc">Current · Rotation C active</div>
              <div class="sched-item-badge">Rotation C</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">10:45 AM</div>
              <div class="sched-item-desc">Break wave 3 · 3 operators</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">11:00 AM</div>
              <div class="sched-item-desc">Rotation D · Thunder Mtn +1</div>
              <div class="sched-item-badge">Rotation D</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">11:30 AM</div>
              <div class="sched-item-desc">Lunch wave begins</div>
              <div class="sched-item-badge warn">Lunch</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">12:00 PM</div>
              <div class="sched-item-desc">Peak ops · Rotation E</div>
              <div class="sched-item-badge">Rotation E</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">12:30 PM</div>
              <div class="sched-item-desc">Break wave 4</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">01:00 PM</div>
              <div class="sched-item-desc">Rotation F</div>
              <div class="sched-item-badge">Rotation F</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">01:45 PM</div>
              <div class="sched-item-desc">Maintenance window: Bumper Cars</div>
              <div class="sched-item-badge warn">Maint.</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">02:00 PM</div>
              <div class="sched-item-desc">Rotation G · Full staff</div>
              <div class="sched-item-badge">Rotation G</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">04:00 PM</div>
              <div class="sched-item-desc">Afternoon break wave</div>
              <div class="sched-item-badge warn">Breaks</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">06:00 PM</div>
              <div class="sched-item-desc">Rotation H · Wind-down</div>
              <div class="sched-item-badge">Rotation H</div>
            </div>
            <div class="sched-item">
              <div class="sched-item-time">08:00 PM</div>
              <div class="sched-item-desc">Park Close · Wrap</div>
              <div class="sched-item-badge">Close</div>
            </div>
          </div>

          <!-- Vertical scrubber -->
          <div class="v-scrubber" id="vScrubber" title="Drag to preview time">
            <span class="scrub-top-label">09:00</span>
            <div class="v-scrubber-track" id="scrubTrack">
              <div class="v-scrubber-dot" id="scrubDot"></div>
              <div class="v-scrubber-line" id="scrubLine"></div>
            </div>
            <span class="scrub-bot-label">20:00</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  // Initial debug log
  console.log('[Dashboard] Script loaded - beginning initialization');
  console.log('[Dashboard] About to load zone data');
  
  // Zone configuration
  const ZONE_ID = 1; // Default to Rides 1
  let zoneData = null;

  // Sidebar expand/collapse
  const sidebar = document.querySelector('.sidebar');

  document.getElementById('zones-toggle').addEventListener('click', e => {
    e.preventDefault();
    document.getElementById('zones-sub').classList.toggle('expanded');
  });
  document.querySelectorAll('.zone-item').forEach(item => {
    item.querySelector('.sub-nav-link').addEventListener('click', e => {
      e.preventDefault(); e.stopPropagation();
      item.querySelector('.zone-sub-nav').classList.toggle('expanded');
    });
  });

  // Load zone data from database on page load
  async function loadZoneData() {
    console.log('[loadZoneData] Checking for updates...');
    try {
      const response = await fetch(`../EditMode/api.php?action=getZoneData&zone_id=${ZONE_ID}`);
      const data = await response.json();
      console.log('[loadZoneData] Response received:', data);
      
      if (data.success && data.attractions) {
        // Check if data has changed
        const newDataString = JSON.stringify(data.attractions);
        const oldDataString = JSON.stringify(zoneData);
        
        if (newDataString !== oldDataString) {
          console.log('[loadZoneData] Data changed! Updating dashboard');
          zoneData = data.attractions;
          populateDashboard(zoneData);
        } else {
          console.log('[loadZoneData] No changes detected');
        }
      } else {
        console.warn('No zone data found, using sample data');
      }
    } catch (error) {
      console.error('Error loading zone data:', error);
    }
  }

  // Auto-refresh every 30 seconds
  console.log('[Dashboard] Setting up auto-refresh every 30 seconds');
  setInterval(loadZoneData, 30000);

  // Populate dashboard with real data from database
  function populateDashboard(attractions) {
    const attractionRow = document.getElementById('attractionRow');
    
    // Clear ALL existing cards completely
    attractionRow.innerHTML = '';

    // Create cards from database data
    attractions.forEach((attraction, index) => {
      if (!attraction.isPlaced) return; // Skip attractions not placed on canvas
      
      const card = document.createElement('div');
      card.className = 'attraction-card';
      
      const positionsHTML = attraction.positions.map(pos => {
        const bgClass = pos.operator ? 'teal' : 'red';
        const textColor = pos.operator ? 'var(--teal)' : 'var(--accent-red)';
        const bgColor = pos.operator ? 'var(--teal-glow)' : 'rgba(192, 57, 43, 0.1)';
        const borderColor = pos.operator ? 'var(--teal)' : 'rgba(192, 57, 43, 0.3)';
        const operatorText = pos.operator ? pos.operator : 'EMPTY';
        return `
          <div style="background: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 2px; padding: 3px 5px; text-align: center;">
            <div style="font-size: 7px; font-weight: 700; color: ${textColor}; text-transform: uppercase; letter-spacing: 0.2px;">${pos.name}</div>
          </div>
          <div style="background: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 2px; padding: 3px 5px; text-align: center;">
            <div style="font-size: 7px; font-weight: 600; color: ${textColor};">${operatorText}</div>
          </div>
        `;
      }).join('');

      const leadOperator = attraction.positions.find(p => p.name.toLowerCase().includes('control') || p.name.toLowerCase().includes('lead'));
      const leadName = leadOperator?.operator || '—';
      const posCount = attraction.positions.length;

      card.innerHTML = `
        <div class="card-thumb">
          <div class="card-status-dot"></div>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2z"/><path d="M12 8v8M8 12h8"/></svg>
          <div class="card-num">${index + 1}</div>
        </div>
        <div class="card-body">
          <div class="card-name">${attraction.name}</div>
          <div class="card-meta"><span>${posCount} positions</span><span>Tier 1</span></div>
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin: 8px 0;">
            ${positionsHTML}
          </div>
          <div class="card-operator">Lead: ${leadName}</div>
          <div class="rotation-change-preview">
            <div class="rotation-label">
              <span class="rotation-time-badge">11:00 AM</span>
              <span class="rotation-text">Rotation D</span>
            </div>
            <div class="rotation-staff">
              ${attraction.positions.map(pos => `<div class="staff-item">${pos.name}: ${pos.operator || 'TBD'}</div>`).join('')}
            </div>
          </div>
        </div>
      `;
      
      attractionRow.appendChild(card);
    });
  }

  // Load data when page loads
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadZoneData);
  } else {
    loadZoneData();
  }

  // Live clock
  function padZ(n) { return String(n).padStart(2,'0'); }
  function formatTime(d) {
    let h = d.getHours(), m = d.getMinutes();
    const ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12 || 12;
    return `${padZ(h)}:${padZ(m)} ${ampm}`;
  }

  let isPreview = false;
  let previewMinutes = 0; // offset from midnight

  function minutesFromMidnight(d) {
    return d.getHours() * 60 + d.getMinutes();
  }

  const DAY_START = 9 * 60;  // 09:00
  const DAY_END   = 20 * 60; // 20:00
  const DAY_SPAN  = DAY_END - DAY_START;

  function minutesToTimeStr(mins) {
    mins = Math.max(DAY_START, Math.min(DAY_END, mins));
    const h = Math.floor(mins / 60);
    const m = mins % 60;
    const ampm = h >= 12 ? 'PM' : 'AM';
    const h12 = h % 12 || 12;
    return `${padZ(h12)}:${padZ(m)} ${ampm}`;
  }

  function updateDisplay(mins) {
    const timeStr = minutesToTimeStr(mins);
    document.getElementById('timeNow').innerHTML =
      `${timeStr} <span id="timeNote">${isPreview ? 'PREVIEW' : 'LIVE'}</span>`;
    document.getElementById('schedClock').textContent = timeStr;
    document.getElementById('schedLabelText').textContent =
      isPreview ? 'Preview Time · Scrubbing' : 'Current Time · Live';
    document.getElementById('previewTag').classList.toggle('visible', isPreview);
    document.getElementById('modeBadge').textContent = isPreview ? 'Preview' : 'Live';
    document.getElementById('modeBadge').style.background = isPreview ? '#888' : 'var(--teal)';
  }

  function tick() {
    if (!isPreview) {
      const now = new Date();
      const mins = minutesFromMidnight(now);
      updateDisplay(mins);
      // Set scrubber position
      const pct = Math.max(0, Math.min(1, (mins - DAY_START) / DAY_SPAN));
      setScrubberPct(pct);
    }
  }

  setInterval(tick, 10000);
  tick();

  // Rotation countdown
  let countdownSecs = 764;
  setInterval(() => {
    countdownSecs--;
    if (countdownSecs < 0) countdownSecs = 900;
    const m = Math.floor(countdownSecs / 60);
    const s = countdownSecs % 60;
    const timeStr = `${padZ(m)}:${padZ(s)}`;
    document.getElementById('rotCountdown').textContent = timeStr;
  }, 1000);

  // Preview mode toggle button
  function togglePreviewMode() {
    isPreview = !isPreview;
    if (!isPreview) {
      tick();
    }
  }

  // Scrubber drag
  const scrubTrack = document.getElementById('scrubTrack');
  const scrubDot   = document.getElementById('scrubDot');
  const scrubLine  = document.getElementById('scrubLine');

  let dragging = false;

  function setScrubberPct(pct) {
    if (!scrubTrack) return; // Safety check
    pct = Math.max(0, Math.min(1, pct));
    const trackH = scrubTrack.clientHeight;
    const dotH = 14;
    const offset = pct * (trackH - dotH);
    scrubDot.style.top = offset + 'px';
    scrubLine.style.top = (offset + dotH / 2) + 'px';
    // Sync schedule list scroll
    const list = document.getElementById('scheduleList');
    list.scrollTop = pct * (list.scrollHeight - list.clientHeight);
  }

  function pctFromEvent(e) {
    if (!scrubTrack) return 0; // Safety check
    const rect = scrubTrack.getBoundingClientRect();
    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
    return (clientY - rect.top) / rect.height;
  }

  // Setup scrubber controls only if elements exist
  if (scrubDot) {
    scrubDot.addEventListener('mousedown', e => { dragging = true; e.preventDefault(); });
    document.addEventListener('mousemove', e => {
      if (!dragging) return;
      const pct = pctFromEvent(e);
      isPreview = true;
      const mins = DAY_START + pct * DAY_SPAN;
      previewMinutes = mins;
      updateDisplay(mins);
      setScrubberPct(pct);
    });
    document.addEventListener('mouseup', () => { dragging = false; });

    scrubDot.addEventListener('touchstart', e => { dragging = true; }, { passive: true });
    document.addEventListener('touchmove', e => {
      if (!dragging) return;
      const pct = pctFromEvent(e);
      isPreview = true;
      const mins = DAY_START + pct * DAY_SPAN;
      updateDisplay(mins);
      setScrubberPct(pct);
    }, { passive: true });
    document.addEventListener('touchend', () => { dragging = false; });
  }

  // Click on schedule items
  console.log('[Dashboard] About to set up schedule item clicks');
  document.querySelectorAll('.sched-item').forEach(item => {
    item.addEventListener('click', () => {
      document.querySelectorAll('.sched-item').forEach(i => i.classList.remove('active'));
      item.classList.add('active');
    });
  });
  console.log('[Dashboard] Schedule clicks done - NOW STARTING RESIZE SETUP');
  console.log('[Resize] TEST 1');
  alert('TEST ALERT - Resize code section reached!');

  // ===== RESIZE HANDLE SETUP =====
  console.log('[Resize] Resize code loaded');
  console.log('[Resize] Looking for elements...');
  
  const resizeHandle = document.getElementById('scheduleResizeHandle');
  const scheduleBar = document.getElementById('scheduleBar');
  
  console.log('[Resize] Handle element found:', !!resizeHandle);
  console.log('[Resize] Bar element found:', !!scheduleBar);
  
  if (!resizeHandle) {
    console.error('[Resize] ERROR - scheduleResizeHandle NOT FOUND!');
  }
  if (!scheduleBar) {
    console.error('[Resize] ERROR - scheduleBar NOT FOUND!');
  }
  
  if (resizeHandle && scheduleBar) {
    console.log('[Resize] *** Both elements found! Attaching event listeners...');
    
    let isResizing = false;
    let startX = 0;
    let startWidth = 0;
    
    resizeHandle.onmousedown = function(e) {
      console.log('[Resize] *** MOUSEDOWN FIRED - X:', e.clientX);
      if (e.button !== 0) return;
      
      isResizing = true;
      startX = e.clientX;
      startWidth = scheduleBar.offsetWidth;
      
      console.log('[Resize] READY TO DRAG - width:', startWidth);
      document.body.style.userSelect = 'none';
      document.body.style.cursor = 'ew-resize';
      e.preventDefault();
    };
    
    document.onmousemove = function(e) {
      if (!isResizing) return;
      
      const diff = startX - e.clientX;
      const newWidth = Math.max(150, Math.min(600, startWidth + diff));
      
      console.log('[Resize] DRAGGING - diff:', diff, 'new:', newWidth);
      scheduleBar.style.width = newWidth + 'px';
      scheduleBar.style.flex = '0 0 ' + newWidth + 'px';
    };
    
    document.onmouseup = function(e) {
      if (isResizing) {
        console.log('[Resize] MOUSEUP - Done');
        isResizing = false;
        document.body.style.userSelect = '';
        document.body.style.cursor = '';
      }
    };
    
    console.log('[Resize] Event listeners attached!');
  }

</script>
</body>
</html>