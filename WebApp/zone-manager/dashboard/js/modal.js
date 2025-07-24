// modal.js

// Overlay container
const modalOverlay = document.getElementById('modalOverlay');

/**
 * Injects the Add Operator form (hidden) into the overlay.
 */
function injectAddOperatorForm() {
  modalOverlay.innerHTML = `
    <div class="modal-box hidden" id="operatorModal" style="max-width:400px;color:#fff;">
      <h3>Add Operator</h3>
      <label>
        Name:<br/>
        <input type="text" id="operatorNameInput"
               style="width:100%;padding:6px;border-radius:6px;border:none;margin-top:4px;" />
      </label>
      <br/><br/>
      <label>
        Shift Start:<br/>
        <input type="time" id="shiftStartInput"
               style="width:100%;padding:6px;border-radius:6px;border:none;margin-top:4px;" />
      </label>
      <br/><br/>
      <label>
        Shift End:<br/>
        <input type="time" id="shiftEndInput"
               style="width:100%;padding:6px;border-radius:6px;border:none;margin-top:4px;" />
      </label>
      <br/><br/>
      <label>
        <input type="checkbox" id="isMinorCheckbox" /> Minor
      </label>

      <div class="modal-buttons">
        <button id="operatorAddConfirm" style="background:#5cb85c;color:#fff;cursor:pointer;">
          Add
        </button>
        <button id="operatorAddCancel" style="background:#ff7373;color:#fff;cursor:pointer;">
          Cancel
        </button>
      </div>
    </div>
  `;
}

/**
 * Shows the Add Operator modal and wires up its buttons.
 * @param {function({name,shiftStart,shiftEnd,isMinor})} onConfirm
 */
export function showAddOperatorModal(onConfirm) {
  // (re)inject the form HTML
  injectAddOperatorForm();

  // un-hide the overlay & the inner modal-box
  modalOverlay.classList.remove('hidden');
  const operatorModal = document.getElementById('operatorModal');
  operatorModal.classList.remove('hidden');

  // grab the two buttons
  const confirmBtn = document.getElementById('operatorAddConfirm');
  const cancelBtn  = document.getElementById('operatorAddCancel');

  // Cancel simply hides everything
  cancelBtn.onclick = () => {
    modalOverlay.classList.add('hidden');
  };

  // Confirm reads inputs, calls back, then hides
  confirmBtn.onclick = () => {
    const name       = document.getElementById('operatorNameInput').value.trim();
    const shiftStart = document.getElementById('shiftStartInput').value;
    const shiftEnd   = document.getElementById('shiftEndInput').value;
    const isMinor    = document.getElementById('isMinorCheckbox').checked;

    onConfirm({ name, shiftStart, shiftEnd, isMinor });
    modalOverlay.classList.add('hidden');
  };
}

/**
 * Simple Yes/No confirmation modal.
 */
export function showConfirmModal(message, onConfirm, onCancel) {
  modalOverlay.innerHTML = `
    <div class="modal-box" id="confirmModal" style="max-width:400px;color:#fff;">
      <p>${message}</p>
      <div class="modal-buttons">
        <button id="confirmYes" style="background:#5cb85c;color:#fff;cursor:pointer;">Yes</button>
        <button id="confirmNo"  style="background:#ff7373;color:#fff;cursor:pointer;">No</button>
      </div>
    </div>
  `;
  modalOverlay.classList.remove('hidden');

  document.getElementById('confirmYes').onclick = () => {
    modalOverlay.classList.add('hidden');
    onConfirm();
  };
  document.getElementById('confirmNo').onclick = () => {
    modalOverlay.classList.add('hidden');
    onCancel?.();
  };
}

/**
 * Searchable dropdown modal (for Remove Ride/Operator).
 */
export function showSelectModal({ title, items, placeholder, confirmText }, onConfirm) {
  modalOverlay.innerHTML = `
    <div class="modal-box" id="selectModal" style="max-width:400px;color:#fff;">
      <h3>${title}</h3>
      <input type="text" id="selectSearch" placeholder="${placeholder}"
             style="width:100%;padding:6px;border-radius:4px;border:1px solid #444;margin:8px 0;" />
      <div style="max-height:180px;overflow-y:auto;margin-bottom:12px;">
        <select id="selectList" size="6"
                style="width:100%;background:#2a2a3d;color:#fff;border:1px solid #444;border-radius:4px;">
        </select>
      </div>
      <div class="modal-buttons">
        <button id="selectConfirm" style="background:#5cb85c;color:#fff;cursor:pointer;">
          ${confirmText}
        </button>
        <button id="selectCancel" style="background:#ff5c5c;color:#fff;cursor:pointer;">
          Cancel
        </button>
      </div>
    </div>
  `;
  modalOverlay.classList.remove('hidden');

  const listEl = document.getElementById('selectList');
  items.forEach(it => {
    const opt = document.createElement('option');
    opt.value = it; opt.textContent = it;
    listEl.appendChild(opt);
  });

  document.getElementById('selectSearch').addEventListener('input', e => {
    const term = e.target.value.toLowerCase();
    Array.from(listEl.options).forEach(o =>
      o.hidden = !o.textContent.toLowerCase().includes(term)
    );
  });

  document.getElementById('selectConfirm').onclick = () => {
    const val = listEl.value;
    if (val) {
      modalOverlay.classList.add('hidden');
      onConfirm(val);
    }
  };
  document.getElementById('selectCancel').onclick = () => {
    modalOverlay.classList.add('hidden');
  };
}

/**
 * Add Ride form modal with custom position names.
 */
export function showAddRideModal(onConfirm) {
  modalOverlay.innerHTML = `
    <div class="modal-box" id="addRideModal" style="max-width:400px;color:#fff;">
      <h3>Add New Ride</h3>
      <label>Ride Name:<br/>
        <input type="text" id="newRideName"
               style="width:100%;padding:6px;border-radius:4px;border:1px solid #444;margin:6px 0;" />
      </label>
      <label>Positions count:<br/>
        <input type="number" id="newRideCount" min="1" value="1"
               style="width:100%;padding:6px;border-radius:4px;border:1px solid #444;margin-bottom:12px;" />
      </label>
      <div id="positionNames"></div>
      <div class="modal-buttons">
        <button id="addRideConfirm" style="background:#5cb85c;color:#fff;cursor:pointer;">
          Add Ride
        </button>
        <button id="addRideCancel" style="background:#ff5c5c;color:#fff;cursor:pointer;">
          Cancel
        </button>
      </div>
    </div>
  `;
  modalOverlay.classList.remove('hidden');

  const cntInput = document.getElementById('newRideCount');
  const namesDiv = document.getElementById('positionNames');

  function renderNames() {
    namesDiv.innerHTML = '';
    const cnt = parseInt(cntInput.value,10) || 1;
    for (let i = 1; i <= cnt; i++) {
      const lbl = document.createElement('label');
      lbl.innerHTML = `
        Position ${i} name:<br/>
        <input type="text" class="posName"
               style="width:100%;padding:6px;border-radius:4px;border:1px solid #444;margin-bottom:8px;" />
      `;
      namesDiv.appendChild(lbl);
    }
  }
  cntInput.oninput = renderNames;
  renderNames();

  document.getElementById('addRideConfirm').onclick = () => {
    const rn = document.getElementById('newRideName').value.trim();
    if (!rn) return alert('Ride name required');
    const pns = Array.from(namesDiv.querySelectorAll('.posName'))
                     .map(i => i.value.trim() || `Position`);
    modalOverlay.classList.add('hidden');
    onConfirm(rn, pns);
  };
  document.getElementById('addRideCancel').onclick = () => {
    modalOverlay.classList.add('hidden');
  };
}
