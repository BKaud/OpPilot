// main.js

import { rides, ridePositions, operators } from './state.js';
import { renderOperators, renderRides } from './render.js';
import {
  showAddOperatorModal,
  showConfirmModal,
  showSelectModal,
  showAddRideModal
} from './modal.js';

const API_BASE = 'http://localhost:5005';  // <-- your API URL

// 1) Fetch & render the rotation schedule panel
function renderRotationSchedule(blocks) {
  const container = document.querySelector('.rotation-schedule');
  const header = container.querySelector('h3');
  container.innerHTML = '';
  container.appendChild(header);

  // group by human‐friendly time
  const byTime = blocks.reduce((acc, b) => {
    const tm = new Date(b.rotationTime)
      .toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    (acc[tm] = acc[tm] || []).push(b);
    return acc;
  }, {});

  for (const [time, entries] of Object.entries(byTime)) {
    const block = document.createElement('div');
    block.className = 'rotation-time-block';
    block.innerHTML = `<h4>${time} Rotation</h4>`;
    entries.forEach(b => {
      const box = document.createElement('div');
      box.className = 'operator-rotation-box';
      box.innerHTML = `
        <div class="operator-name">${b.operatorName}</div>
        <div class="rotation-details">
          <div><strong>From:</strong> ${b.fromRide} – ${b.fromPosition}</div>
          <div><strong>To:</strong>   ${b.toRide} – ${b.toPosition}</div>
          <div class="rotation-time-label">${time}</div>
        </div>
      `;
      block.appendChild(box);
    });
    container.appendChild(block);
  }
}

async function loadRotationSchedule() {
  try {
    const resp = await fetch(`${API_BASE}/api/rotations`);
    if (!resp.ok) throw new Error(resp.statusText);
    const rotations = await resp.json();
    renderRotationSchedule(rotations);
  } catch (err) {
    console.error('Failed to load rotation schedule:', err);
  }
}

// 2) Fetch the next rotation time
async function getNextRotationTime() {
  try {
    const resp = await fetch(`${API_BASE}/api/rotations/next`);
    if (!resp.ok) return null;
    const data = await resp.json();
    return new Date(data.rotationTime);
  } catch {
    return null;
  }
}

// 3) “Push rotation” action
function pushRotation() {
  console.log('Rotation pushed!');
  // TODO: call your API POST to push rotation
}

window.draggedOperatorName = null;

window.addEventListener('DOMContentLoaded', () => {
  // UI refs
  const rideGroup = document.querySelector('.ride-group');
  const shiftContainer = document.getElementById('operatorsOnShift');
  const breakContainer = document.getElementById('operatorsOnBreak');
  const addRideBtn = document.getElementById('addRideBtn');
  const removeRideBtn = document.getElementById('removeRideBtn');
  const addOpBtn = document.getElementById('addOperatorBtn');
  const removeOpBtn = document.getElementById('removeOperatorBtn');
  const addEventBtn = document.getElementById('add-event-btn');
  const pushRotBtn = document.getElementById('push-rotation-btn');
  const toggleEditBtn = document.getElementById('toggleEditModeBtn');

  let editMode = false;
  function updateUI() {
    document.body.classList.toggle('edit-mode', editMode);
    toggleEditBtn.textContent = editMode ? 'Edit Mode: ON' : 'Edit Mode: OFF';
    renderOperators();
    renderRides();
    loadRotationSchedule();
  }

  // Toggle edit mode
  toggleEditBtn.addEventListener('click', () => {
    if (!editMode) {
      showConfirmModal('Enable edit mode?<br/>' +
  '<span style="color:#c9c9c9;;">' +
    '(Discouraged during operation hours. Use "Add Event" button instead.)' +
  '</span>', () => {
        editMode = true; updateUI();
      });
    } else {
      editMode = false; updateUI();
    }
  });

  // DRAG & DROP handlers (only in edit mode)
  rideGroup.addEventListener('operatordrop', ev => {
    if (!editMode) return;
    const d = ev.detail; d.preventDefault();
    const rideName = d.currentTarget.dataset.ride;
    const idx = +d.currentTarget.dataset.positionIndex;
    if (!window.draggedOperatorName) return;

    // if someone is already there, send them back to shift
    const replaced = operators.find(o =>
      o.status === 'assigned'
      && o.assigned?.rideName === rideName
      && o.assigned.positionIndex === idx
    );
    if (replaced) {
      replaced.status = 'shift';
      replaced.assigned = null;
    }

    const op = operators.find(o => o.name === window.draggedOperatorName);
    if (op) {
      op.status = 'assigned';
      op.assigned = { rideName, positionIndex: idx };
    }

    window.draggedOperatorName = null;
    renderOperators();
    renderRides();
  });

  [shiftContainer, breakContainer].forEach(container => {
    container.addEventListener('operatordrop', ev => {
      if (!editMode) return;
      ev.preventDefault();
      const op = operators.find(o => o.name === window.draggedOperatorName);
      if (!op) return;
      op.status = container === shiftContainer ? 'shift' : 'break';
      op.assigned = null;
      window.draggedOperatorName = null;
      renderOperators();
      renderRides();
    });
  });

  // ADD RIDE
  addRideBtn.addEventListener('click', () => {
    if (!editMode) return;
    showAddRideModal((rideName, posNames) => {
      rides.push(rideName);
      ridePositions[rideName] = posNames;
      renderRides();
      loadRotationSchedule();
    });
  });

  // REMOVE RIDE
  removeRideBtn.addEventListener('click', () => {
    if (!editMode) return;
    if (rides.length === 0) return alert('No rides to remove.');
    showSelectModal(
      { title: 'Remove Ride', items: rides, placeholder: 'Search rides…', confirmText: 'Remove' },
      rideName => {
        showConfirmModal(`Delete "${rideName}"?`, () => {
          // unassign any assigned ops
          operators.forEach(o => {
            if (o.status === 'assigned' && o.assigned.rideName === rideName) {
              o.status = 'shift';
              o.assigned = null;
            }
          });
          delete ridePositions[rideName];
          rides.splice(rides.indexOf(rideName), 1);
          renderRides();
          renderOperators();
          loadRotationSchedule();
        });
      }
    );
  });

  // ADD OPERATOR
  addOpBtn.addEventListener('click', () => {
    if (!editMode) return;
    showAddOperatorModal((name, start, end, isMinor) => {
      if (!name || !start || !end) return alert('All fields required');
      if (operators.some(o => o.name.toLowerCase() === name.toLowerCase()))
        return alert('Operator already exists');
      operators.push({ name, shiftStart: start, shiftEnd: end, isMinor, status: 'shift', assigned: null });
      renderOperators();
      loadRotationSchedule();
    });
  });

  // REMOVE OPERATOR
  removeOpBtn.addEventListener('click', () => {
    if (!editMode) return;
    const names = operators.map(o => o.name);
    if (!names.length) return alert('No operators to remove.');
    showSelectModal(
      { title: 'Remove Operator', items: names, placeholder: 'Search operators…', confirmText: 'Remove' },
      opName => {
        showConfirmModal(`Delete "${opName}"?`, () => {
          const idx = operators.findIndex(o => o.name === opName);
          operators.splice(idx, 1);
          renderOperators();
          loadRotationSchedule();
        });
      }
    );
  });

  // ADD EVENT (always visible)
  addEventBtn.addEventListener('click', () => {
    alert('Add Event clicked – implement your logic here');
  });

  // PUSH ROTATION with 5‑min warning
  pushRotBtn.addEventListener('click', async () => {
    const next = await getNextRotationTime();
    const now = new Date();
    console.log(`🕒 now: ${now.toLocaleString()}, next: ${next ? next.toLocaleString() : '[none]'}`);

    let warning = '';
    if (next && next - now > 5 * 60 * 1000) {
      warning = `
        <br><br>
        <div style="color:#ff4c4c;font-weight:bold;">
          ⚠ Pushing more than 5 minutes early.<br>
          Now: ${now.toLocaleTimeString()}<br>
          Next: ${next.toLocaleTimeString()}
        </div>
      `;
    }

    showConfirmModal(
      `Push rotation now?${warning}`,
      () => {
        console.log('Rotation confirmed at', new Date().toLocaleString());
        pushRotation();
      }
    );
  });

  // INITIAL RENDER
  renderOperators();
  renderRides();
  loadRotationSchedule();
});
