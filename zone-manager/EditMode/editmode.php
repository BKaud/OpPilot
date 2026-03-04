<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>OPilot – Edit Mode</title>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="../assets/css/theme.css" />
</head>
<body>
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
  <aside class="sidebar">
    <div class="nav-section">
      <div class="nav-upper">
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12L12 3l9 9"/><path d="M9 21V12h6v9"/></svg></div>
            <span class="nav-text">Homepage</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link" id="zones-toggle">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg></div>
            <span class="nav-text">Zones</span>
          </a>
          <div class="sub-nav expanded" id="zones-sub">
            <div class="zone-item" id="rides1-zone">
              <a href="#" class="sub-nav-link" id="r1-toggle">Rides 1</a>
              <div class="zone-sub-nav expanded">
                <a href="#" class="zone-sub-link">Dashboard</a>
                <a href="#" class="zone-sub-link active">Edit Mode</a>
                <a href="#" class="zone-sub-link">Config</a>
                <a href="#" class="zone-sub-link">Settings</a>
              </div>
            </div>
            <div class="zone-item" id="rides2-zone">
              <a href="#" class="sub-nav-link" id="r2-toggle">Rides 2</a>
              <div class="zone-sub-nav expanded">
                <a href="#" class="zone-sub-link">Dashboard</a>
                <a href="#" class="zone-sub-link">Edit Mode</a>
                <a href="#" class="zone-sub-link">Config</a>
                <a href="#" class="zone-sub-link">Settings</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-lower">
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
            <span class="nav-text">Account Settings</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
            <span class="nav-text">Changelog</span>
          </a>
        </div>
      </div>
    </div>
  </aside>

  <div class="content">
    <div class="page-header">
      <div>
        <h1>Edit Mode</h1>
        <div class="breadcrumb">Zones › Rides 1 › <span>Edit Mode</span></div>
      </div>
      <div class="header-controls">
        <span class="mode-badge">Edit Mode</span>
        <button class="btn btn-gray btn-sm" onclick="clearSel()">Deselect</button>
        <button class="btn btn-danger btn-sm">Discard</button>
        <button class="btn btn-teal btn-sm">Save Layout</button>
      </div>
    </div>

    <div class="edit-body">
      <div class="canvas-col">

        <div class="edit-toolbar">
          <button class="tool-btn active" id="toolSelect" onclick="setTool('select')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3l14 9-7 1-4 7z"/></svg>Select
          </button>
          <button class="tool-btn" id="toolConnect" onclick="setTool('connect')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="14,7 19,12 14,17"/></svg>Connect
          </button>
          <div class="toolbar-sep"></div>
          <button class="tool-btn" onclick="autoLayout()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3,6 9,6 9,3 15,9 9,15 9,12 3,12"/></svg>Auto-Layout
          </button>
          <button class="tool-btn" onclick="clearArrows()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Clear Connections
          </button>
          <button class="tool-btn" onclick="addNode()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Add Node
          </button>
          <div class="toolbar-right">
            <label class="snap-toggle"><input type="checkbox" id="snapToggle" checked />Snap</label>
            <div class="toolbar-sep"></div>
            <span class="node-counter">NODES: <span id="nodeCount">0</span></span>
          </div>
        </div>

        <div class="canvas-wrap" id="canvasWrap">
          <svg id="arrowSvg" style="width:1300px;height:530px;"></svg>
          <div id="ci" style="position:absolute;top:0;left:0;width:1300px;height:530px;">

            <!-- Zone A group -->
            <div class="rot-zone" id="zoneA" style="left:16px;top:12px;width:710px;height:206px;">
              <div class="rot-zone-label">Rotation Zone A · Tidal Twist</div>
            </div>
            <!-- Zone B group -->
            <div class="rot-zone" id="zoneB" style="left:16px;top:244px;width:710px;height:200px;">
              <div class="rot-zone-label">Rotation Zone B · Thunder Mtn</div>
            </div>

            <!-- Zone A nodes: linear chain left→right -->
            <div class="pos-node" id="n1" style="left:42px;top:76px;" data-ride="Tidal Twist" data-pos="Station 1" data-op="M. Torres" data-status="Operational">
              <div class="node-dot"></div>
              <div class="pos-node-name">Station 1</div>
              <div class="pos-node-ride">Tidal Twist</div>
              <div class="pos-node-op">M. Torres</div>
              <div class="port port-r" data-id="n1"></div>
            </div>
            <div class="pos-node" id="n2" style="left:182px;top:76px;" data-ride="Tidal Twist" data-pos="Station 2" data-op="D. Reyes" data-status="Operational">
              <div class="node-dot"></div>
              <div class="pos-node-name">Station 2</div>
              <div class="pos-node-ride">Tidal Twist</div>
              <div class="pos-node-op">D. Reyes</div>
              <div class="port port-l" data-id="n2"></div>
              <div class="port port-r" data-id="n2"></div>
            </div>
            <div class="pos-node" id="n3" style="left:322px;top:76px;" data-ride="Tidal Twist" data-pos="Load Platform" data-op="A. Kim" data-status="Break">
              <div class="node-dot warn"></div>
              <div class="pos-node-name">Load Platform</div>
              <div class="pos-node-ride">Tidal Twist</div>
              <div class="pos-node-op" style="color:var(--accent-yellow)">A. Kim</div>
              <div class="port port-l" data-id="n3"></div>
              <div class="port port-r" data-id="n3"></div>
            </div>
            <div class="pos-node" id="n4" style="left:462px;top:76px;" data-ride="Tidal Twist" data-pos="Unload Plt" data-op="P. Vega" data-status="Operational">
              <div class="node-dot"></div>
              <div class="pos-node-name">Unload Plt</div>
              <div class="pos-node-ride">Tidal Twist</div>
              <div class="pos-node-op">P. Vega</div>
              <div class="port port-l" data-id="n4"></div>
              <div class="port port-r" data-id="n4"></div>
            </div>
            <div class="pos-node" id="n5" style="left:602px;top:76px;" data-ride="Tidal Twist" data-pos="Control Booth" data-op="S. Okoro" data-status="Operational">
              <div class="node-dot"></div>
              <div class="pos-node-name">Control Booth</div>
              <div class="pos-node-ride">Tidal Twist</div>
              <div class="pos-node-op">S. Okoro</div>
              <div class="port port-l" data-id="n5"></div>
              <div class="port port-b" data-id="n5"></div>
            </div>

            <!-- Zone B nodes: right→left return path -->
            <div class="pos-node" id="n6" style="left:42px;top:300px;" data-ride="Thunder Mtn" data-pos="Station 1" data-op="J. Marsh" data-status="Operational">
              <div class="node-dot"></div>
              <div class="pos-node-name">Station 1</div>
              <div class="pos-node-ride">Thunder Mtn</div>
              <div class="pos-node-op">J. Marsh</div>
              <div class="port port-t" data-id="n6"></div>
              <div class="port port-r" data-id="n6"></div>
            </div>
            <div class="pos-node" id="n7" style="left:182px;top:300px;" data-ride="Thunder Mtn" data-pos="Station 2" data-op="" data-status="Unassigned">
              <div class="node-dot empty"></div>
              <div class="pos-node-name">Station 2</div>
              <div class="pos-node-ride">Thunder Mtn</div>
              <div class="pos-node-op" style="color:var(--accent-red)">Unassigned</div>
              <div class="port port-l" data-id="n7"></div>
              <div class="port port-r" data-id="n7"></div>
            </div>
            <div class="pos-node" id="n8" style="left:322px;top:300px;" data-ride="Thunder Mtn" data-pos="Dispatch" data-op="C. Liu" data-status="Break">
              <div class="node-dot warn"></div>
              <div class="pos-node-name">Dispatch</div>
              <div class="pos-node-ride">Thunder Mtn</div>
              <div class="pos-node-op" style="color:var(--accent-yellow)">C. Liu</div>
              <div class="port port-l" data-id="n8"></div>
              <div class="port port-r" data-id="n8"></div>
            </div>
            <div class="pos-node" id="n9" style="left:462px;top:300px;" data-ride="Thunder Mtn" data-pos="Control" data-op="H. Brown" data-status="Operational">
              <div class="node-dot"></div>
              <div class="pos-node-name">Control</div>
              <div class="pos-node-ride">Thunder Mtn</div>
              <div class="pos-node-op">H. Brown</div>
              <div class="port port-l" data-id="n9"></div>
              <div class="port port-r" data-id="n9"></div>
            </div>
            <div class="pos-node" id="n10" style="left:602px;top:300px;" data-ride="Thunder Mtn" data-pos="Break Relief" data-op="T. Nair" data-status="Break">
              <div class="node-dot warn"></div>
              <div class="pos-node-name">Break Relief</div>
              <div class="pos-node-ride">Thunder Mtn</div>
              <div class="pos-node-op" style="color:var(--accent-yellow)">T. Nair</div>
              <div class="port port-l" data-id="n10"></div>
            </div>

            <!-- Standalone nodes right side -->
            <div class="pos-node" id="n11" style="left:800px;top:44px;" data-ride="Space Coaster" data-pos="Load" data-op="B. Okafor" data-status="Operational">
              <div class="node-dot"></div>
              <div class="pos-node-name">Load</div>
              <div class="pos-node-ride">Space Coaster</div>
              <div class="pos-node-op">B. Okafor</div>
              <div class="port port-b" data-id="n11"></div>
              <div class="port port-r" data-id="n11"></div>
            </div>
            <div class="pos-node" id="n12" style="left:800px;top:158px;" data-ride="Space Coaster" data-pos="Control" data-op="" data-status="Unassigned">
              <div class="node-dot empty"></div>
              <div class="pos-node-name">Control</div>
              <div class="pos-node-ride">Space Coaster</div>
              <div class="pos-node-op" style="color:var(--accent-red)">Unassigned</div>
              <div class="port port-t" data-id="n12"></div>
              <div class="port port-b" data-id="n12"></div>
            </div>
            <div class="pos-node" id="n13" style="left:800px;top:286px;" data-ride="Bumper Cars" data-pos="Floor" data-op="" data-status="Unassigned">
              <div class="node-dot empty"></div>
              <div class="pos-node-name">Floor</div>
              <div class="pos-node-ride">Bumper Cars</div>
              <div class="pos-node-op" style="color:var(--accent-red)">Unassigned</div>
              <div class="port port-t" data-id="n13"></div>
              <div class="port port-r" data-id="n13"></div>
            </div>
            <div class="pos-node" id="n14" style="left:940px;top:286px;" data-ride="Bumper Cars" data-pos="Control" data-op="" data-status="Unassigned">
              <div class="node-dot empty"></div>
              <div class="pos-node-name">Control</div>
              <div class="pos-node-ride">Bumper Cars</div>
              <div class="pos-node-op" style="color:var(--accent-red)">Unassigned</div>
              <div class="port port-l" data-id="n14"></div>
            </div>

          </div>
        </div>

        <!-- BOTTOM TRAY -->
        <div class="bottom-tray">
          <div class="tray-section" style="width:330px;">
            <div class="tray-header">Attractions <button class="tray-btn">+ Add to Canvas</button></div>
            <div class="tray-scroll">
              <div class="attr-thumb placed"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2z"/><path d="M12 8v8M8 12h8"/></svg><div class="tnum">1</div><div class="attr-thumb-label">Tidal Twist</div></div>
              <div class="attr-thumb placed"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg><div class="tnum">2</div><div class="attr-thumb-label">Thunder Mtn</div></div>
              <div class="attr-thumb placed"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 17l5-10 4 6 3-4 6 8"/></svg><div class="tnum">3</div><div class="attr-thumb-label">Space Coaster</div></div>
              <div class="attr-thumb placed"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="9" width="20" height="8" rx="2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg><div class="tnum">4</div><div class="attr-thumb-label">Bumper Cars</div></div>
              <div class="attr-thumb"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg><div class="tnum">5</div><div class="attr-thumb-label">Carousel</div></div>
              <div class="attr-thumb"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="2" x2="12" y2="22"/><polyline points="7,17 12,22 17,17"/></svg><div class="tnum">6</div><div class="attr-thumb-label">Drop Tower</div></div>
            </div>
          </div>
          <div class="tray-section">
            <div class="tray-header">Unassigned Operators <button class="tray-btn">Manage</button></div>
            <div class="tray-scroll">
              <div class="op-chip"><div class="op-chip-name">L. Santos</div><div class="op-chip-tier">Tier 1</div></div>
              <div class="op-chip"><div class="op-chip-name">R. Patel</div><div class="op-chip-tier">Tier 2</div></div>
              <div class="op-chip"><div class="op-chip-name">K. Nguyen</div><div class="op-chip-tier">Lead</div></div>
              <div class="op-chip"><div class="op-chip-name">F. Jensen</div><div class="op-chip-tier">Tier 1</div></div>
              <div class="op-chip"><div class="op-chip-name">W. Diaz</div><div class="op-chip-tier">Tier 3</div></div>
              <div class="op-chip"><div class="op-chip-name">N. Abebe</div><div class="op-chip-tier">Tier 2</div></div>
              <div class="op-chip"><div class="op-chip-name">O. Ferreira</div><div class="op-chip-tier">Tier 1</div></div>
            </div>
          </div>
        </div>

      </div><!-- /canvas-col -->

      <!-- PROPERTIES PANEL -->
      <div class="props-panel">
        <div class="props-header">Properties</div>
        <div class="props-empty" id="propsEmpty">
          <div class="props-empty-msg">Select a node on the canvas to edit its properties.</div>
        </div>
        <div class="props-body" id="propsBody" style="display:none;">
          <div class="prop-group">
            <div class="prop-group-title">Node Info</div>
            <div class="prop-row"><span class="prop-label">Name</span><input class="prop-input" id="pName" type="text" /></div>
            <div class="prop-row"><span class="prop-label">Ride</span>
              <select class="prop-select" id="pRide">
                <option>Tidal Twist</option><option>Thunder Mtn</option>
                <option>Space Coaster</option><option>Bumper Cars</option>
                <option>Carousel</option><option>Drop Tower</option>
              </select>
            </div>
            <div class="prop-row"><span class="prop-label">Status</span>
              <select class="prop-select" id="pStatus">
                <option>Operational</option><option>Break</option><option>Unassigned</option><option>Maintenance</option>
              </select>
            </div>
          </div>
          <div class="prop-group">
            <div class="prop-group-title">Position (px)</div>
            <div class="prop-xy">
              <div><span>X</span><input class="prop-input" id="pX" type="number" min="0" /></div>
              <div><span>Y</span><input class="prop-input" id="pY" type="number" min="0" /></div>
            </div>
          </div>
          <div class="prop-group">
            <div class="prop-group-title">Operator</div>
            <div class="prop-row">
              <select class="prop-select" id="pOp" style="width:100%">
                <option value="">— Unassigned —</option>
                <option>M. Torres</option><option>D. Reyes</option><option>A. Kim</option>
                <option>P. Vega</option><option>S. Okoro</option><option>J. Marsh</option>
                <option>C. Liu</option><option>H. Brown</option><option>T. Nair</option>
                <option>B. Okafor</option><option>L. Santos</option><option>R. Patel</option>
                <option>K. Nguyen</option><option>F. Jensen</option><option>W. Diaz</option>
              </select>
            </div>
          </div>
          <hr class="prop-divider" />
          <div class="prop-btn-row">
            <button class="prop-btn pbtn-dup" onclick="dupNode()">Duplicate</button>
            <button class="prop-btn pbtn-del" onclick="deleteNode()">Delete</button>
          </div>
        </div>
      </div>

    </div><!-- /edit-body -->
  </div><!-- /content -->
</div><!-- /main -->

<script>
// Sidebar toggles
document.getElementById('zones-toggle').addEventListener('click', e => { e.preventDefault(); document.getElementById('zones-sub').classList.toggle('expanded'); });
['r1-toggle','r2-toggle'].forEach(id => {
  document.getElementById(id).addEventListener('click', e => { e.preventDefault(); e.stopPropagation(); e.currentTarget.nextElementSibling.classList.toggle('expanded'); });
});

// Tool state
let tool = 'select';
function setTool(t) {
  tool = t;
  document.querySelectorAll('.tool-btn[id^="tool"]').forEach(b => b.classList.remove('active'));
  document.getElementById('tool' + t[0].toUpperCase() + t.slice(1)).classList.add('active');
  document.getElementById('canvasWrap').style.cursor = t === 'connect' ? 'crosshair' : 'default';
}

// Arrow connections
let connections = [
  ['n1','n2'],['n2','n3'],['n3','n4'],['n4','n5'],
  ['n5','n6'],
  ['n6','n7'],['n7','n8'],['n8','n9'],['n9','n10'],
  ['n11','n12'],['n12','n11'],
  ['n13','n14']
];
let connectSrc = null;

// Draw arrows
function drawArrows() {
  const svg = document.getElementById('arrowSvg');
  const W = parseInt(svg.style.width), H = parseInt(svg.style.height);
  const tealChain = new Set(['n1-n2','n2-n3','n3-n4','n4-n5','n5-n6','n6-n7','n7-n8','n8-n9','n9-n10']);

  let html = `<defs>
    <marker id="mGray" markerWidth="7" markerHeight="7" refX="5.5" refY="3.5" orient="auto"><polygon points="0 0,7 3.5,0 7" fill="#999"/></marker>
    <marker id="mTeal" markerWidth="7" markerHeight="7" refX="5.5" refY="3.5" orient="auto"><polygon points="0 0,7 3.5,0 7" fill="#1a8f7a"/></marker>
  </defs>`;

  connections.forEach(([a, b]) => {
    const na = document.getElementById(a), nb = document.getElementById(b);
    if (!na || !nb) return;
    const ax = parseInt(na.style.left) + na.offsetWidth/2;
    const ay = parseInt(na.style.top)  + na.offsetHeight/2;
    const bx = parseInt(nb.style.left) + nb.offsetWidth/2;
    const by = parseInt(nb.style.top)  + nb.offsetHeight/2;
    const isTeal = tealChain.has(a+'-'+b);
    const dx = bx-ax, dy = by-ay;
    const cpx = dx*0.46, cpy = dy*0.46;
    html += `<path d="M${ax},${ay} C${ax+cpx},${ay} ${bx-cpx},${by} ${bx},${by}" fill="none" stroke="${isTeal?'#1a8f7a':'#999'}" stroke-width="${isTeal?'1.8':'1.5'}" opacity="${isTeal?'0.6':'0.4'}" marker-end="url(#${isTeal?'mTeal':'mGray'})"/>`;
  });

  // Preview line while connecting
  if (connectSrc && previewPos) {
    const na = document.getElementById(connectSrc);
    if (na) {
      const ax = parseInt(na.style.left)+na.offsetWidth/2, ay = parseInt(na.style.top)+na.offsetHeight/2;
      html += `<line x1="${ax}" y1="${ay}" x2="${previewPos.x}" y2="${previewPos.y}" stroke="var(--teal)" stroke-width="1.5" stroke-dasharray="5,3" opacity="0.7"/>`;
    }
  }
  svg.innerHTML = html;
}

let previewPos = null;

// Drag nodes
let dragNode = null, dragOX = 0, dragOY = 0;
const SNAP = 14;

function attachNode(node) {
  node.addEventListener('mousedown', e => {
    if (e.target.classList.contains('port')) return;
    if (tool === 'connect') return;
    e.preventDefault(); e.stopPropagation();
    selectNode(node);
    dragNode = node;
    const cw = document.getElementById('canvasWrap');
    const rect = node.getBoundingClientRect();
    dragOX = e.clientX - rect.left;
    dragOY = e.clientY - rect.top;
    node.classList.add('dragging');
  });

  node.querySelectorAll('.port').forEach(port => {
    port.addEventListener('mousedown', e => {
      if (tool !== 'connect') return;
      e.stopPropagation(); e.preventDefault();
      connectSrc = node.id;
    });
    port.addEventListener('mouseup', e => {
      if (tool !== 'connect' || !connectSrc || connectSrc === node.id) return;
      e.stopPropagation();
      const key = connectSrc + '-' + node.id;
      if (!connections.find(([a,b]) => a===connectSrc && b===node.id)) connections.push([connectSrc, node.id]);
      connectSrc = null; previewPos = null; drawArrows();
    });
  });
}

document.querySelectorAll('.pos-node').forEach(attachNode);

const cw = document.getElementById('canvasWrap');
document.addEventListener('mousemove', e => {
  if (dragNode) {
    const cr = cw.getBoundingClientRect();
    let x = e.clientX - cr.left + cw.scrollLeft - dragOX;
    let y = e.clientY - cr.top  + cw.scrollTop  - dragOY;
    if (document.getElementById('snapToggle').checked) { x = Math.round(x/SNAP)*SNAP; y = Math.round(y/SNAP)*SNAP; }
    x = Math.max(0,x); y = Math.max(0,y);
    dragNode.style.left = x+'px'; dragNode.style.top = y+'px';
    if (selNode === dragNode) { document.getElementById('pX').value=x; document.getElementById('pY').value=y; }
    drawArrows();
  }
  if (connectSrc) {
    const cr = cw.getBoundingClientRect();
    previewPos = { x: e.clientX - cr.left + cw.scrollLeft, y: e.clientY - cr.top + cw.scrollTop };
    drawArrows();
  }
});
document.addEventListener('mouseup', () => {
  if (dragNode) { dragNode.classList.remove('dragging'); dragNode = null; }
  if (connectSrc) { connectSrc = null; previewPos = null; drawArrows(); }
});

// Selection
let selNode = null;
function selectNode(node) {
  if (selNode) selNode.classList.remove('selected');
  selNode = node; node.classList.add('selected');
  document.getElementById('pName').value   = node.dataset.pos||'';
  document.getElementById('pX').value     = parseInt(node.style.left)||0;
  document.getElementById('pY').value     = parseInt(node.style.top)||0;
  const rs = document.getElementById('pRide');
  for (let i=0;i<rs.options.length;i++) if(rs.options[i].text===node.dataset.ride){rs.selectedIndex=i;break;}
  const ss = document.getElementById('pStatus');
  for (let i=0;i<ss.options.length;i++) if(ss.options[i].text===node.dataset.status){ss.selectedIndex=i;break;}
  const os = document.getElementById('pOp');
  const op = node.dataset.op||'';
  for (let i=0;i<os.options.length;i++) if(os.options[i].text===op){os.selectedIndex=i;break;}
  document.getElementById('propsEmpty').style.display='none';
  document.getElementById('propsBody').style.display='block';
}
function clearSel() {
  if (selNode) { selNode.classList.remove('selected'); selNode=null; }
  document.getElementById('propsEmpty').style.display='flex';
  document.getElementById('propsBody').style.display='none';
}

document.getElementById('ci').addEventListener('mousedown', e => {
  if (e.target === e.currentTarget || e.target.classList.contains('rot-zone') || e.target.classList.contains('rot-zone-label')) clearSel();
});

// Prop live bindings
document.getElementById('pName').addEventListener('input', e => { if(!selNode)return; selNode.querySelector('.pos-node-name').textContent=e.target.value; selNode.dataset.pos=e.target.value; });
document.getElementById('pRide').addEventListener('change', e => { if(!selNode)return; selNode.querySelector('.pos-node-ride').textContent=e.target.value; selNode.dataset.ride=e.target.value; });
document.getElementById('pX').addEventListener('input', e => { if(!selNode)return; selNode.style.left=Math.max(0,parseInt(e.target.value)||0)+'px'; drawArrows(); });
document.getElementById('pY').addEventListener('input', e => { if(!selNode)return; selNode.style.top=Math.max(0,parseInt(e.target.value)||0)+'px'; drawArrows(); });
document.getElementById('pOp').addEventListener('change', e => {
  if(!selNode)return;
  const opEl = selNode.querySelector('.pos-node-op');
  opEl.textContent = e.target.value || '—';
  opEl.style.color = e.target.value ? 'var(--teal)' : 'var(--accent-red)';
  selNode.dataset.op = e.target.value;
});
document.getElementById('pStatus').addEventListener('change', e => {
  if(!selNode)return;
  selNode.dataset.status=e.target.value;
  const dot=selNode.querySelector('.node-dot');
  dot.className='node-dot'+({Break:' warn',Unassigned:' empty',Maintenance:' empty'}[e.target.value]||'');
});

// Node management
let nodeCounter = 14;
function addNode() {
  nodeCounter++;
  const id = 'n'+nodeCounter;
  const div = document.createElement('div');
  div.className='pos-node'; div.id=id;
  div.style.left='100px'; div.style.top='80px';
  div.dataset.ride='Tidal Twist'; div.dataset.pos='New Position'; div.dataset.op=''; div.dataset.status='Unassigned';
  div.innerHTML=`<div class="node-dot empty"></div><div class="pos-node-name">New Position</div><div class="pos-node-ride">Tidal Twist</div><div class="pos-node-op" style="color:var(--accent-red)">Unassigned</div><div class="port port-r" data-id="${id}"></div><div class="port port-l" data-id="${id}"></div>`;
  document.getElementById('ci').appendChild(div);
  attachNode(div); selectNode(div);
  document.getElementById('nodeCount').textContent = document.querySelectorAll('.pos-node').length;
}
function dupNode() {
  if(!selNode)return;
  nodeCounter++;
  const id='n'+nodeCounter;
  const c=selNode.cloneNode(true);
  c.id=id; c.style.left=(parseInt(selNode.style.left)+28)+'px'; c.style.top=(parseInt(selNode.style.top)+28)+'px';
  c.classList.remove('selected','dragging');
  c.querySelectorAll('.port').forEach(p=>p.dataset.id=id);
  document.getElementById('ci').appendChild(c);
  attachNode(c); selectNode(c);
  document.getElementById('nodeCount').textContent = document.querySelectorAll('.pos-node').length;
}
function deleteNode() {
  if(!selNode)return;
  const id=selNode.id;
  connections=connections.filter(([a,b])=>a!==id&&b!==id);
  selNode.remove(); selNode=null; drawArrows();
  document.getElementById('propsEmpty').style.display='flex';
  document.getElementById('propsBody').style.display='none';
  document.getElementById('nodeCount').textContent = document.querySelectorAll('.pos-node').length;
}
function autoLayout() {
  const nodes=[...document.querySelectorAll('.pos-node')];
  const cols=5, gx=140, gy=110, sx=42, sy=70;
  nodes.forEach((n,i)=>{ n.style.left=(sx+(i%cols)*gx)+'px'; n.style.top=(sy+Math.floor(i/cols)*gy)+'px'; });
  if(selNode){document.getElementById('pX').value=parseInt(selNode.style.left);document.getElementById('pY').value=parseInt(selNode.style.top);}
  drawArrows();
}
function clearArrows() { connections=[]; drawArrows(); }

// Zone drag
let dragZone=null, dzOX=0, dzOY=0;
document.querySelectorAll('.rot-zone').forEach(z=>{
  z.addEventListener('mousedown',e=>{
    if(e.target===z||e.target.classList.contains('rot-zone-label')){
      dragZone=z; const r=z.getBoundingClientRect(); const cr=cw.getBoundingClientRect();
      dzOX=e.clientX-r.left; dzOY=e.clientY-r.top; e.preventDefault();
    }
  });
});
document.addEventListener('mousemove',e=>{
  if(!dragZone)return;
  const cr=cw.getBoundingClientRect();
  dragZone.style.left=Math.max(0,e.clientX-cr.left+cw.scrollLeft-dzOX)+'px';
  dragZone.style.top=Math.max(0,e.clientY-cr.top+cw.scrollTop-dzOY)+'px';
});
document.addEventListener('mouseup',()=>{ dragZone=null; });

drawArrows();
document.getElementById('nodeCount').textContent = document.querySelectorAll('.pos-node').length;
</script>
</body>
</html>