// render.js

import { rides, operators, ridePositions } from './state.js';

// DOM containers
const rideGroup                = document.querySelector('.ride-group');
const operatorsOnShiftContainer = document.getElementById('operatorsOnShift');
const operatorsOnBreakContainer = document.getElementById('operatorsOnBreak');

// Create a draggable operator card
export function createDraggableOperator(op) {
  const div = document.createElement('div');
  div.className = 'operator-item';
  div.draggable = true;
  div.dataset.operator = op.name;
  div.innerHTML = `
    <strong>${op.name}</strong><br/>
    <small>Shift: ${op.shiftStart} - ${op.shiftEnd}</small><br/>
    <small>${op.isMinor ? 'Minor' : 'Adult'}</small>
  `;
  div.addEventListener('dragstart', ev => {
    window.draggedOperatorName = ev.target.dataset.operator;
    ev.dataTransfer.setData('text/plain', window.draggedOperatorName);
    ev.dataTransfer.effectAllowed = 'move';
  });
  return div;
}

// Render operators in On‐Shift / On‐Break
export function renderOperators() {
  operatorsOnShiftContainer.innerHTML = '';
  operatorsOnBreakContainer.innerHTML = '';
  operators.forEach(op => {
    if (op.status === 'shift') {
      operatorsOnShiftContainer.appendChild(createDraggableOperator(op));
    } else if (op.status === 'break') {
      operatorsOnBreakContainer.appendChild(createDraggableOperator(op));
    }
  });
}

// Render rides with their custom positions
export function renderRides() {
  rideGroup.innerHTML = '';

  rides.forEach(rideName => {
    const rideBox = document.createElement('div');
    rideBox.className = 'ride-box';
    rideBox.innerHTML = `
      <div class="ride-header">
        <div class="ride-icon"></div>
        <div>${rideName}</div>
      </div>
      <div class="positions-container"></div>
    `;
    const positionsContainer = rideBox.querySelector('.positions-container');

    // get the custom names for this ride, or fallback to 2 generic slots
    const posNames = ridePositions[rideName] ||
      ['Operator Position 1', 'Operator Position 2'];

    posNames.forEach((posLabel, posIdx) => {
      const positionBox = document.createElement('div');
      positionBox.className = 'position-box';
      positionBox.dataset.ride = rideName;
      positionBox.dataset.positionIndex = posIdx;
      positionBox.innerHTML = `<span>${posLabel}</span>`;

      // if someone is assigned here, draw them
      const assigned = operators.find(op =>
        op.status === 'assigned' &&
        op.assigned?.rideName === rideName &&
        op.assigned.positionIndex === posIdx
      );
      if (assigned) {
        const opCard = createDraggableOperator(assigned);
        opCard.style.marginTop = '8px';
        positionBox.appendChild(opCard);
      }

      // drop highlight + emit
      positionBox.addEventListener('dragover', ev => {
        ev.preventDefault();
        positionBox.classList.add('drop-indicator');
      });
      positionBox.addEventListener('dragleave', () => {
        positionBox.classList.remove('drop-indicator');
      });
      positionBox.addEventListener('drop', ev => {
        ev.preventDefault();
        positionBox.classList.remove('drop-indicator');
        positionBox.dispatchEvent(new CustomEvent('operatordrop', {
          bubbles: true,
          detail: ev
        }));
      });

      positionsContainer.appendChild(positionBox);

      // arrow between positions
      if (posIdx < posNames.length - 1) {
        const arrow = document.createElement('div');
        arrow.className = 'arrow';
        arrow.textContent = '🠆';
        positionsContainer.appendChild(arrow);
      }
    });

    rideGroup.appendChild(rideBox);
  });

  // highlight drop on shift/break containers
  [operatorsOnShiftContainer, operatorsOnBreakContainer].forEach(container => {
    container.addEventListener('dragover', ev => {
      ev.preventDefault();
      container.classList.add('drop-indicator');
    });
    container.addEventListener('dragleave', () => {
      container.classList.remove('drop-indicator');
    });
    container.addEventListener('drop', ev => {
      ev.preventDefault();
      container.classList.remove('drop-indicator');
      container.dispatchEvent(new CustomEvent('operatordrop', {
        bubbles: true,
        detail: ev
      }));
    });
  });
}
