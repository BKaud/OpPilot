<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OPilot – Edit Mode</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css?v=2" />
    <link rel="stylesheet" href="../../assets/css/theme.css" />
</head>

<body>
<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../partials/sidebar.php';
?>

  <div class="content">
    <div class="page-header">
      <div>
        <h1>Edit Mode</h1>
        <div class="breadcrumb">Zones › Rides 1 › <span>Edit Mode</span></div>
      </div>

    </div>

    <div class="edit-body resizable-layout">
      <div class="canvas-col">
        <div class="edit-toolbar">
          <button class="tool-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="1 4 1 10 7 10" />
              <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10" />
            </svg>Undo
          </button>
          <button class="tool-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="23 4 23 10 17 10" />
              <path d="M20.49 15a9 9 0 1 1-2.13-9.36L23 10" />
            </svg>Redo
          </button>
          <button class="tool-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
              <polyline points="17 21 17 13 7 13 7 21" />
              <polyline points="7 3 7 8 15 8" />
            </svg>Save
          </button>
          <div class="toolbar-right">
            <span class="node-counter">RIDES ON CANVAS: <span id="slotCount">0</span></span>
          </div>
        </div>
        <div class="canvas-wrap" id="canvasWrap">
          <div id="ci" style="position:relative;width:100%;min-height:100%;padding:16px;box-sizing:border-box;">
            <!-- Single Rotation Zone -->
            <div class="rot-zone" id="mainZone">
              <div class="rot-zone-label">Rotation Zone · Rides 1</div>
              <div class="template-grid" id="templateGrid">
                <!-- Template boxes will be generated dynamically -->
              </div>
            </div>
          </div>
        </div>
        <!-- BOTTOM TRAY -->
        <div class="bottom-tray" id="bottomTray">
          <div class="resize-handle-vertical" id="bottomTrayResize" title="Drag to resize"></div>
          <!-- Return Drop Zone -->
          <div class="return-drop-zone" id="returnDropZone">
            <div class="return-drop-zone-content">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 14 4 9 9 4"></polyline>
                <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
              </svg>
              Return to Attraction Bar
            </div>
          </div>
          <!-- Middle handle controls both trays -->

          <div class="tray-section" id="attractionsTray">
            <div class="tray-header">Attractions</div>
            <div class="tray-scroll">
              <!-- Attractions will be loaded dynamically from database -->
            </div>
          </div>
          <div class="tray-section" id="operatorsTray">
            <div class="tray-header">Unassigned Operators</div>
            <div class="tray-scroll">
              <!-- Operators will be loaded dynamically from database -->
            </div>
          </div>
        </div>
      </div><!-- /canvas-col -->
      <div class="props-panel resizable-horizontal" id="propsPanel">
        <div class="resize-handle-horizontal" id="propsResize" title="Drag to resize">
          <span class="handle-lines">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
          </span>
        </div>
        <div id="resizeTip" role="button" aria-label="Dismiss tip" style="position:absolute;top:48px;right:24px;z-index:10000;background:#fff;color:#1a8f7a;padding:8px 16px;border-radius:8px;font-size:14px;box-shadow:0 2px 8px rgba(0,0,0,0.12);font-family:'Rajdhani',sans-serif;cursor:pointer;">
          <b>Tip:</b> Drag the teal bars to resize panels!
        </div>
        <div class="props-header">Properties</div>
        <div class="props-empty" id="propsEmpty">
          <div class="props-empty-msg">Select a ride on the canvas to view its positions.</div>
        </div>
        <div class="props-body" id="propsBody" style="display:none;">
          <div class="prop-group">
            <div class="prop-group-title">Ride Info</div>
            <div class="prop-row"><span class="prop-label">Ride Name</span><input class="prop-input" id="pRideName" type="text" disabled /></div>
          </div>
          <div class="prop-group">
            <div class="prop-group-title">Position Slots</div>
            <div id="positionSlots" class="position-slots-container">
              <!-- Position slots will be dynamically added here -->
            </div>
          </div>
        </div>
      </div>
    </div><!-- /edit-body -->
  </div><!-- /content -->
  </div><!-- /main -->

  <script>
    // Global data structures
    let rideSlots = [];
    let allAttractions = [];
    let availableOperators = [];
    let selectedSlot = null;
    let slotCounter = 0;
    const ZONE_ID = 1; // Current zone (Rides 1)

    // Load data from database on page load
    async function loadZoneData() {
      try {
        const response = await fetch(`api.php?action=getZoneData&zone_id=${ZONE_ID}`);
        const data = await response.json();

        console.log('API Response:', data);

        if (data.success) {
          allAttractions = data.attractions || [];

          console.log('Loaded attractions:', allAttractions);

          // Show helpful message if no data
          if (allAttractions.length === 0 && data.message) {
            alert(data.message);
          }

          // Separate placed and unplaced attractions
          rideSlots = allAttractions.filter(a => a.isPlaced);

          console.log('Rides on canvas:', rideSlots.length);

          // Build available operators list (all operators)
          const operatorsResponse = await fetch(`api.php?action=getAvailableOperators&zone_id=${ZONE_ID}`);
          const operatorsData = await operatorsResponse.json();
          if (operatorsData.success) {
            availableOperators = operatorsData.operators || [];
            renderOperatorsList();
          }

          slotCounter = allAttractions.length > 0 ? Math.max(...allAttractions.map(a => parseInt(a.id.replace('ride', ''))), 0) : 0;

          // Initial render
          renderGrid();
          renderAttractionBar();
        } else {
          console.error('Failed to load zone data:', data.error);
          alert('Failed to load zone data. Please check database connection.');
        }
      } catch (error) {
        console.error('Error loading zone data:', error);
        alert('Error connecting to database. Please ensure XAMPP MySQL is running.');
      }
    }

    // Render the attraction bar at the bottom
    function renderAttractionBar() {
      const sections = document.querySelectorAll('.tray-section');
      let container = null;

      sections.forEach(section => {
        const header = section.querySelector('.tray-header');
        if (header && header.textContent.includes('Attractions')) {
          container = section.querySelector('.tray-scroll');
        }
      });

      if (!container) {
        console.error('Attraction bar container not found!');
        return;
      }

      console.log('Rendering attractions:', allAttractions.length, 'rides');

      container.innerHTML = allAttractions.map((attraction, index) => {
        const isPlaced = rideSlots.some(slot => slot.id === attraction.id);
        const placedClass = isPlaced ? 'placed' : '';

        return `
      <div class="attr-thumb ${placedClass}" data-attraction-id="${attraction.id}">
        <div class="attr-thumb-label">${attraction.name}</div>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/>
        </svg>
      </div>
    `;
      }).join('');

      console.log('Attraction bar rendered');
      setupDragAndDrop();
    }

    // Map vertical mouse wheel to horizontal scroll
    document.querySelectorAll('.tray-scroll').forEach(el => {
      el.addEventListener('wheel', function(e) {
        if (this.scrollWidth > this.clientWidth) {
          this.scrollLeft -= e.deltaY;
          e.preventDefault();
        }
      }, {
        passive: false
      });
    });

    // Render operators list in sidebar
    function renderOperatorsList() {
      const sections = document.querySelectorAll('.tray-section');
      let container = null;

      sections.forEach(section => {
        const header = section.querySelector('.tray-header');
        if (header && header.textContent.includes('Operators')) {
          container = section.querySelector('.tray-scroll');
        }
      });

      if (!container) {
        console.error('Operators container not found!');
        return;
      }

      console.log('Rendering operators:', availableOperators.length);

      container.innerHTML = availableOperators.map(op => `
    <div class="op-chip" data-operator-id="${op.id}">
      <div class="op-chip-name">${op.name}</div>
      <div class="op-chip-tier">${op.tier}</div>
    </div>
  `).join('');

      setupDragAndDrop();
    }

    // Render the template grid with numbering
    function renderGrid() {
      const grid = document.getElementById('templateGrid');
      grid.innerHTML = '';

      rideSlots.forEach((slot, index) => {
        const box = document.createElement('div');
        box.className = 'template-box';
        box.dataset.slotId = slot.id;
        box.setAttribute('draggable', 'true');

        box.innerHTML = `
      <div class="template-box-number">${index + 1}</div>
      <div class="template-box-header">
        <div class="template-box-ride">${slot.name}</div>
      </div>
      <div class="template-box-positions" id="positions-${slot.id}">
        ${slot.positions.map((pos, idx) => `
          <div class="position-slot" data-slot-id="${slot.id}" data-pos-idx="${idx}">
            <div class="position-slot-name">${pos.name}</div>
            <div class="position-slot-operator ${pos.operator ? 'filled' : 'empty'}" 
                 data-operator="${pos.operator}"
                 data-operator-id="${pos.operatorId || ''}">
              ${pos.operator ? '<span class="op-drag-handle">⠿</span>' : ''}${pos.operator || 'Unassigned'}
            </div>
          </div>
          ${idx < slot.positions.length - 1 ? `
            <div class="rotation-arrow">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="7 13 12 18 17 13"></polyline>
                <line x1="12" y1="18" x2="12" y2="6"></line>
              </svg>
            </div>
          ` : ''}
        `).join('')}
      </div>
    `;

        grid.appendChild(box);

        // Make filled operator chips draggable independently
        box.querySelectorAll('.position-slot-operator.filled').forEach(opEl => {
          opEl.setAttribute('draggable', 'true');
          opEl.addEventListener('dragstart', (e) => {
            e.stopPropagation();
            dragType = 'operator';
            dragSourceSlotId = opEl.closest('.position-slot').dataset.slotId;
            dragSourcePosIdx = parseInt(opEl.closest('.position-slot').dataset.posIdx);
            operatorDragMoved = false;
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', opEl.dataset.operatorId);
            opEl.style.opacity = '0.4';
          });
          opEl.addEventListener('dragend', () => {
            opEl.style.opacity = '1';
            dragSourceSlotId = null;
            dragSourcePosIdx = null;
            operatorDragMoved = false;
            dragType = null;
          });
        });

        // Click handler for selecting ride slot
        box.addEventListener('click', (e) => {
          if (!e.target.classList.contains('template-box-number')) {
            selectRideSlot(slot.id);
          }
        });

        // Drag handler for removing ride from grid
        box.addEventListener('dragstart', (e) => {
          draggedElement = box;
          dragType = 'rideslot';
          draggedSlotId = slot.id;
          e.dataTransfer.effectAllowed = 'move';
          e.dataTransfer.setData('text/plain', slot.id);
          box.style.opacity = '0.5';
          document.getElementById('returnDropZone').classList.add('active');
        });

        box.addEventListener('dragend', (e) => {
          box.style.opacity = '1';
          draggedElement = null;
          dragType = null;
          draggedSlotId = null;
          document.getElementById('returnDropZone').classList.remove('active');
        });

        // Reorder within grid
        box.addEventListener('dragover', (e) => {
          if (dragType === 'rideslot' && draggedSlotId !== slot.id) {
            e.preventDefault();
            e.stopPropagation();
            e.dataTransfer.dropEffect = 'move';
            box.classList.add('drag-over');
          }
        });

        box.addEventListener('dragleave', () => {
          if (dragType === 'rideslot') box.classList.remove('drag-over');
        });

        box.addEventListener('drop', (e) => {
          if (dragType === 'rideslot' && draggedSlotId !== slot.id) {
            e.preventDefault();
            e.stopPropagation();
            box.classList.remove('drag-over');
            const fromIdx = rideSlots.findIndex(s => s.id === draggedSlotId);
            const toIdx = rideSlots.findIndex(s => s.id === slot.id);
            if (fromIdx !== -1 && toIdx !== -1) {
              [rideSlots[fromIdx], rideSlots[toIdx]] = [rideSlots[toIdx], rideSlots[fromIdx]];
              const prevSelected = selectedSlot ? selectedSlot.id : null;
              renderGrid();
              if (prevSelected) selectRideSlot(prevSelected);
              autoSaveLayout('Rotation order updated');
            }
          }
        });
      });

      updateSlotCount();
      setupDragAndDrop();
    }

    // Select a ride slot
    function selectRideSlot(slotId) {
      document.querySelectorAll('.template-box').forEach(b => b.classList.remove('selected'));
      const box = document.querySelector(`[data-slot-id="${slotId}"]`);
      if (box) box.classList.add('selected');

      selectedSlot = rideSlots.find(s => s.id === slotId);
      if (selectedSlot) {
        document.getElementById('propsEmpty').style.display = 'none';
        document.getElementById('propsBody').style.display = 'block';
        document.getElementById('pRideName').value = selectedSlot.name;
        renderPositionSlots();
      }
    }

    // Render position slots in properties panel
    function renderPositionSlots() {
      const container = document.getElementById('positionSlots');
      if (!selectedSlot) return;

      container.innerHTML = selectedSlot.positions.map((pos, idx) => `
    <div class="position-edit-row">
      <input type="text" class="prop-input" value="${pos.name}" disabled placeholder="Position Name" />
      <select class="prop-select" onchange="updatePositionOperator(${idx}, this.value)">
        <option value="">Unassigned</option>
        ${availableOperators.map(op => `<option value="${op.id}" ${String(pos.operatorId) === String(op.id) ? 'selected' : ''}>${op.name}</option>`).join('')}
      </select>
    </div>
  `).join('');
    }

    // Update position operator
    function updatePositionOperator(idx, operatorId) {
      if (!selectedSlot) return;

      const operator = availableOperators.find(op => op.id == operatorId);

      selectedSlot.positions[idx].operatorId = operatorId ? parseInt(operatorId) : null;
      selectedSlot.positions[idx].operator = operator ? operator.name : '';
      selectedSlot.positions[idx].operatorTier = operator ? operator.tier : '';

      renderGrid();
      selectRideSlot(selectedSlot.id);

      autoSaveLayout('Operator assignment updated');
    }

    // Auto-save with visual feedback
    let saveTimeout = null;
    async function autoSaveLayout(message = 'Saving...') {
      console.log('[autoSaveLayout] Triggered with message:', message);
      if (saveTimeout) clearTimeout(saveTimeout);

      saveTimeout = setTimeout(async () => {
        showSaveIndicator(message);
        await saveLayoutToDb();
      }, 500);
    }

    // Show save indicator
    function showSaveIndicator(message) {
      const indicator = document.getElementById('saveIndicator');
      if (!indicator) {
        const div = document.createElement('div');
        div.id = 'saveIndicator';
        div.style.cssText = `
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #1a8f7a;
      color: white;
      padding: 10px 20px;
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      z-index: 10000;
      transition: opacity 0.3s;
    `;
        document.body.appendChild(div);
      }

      const ind = document.getElementById('saveIndicator');
      ind.textContent = message;
      ind.style.opacity = '1';

      setTimeout(() => {
        ind.style.opacity = '0';
      }, 2000);
    }

    // Save layout to database
    async function saveLayoutToDb() {
      try {
        console.log('[saveLayoutToDb] Sending data to API:', {
          zone_id: ZONE_ID,
          attractions: rideSlots
        });

        const response = await fetch('api.php?action=saveLayout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            zone_id: ZONE_ID,
            attractions: rideSlots
          })
        });

        const data = await response.json();
        console.log('[saveLayoutToDb] API Response:', data);

        if (data.success) {
          showSaveIndicator('✓ Saved successfully');
        } else {
          showSaveIndicator('✗ Save failed');
          console.error('Failed to save layout:', data.error);
        }
      } catch (error) {
        console.error('Error saving layout:', error);
        showSaveIndicator('✗ Save error');
      }
    }

    function clearSel() {
      clearSelection();
    }

    function clearSelection() {
      selectedSlot = null;
      document.querySelectorAll('.template-box').forEach(b => b.classList.remove('selected'));
      document.getElementById('propsEmpty').style.display = 'flex';
      document.getElementById('propsBody').style.display = 'none';
    }

    function updateSlotCount() {
      document.getElementById('slotCount').textContent = rideSlots.length;
    }

    // Drag and Drop
    let draggedElement = null;
    let dragType = null;
    let draggedSlotId = null;
    let dragSourceSlotId = null;
    let dragSourcePosIdx = null;
    let operatorDragMoved = false;

    function setupDragAndDrop() {
      // Make attraction thumbnails draggable (non-placed only)
      document.querySelectorAll('.attr-thumb:not(.placed)').forEach(thumb => {
        thumb.setAttribute('draggable', 'true');
        thumb.addEventListener('dragstart', (e) => {
          draggedElement = thumb;
          dragType = 'ride';
          e.dataTransfer.effectAllowed = 'copy';
          e.dataTransfer.setData('text/plain', thumb.dataset.attractionId);
          thumb.style.opacity = '0.5';
        });
        thumb.addEventListener('dragend', (e) => {
          thumb.style.opacity = '1';
          draggedElement = null;
          dragType = null;
        });
      });

      // Make operator chips draggable
      document.querySelectorAll('.op-chip').forEach(chip => {
        chip.setAttribute('draggable', 'true');
        chip.addEventListener('dragstart', (e) => {
          draggedElement = chip;
          dragType = 'operator';
          e.dataTransfer.effectAllowed = 'copy';
          e.dataTransfer.setData('text/plain', chip.dataset.operatorId);
          chip.style.opacity = '0.5';
        });
        chip.addEventListener('dragend', (e) => {
          chip.style.opacity = '1';
          draggedElement = null;
          dragType = null;
        });
      });

      // Grid drop zone for new rides
      const grid = document.getElementById('templateGrid');
      grid.addEventListener('dragover', (e) => {
        if (dragType === 'ride') {
          e.preventDefault();
          e.dataTransfer.dropEffect = 'copy';
        }
      });

      grid.addEventListener('drop', (e) => {
        if (dragType === 'ride') {
          e.preventDefault();
          const attractionId = e.dataTransfer.getData('text/plain');

          const existingRide = rideSlots.find(s => s.id === attractionId);
          if (existingRide) return;

          const attraction = allAttractions.find(a => a.id === attractionId);
          if (!attraction) return;

          rideSlots.push(attraction);

          renderAttractionBar();
          renderGrid();
          selectRideSlot(attraction.id);

          autoSaveLayout('Ride added to canvas');
        }
      });

      // Position operator slots droppable
      document.querySelectorAll('.position-slot-operator').forEach(opSlot => {
        opSlot.addEventListener('dragover', (e) => {
          if (dragType === 'operator') {
            e.preventDefault();
            e.stopPropagation();
            e.dataTransfer.dropEffect = 'copy';
            opSlot.classList.add('drag-over');
          }
        });
        opSlot.addEventListener('dragleave', (e) => {
          opSlot.classList.remove('drag-over');
        });
        opSlot.addEventListener('drop', (e) => {
          e.preventDefault();
          e.stopPropagation();
          opSlot.classList.remove('drag-over');
          if (dragType === 'operator') {
            const operatorId = parseInt(e.dataTransfer.getData('text/plain'));
            const posSlot = opSlot.closest('.position-slot');
            const slotId = posSlot.dataset.slotId;
            const posIdx = parseInt(posSlot.dataset.posIdx);
            const slot = rideSlots.find(s => s.id === slotId);
            if (slot && slot.positions[posIdx]) {
              const operator = availableOperators.find(op => op.id == operatorId);
              if (operator) {
                slot.positions[posIdx].operatorId = operator.id;
                slot.positions[posIdx].operator = operator.name;
                slot.positions[posIdx].operatorTier = operator.tier;
              }
              if (dragSourceSlotId !== null) {
                const srcSlot = rideSlots.find(s => s.id === dragSourceSlotId);
                if (srcSlot && srcSlot.positions[dragSourcePosIdx] &&
                  !(dragSourceSlotId === slotId && dragSourcePosIdx === posIdx)) {
                  srcSlot.positions[dragSourcePosIdx].operatorId = null;
                  srcSlot.positions[dragSourcePosIdx].operator = '';
                  srcSlot.positions[dragSourcePosIdx].operatorTier = '';
                }
                operatorDragMoved = true;
              }
              renderGrid();
              if (selectedSlot && selectedSlot.id === slotId) {
                selectRideSlot(slotId);
              }

              autoSaveLayout('Operator assigned');
            }
          }
        });
      });

      // Return drop zone
      const returnZone = document.getElementById('returnDropZone');
      returnZone.addEventListener('dragover', (e) => {
        if (dragType === 'rideslot') {
          e.preventDefault();
          e.dataTransfer.dropEffect = 'move';
          returnZone.classList.add('drag-over');
        }
      });

      returnZone.addEventListener('dragleave', (e) => {
        if (e.target === returnZone) {
          returnZone.classList.remove('drag-over');
        }
      });

      returnZone.addEventListener('drop', (e) => {
        e.preventDefault();
        returnZone.classList.remove('drag-over');
        if (dragType === 'rideslot' && draggedSlotId) {
          rideSlots = rideSlots.filter(s => s.id !== draggedSlotId);

          if (selectedSlot && selectedSlot.id === draggedSlotId) {
            clearSelection();
          }

          renderAttractionBar();
          renderGrid();

          autoSaveLayout('Ride removed from canvas');
        }
      });
    }

    // Canvas click to deselect
    document.getElementById('ci').addEventListener('click', (e) => {
      if (e.target === e.currentTarget || e.target.id === 'mainZone' || e.target.classList.contains('rot-zone-label') || e.target.id === 'templateGrid') {
        clearSelection();
      }
    });

    // Initial render
    loadZoneData();

    // ── Resizable Panels ──

    // Horizontal resize for Properties panel
    const propsPanel = document.getElementById('propsPanel');
    const propsResize = document.getElementById('propsResize');
    let isResizingProps = false;
    let startXProps = 0;
    let startWidthProps = 0;
    propsResize.addEventListener('mousedown', function(e) {
      e.preventDefault();
      isResizingProps = true;
      startXProps = e.clientX;
      startWidthProps = propsPanel.offsetWidth;
      document.body.style.cursor = 'ew-resize';
      document.body.style.userSelect = 'none';
    });
    document.addEventListener('mousemove', function(e) {
      if (isResizingProps) {
        let newWidth = startWidthProps + (startXProps - e.clientX);
        newWidth = Math.max(220, Math.min(600, newWidth));
        propsPanel.style.width = newWidth + 'px';
      }
    });
    document.addEventListener('mouseup', function() {
      if (isResizingProps) {
        isResizingProps = false;
        document.body.style.cursor = '';
        document.body.style.userSelect = '';
      }
    });

    // Vertical resize for bottom tray
    const bottomTray = document.getElementById('bottomTray');
    const bottomTrayResize = document.getElementById('bottomTrayResize');
    let isResizingTray = false;
    let startYTray = 0;
    let startHeightTray = 0;
    bottomTrayResize.addEventListener('mousedown', function(e) {
      e.preventDefault();
      isResizingTray = true;
      startYTray = e.clientY;
      startHeightTray = bottomTray.offsetHeight;
      document.body.style.cursor = 'ns-resize';
      document.body.style.userSelect = 'none';
    });
    document.addEventListener('mousemove', function(e) {
      if (isResizingTray) {
        // Dragging up (negative delta) increases tray height
        let newHeight = startHeightTray - (e.clientY - startYTray);
        newHeight = Math.max(60, Math.min(window.innerHeight * 0.6, newHeight));
        bottomTray.style.height = newHeight + 'px';
      }
    });
    document.addEventListener('mouseup', function() {
      if (isResizingTray) {
        isResizingTray = false;
        document.body.style.cursor = '';
        document.body.style.userSelect = '';
      }
    });

    // Middle handle: vertical resize OR horizontal scroll
    const attractionsTray = document.getElementById('attractionsTray');
    const operatorsTray = document.getElementById('operatorsTray');
    const middleResize = document.getElementById('middleTrayResize');
    let middleMode = null;
    let startYMiddle = 0;
    let startXMiddle = 0;
    let startHeightMiddle = 0;
    let startScrollLeft = 0;

    middleResize.addEventListener('mousedown', function(e) {
      e.preventDefault();
      middleMode = null;
      startYMiddle = e.clientY;
      startXMiddle = e.clientX;
      startHeightMiddle = bottomTray.offsetHeight;
      const aScroll = attractionsTray.querySelector('.tray-scroll');
      startScrollLeft = aScroll ? aScroll.scrollLeft : 0;
      document.body.style.userSelect = 'none';
      document.body.style.cursor = 'ns-resize';
    });

    document.addEventListener('mousemove', function(e) {
      if (middleMode === null && (e.buttons & 1)) {
        const dx = e.clientX - startXMiddle;
        const dy = e.clientY - startYMiddle;
        if (Math.abs(dx) > 6 || Math.abs(dy) > 6) {
          middleMode = Math.abs(dx) > Math.abs(dy) ? 'scroll' : 'resize';
          if (middleMode === 'scroll') document.body.style.cursor = 'grab';
        }
      }

      if (middleMode === 'resize' && (e.buttons & 1)) {
        // Dragging up (negative delta) increases tray height
        let newHeight = startHeightMiddle - (e.clientY - startYMiddle);
        newHeight = Math.max(60, Math.min(window.innerHeight * 0.6, newHeight));
        bottomTray.style.height = newHeight + 'px';
      }

      if (middleMode === 'scroll' && (e.buttons & 1)) {
        const dx = e.clientX - startXMiddle;
        const newScroll = startScrollLeft - dx;
        const aScroll = attractionsTray.querySelector('.tray-scroll');
        const oScroll = operatorsTray.querySelector('.tray-scroll');
        if (aScroll) aScroll.scrollLeft = newScroll;
        if (oScroll) oScroll.scrollLeft = newScroll;
      }
    });

    document.addEventListener('mouseup', function() {
      if (middleMode !== null) {
        middleMode = null;
        document.body.style.userSelect = '';
        document.body.style.cursor = '';
      }
    });

    // Tip: dismissible and auto-hide after 30s
    const resizeTip = document.getElementById('resizeTip');
    if (resizeTip) {
      resizeTip.tabIndex = 0;
      const hideTip = () => {
        resizeTip.style.transition = 'opacity 0.18s';
        resizeTip.style.opacity = '0';
        setTimeout(() => {
          try { resizeTip.style.display = 'none'; } catch (e) {}
        }, 200);
      };

      let tipTimeout = setTimeout(hideTip, 30000);

      resizeTip.addEventListener('click', () => {
        clearTimeout(tipTimeout);
        hideTip();
      });

      resizeTip.addEventListener('keydown', (ev) => {
        if (ev.key === 'Enter' || ev.key === ' ') {
          ev.preventDefault();
          clearTimeout(tipTimeout);
          hideTip();
        }
      });
    }
  </script>
</body>

</html>