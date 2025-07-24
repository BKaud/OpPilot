// state.js

// Array of ride names
export let rides = ['Ride 1', 'Ride 2'];

// Mapping from rideName → array of its position names
export let ridePositions = {
  'Ride 1': ['Operator Position 1', 'Operator Position 2'],
  'Ride 2': ['Operator Position 1', 'Operator Position 2']
};

// Operators: name, shifts, minor status, current status (shift/break/assigned), assigned ride/pos
export let operators = [
  { name: 'John', shiftStart: '14:00', shiftEnd: '22:00', isMinor: false, status: 'shift', assigned: null },
  { name: 'Jane', shiftStart: '14:00', shiftEnd: '22:00', isMinor: true, status: 'shift', assigned: null },
  { name: 'Max',  shiftStart: '15:00', shiftEnd: '23:00', isMinor: false, status: 'shift', assigned: null }
];

// Ref for the operator currently being dragged
export let draggedOperatorName = null;
export const scheduledRotations = [
  { time: new Date("2025-07-17T14:00:00") /* …other data…*/ },
  { time: new Date("2025-07-17T14:15:00") /* … */ },
  // etc
];