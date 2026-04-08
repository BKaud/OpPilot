
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>OPilot – Zone Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../assets/css/theme.css" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once APP_ROOT . '/partials/sidebar.php';
?>

  <div class="content">
    <div class="page-header">
      <div>
        <h1>Zone Management</h1>
        <div class="breadcrumb">Admin › Management › <span>Zone Management</span></div>
      </div>
      <div class="header-controls"><span class="mode-badge">Live</span></div>
    </div>

    <div class="dashboard-body zone-page-body">
      <div class="zone-page-intro">
        <div class="zone-intro-title">Organization Zones</div>
        <div class="zone-intro-subtitle">Edit zone name, zone lead, permission group, and icon.</div>
      </div>

      <div class="zone-list-shell">
        <div class="zone-list-head">
          <div class="zone-col-name">Zone</div>
          <div class="zone-col-lead">Zone Lead</div>
          <div class="zone-col-perm">Permission Group</div>
          <div class="zone-col-icon">Icon</div>
          <div class="zone-col-actions">Actions</div>
        </div>
        <div id="zoneRows" class="zone-list-body">
          <div class="zone-loading">Loading zones...</div>
        </div>
      </div>

      <div id="zoneMsg" class="zone-msg" aria-live="polite"></div>
    </div>
  </div>
</div>

<script>
  const iconOptions = [
    { value: 'map-pin', label: 'Map Pin' },
    { value: 'ferris', label: 'Ferris Wheel' },
    { value: 'coaster', label: 'Coaster' },
    { value: 'water', label: 'Water Ride' },
    { value: 'family', label: 'Family Zone' },
    { value: 'star', label: 'Featured' }
  ];

  let operators = [];
  let permissionGroups = [];
  let zones = [];

  function showMessage(text, type) {
    const el = document.getElementById('zoneMsg');
    if (!el) return;
    el.textContent = text;
    el.className = 'zone-msg ' + (type || 'info');
    el.style.display = 'block';
    clearTimeout(showMessage._t);
    showMessage._t = setTimeout(() => {
      el.style.display = 'none';
    }, 2600);
  }

  function esc(text) {
    return String(text ?? '').replace(/[&<>"']/g, (m) => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    }[m]));
  }

  function iconSvg(icon) {
    if (icon === 'ferris') {
      return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="7"/><path d="M12 5v14M5 12h14"/><circle cx="12" cy="12" r="1.4"/></svg>';
    }
    if (icon === 'coaster') {
      return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 16c3-4 6 4 9 0s6 4 9 0"/><path d="M3 19h18"/></svg>';
    }
    if (icon === 'water') {
      return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3c-3 4-5 6-5 9a5 5 0 0010 0c0-3-2-5-5-9z"/></svg>';
    }
    if (icon === 'family') {
      return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="8" cy="8" r="2"/><circle cx="16" cy="8" r="2"/><path d="M4 18a4 4 0 018 0M12 18a4 4 0 018 0"/></svg>';
    }
    if (icon === 'star') {
      return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.1L12 17l-5.6 3 1.1-6.1L3 9.6l6.2-.9L12 3z"/></svg>';
    }
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-5.4 7-11a7 7 0 10-14 0c0 5.6 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>';
  }

  function leadOptions(selected) {
    const base = '<option value="">Unassigned</option>';
    return base + operators.map(op => {
      const isSel = String(op.account_id) === String(selected) ? ' selected' : '';
      return `<option value="${op.account_id}"${isSel}>${esc(op.acc_name)}</option>`;
    }).join('');
  }

  function permissionOptions(selected) {
    const base = '<option value="">Unassigned</option>';
    return base + permissionGroups.map(pg => {
      const isSel = String(pg.permtier_id) === String(selected) ? ' selected' : '';
      return `<option value="${pg.permtier_id}"${isSel}>${esc(pg.permtier_name)}</option>`;
    }).join('');
  }

  function iconOptionsHtml(selected) {
    return iconOptions.map(opt => {
      const isSel = opt.value === selected ? ' selected' : '';
      return `<option value="${opt.value}"${isSel}>${esc(opt.label)}</option>`;
    }).join('');
  }

  function renderZones() {
    const container = document.getElementById('zoneRows');
    if (!container) return;

    if (!zones.length) {
      container.innerHTML = '<div class="zone-empty">No zones found for this organization.</div>';
      return;
    }

    container.innerHTML = zones.map(zone => `
      <div class="zone-row" data-zone-id="${zone.zone_id}">
        <div class="zone-col-name">
          <div class="zone-id">#${zone.zone_id}</div>
          <input class="zone-input zone-name" type="text" value="${esc(zone.zone_name)}" />
          <div class="zone-meta">${Number(zone.ride_count || 0)} rides linked</div>
        </div>
        <div class="zone-col-lead">
          <select class="zone-input zone-lead">${leadOptions(zone.zone_lead_account_id)}</select>
        </div>
        <div class="zone-col-perm">
          <select class="zone-input zone-perm">${permissionOptions(zone.zone_permtier_id)}</select>
        </div>
        <div class="zone-col-icon">
          <div class="icon-preview">${iconSvg(zone.zone_icon || 'map-pin')}</div>
          <select class="zone-input zone-icon">${iconOptionsHtml(zone.zone_icon || 'map-pin')}</select>
        </div>
        <div class="zone-col-actions">
          <button class="btn btn-teal zone-save" type="button">Save</button>
        </div>
      </div>
    `).join('');

    container.querySelectorAll('.zone-row').forEach(row => {
      const saveBtn = row.querySelector('.zone-save');
      const iconSelect = row.querySelector('.zone-icon');
      const iconPreview = row.querySelector('.icon-preview');

      iconSelect.addEventListener('change', () => {
        iconPreview.innerHTML = iconSvg(iconSelect.value);
      });

      row.querySelectorAll('input,select').forEach(el => {
        el.addEventListener('change', () => row.classList.add('dirty'));
        el.addEventListener('input', () => row.classList.add('dirty'));
      });

      saveBtn.addEventListener('click', () => saveZone(row));
    });
  }

  async function loadData() {
    try {
      const res = await fetch('api.php?action=getZoneManagementData');
      const data = await res.json();
      if (!data.success) throw new Error(data.error || 'Failed to load zone data');
      operators = data.operators || [];
      permissionGroups = data.permissionGroups || [];
      zones = data.zones || [];
      renderZones();
    } catch (err) {
      const container = document.getElementById('zoneRows');
      if (container) {
        container.innerHTML = `<div class="zone-empty">${esc(err.message || 'Failed to load')}</div>`;
      }
    }
  }

  async function saveZone(row) {
    const zoneId = row.getAttribute('data-zone-id');
    const zoneName = row.querySelector('.zone-name').value.trim();
    const zoneLead = row.querySelector('.zone-lead').value;
    const zonePerm = row.querySelector('.zone-perm').value;
    const zoneIcon = row.querySelector('.zone-icon').value;

    if (!zoneName) {
      showMessage('Zone name cannot be empty.', 'error');
      return;
    }

    const btn = row.querySelector('.zone-save');
    const oldText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Saving...';

    try {
      const body = new URLSearchParams({
        action: 'saveZone',
        zone_id: zoneId,
        zone_name: zoneName,
        zone_lead_account_id: zoneLead,
        zone_permtier_id: zonePerm,
        zone_icon: zoneIcon
      });

      const res = await fetch('api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString()
      });
      const data = await res.json();
      if (!data.success) throw new Error(data.error || 'Save failed');

      row.classList.remove('dirty');
      showMessage(`Saved zone ${zoneName}.`, 'success');
    } catch (err) {
      showMessage(err.message || 'Failed to save zone.', 'error');
    } finally {
      btn.disabled = false;
      btn.textContent = oldText;
    }
  }

  loadData();
</script>

</body>
</html>