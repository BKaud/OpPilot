-- ============================================================
-- OpPilot Initial Setup: Test Organization & Admin User
-- Run this ONCE to create a test organization and admin account
-- ============================================================
USE `oppilot`;

-- Create a test organization
INSERT INTO organization (org_id, org_code, org_name, org_description, org_color)
VALUES (1, 'DEMO', 'Demo Organization', 'Test organization for development', '#1a8f7a')
ON DUPLICATE KEY UPDATE org_code = 'DEMO';

-- Create admin permissions (all permissions enabled)
INSERT INTO accpermissions (accperms_id, accperms_createdel_acc, accperms_createdel_zone, accperms_createdel_ride, accperms_createdel_event, accperms_call_downtime_gen)
VALUES (1, 1, 1, 1, 1, 1)
ON DUPLICATE KEY UPDATE accperms_id = 1;

-- Create an admin account
-- Username: admin
-- Password: password
INSERT INTO account (account_id, username, password, acc_name, acc_permissions, acc_is_active, email, acc_primary_color)
VALUES (
  1,
  'admin',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Password: 'password'
  'System Administrator',
  1, -- References permtier_id = 1
  1,
  'admin@example.com',
  '#1a8f7a'
)
ON DUPLICATE KEY UPDATE username = 'admin';

-- Link the admin account to the organization
INSERT INTO org_acc (org_acc_id, org_acc_org_id, org_acc_acc_id)
VALUES (1, 1, 1)
ON DUPLICATE KEY UPDATE org_acc_org_id = 1;

-- Verify insertion
SELECT 
  'SUCCESS' as status,
  o.org_id, 
  o.org_code, 
  o.org_name,
  a.account_id,
  a.username as 'Login Username',
  a.acc_name as 'Display Name',
  'Use password: password' as note
FROM organization o
JOIN org_acc oa ON oa.org_acc_org_id = o.org_id
JOIN account a ON a.account_id = oa.org_acc_acc_id
WHERE o.org_code = 'DEMO';
