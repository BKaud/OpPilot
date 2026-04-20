-- ============================================================
-- Migration: profile fields + zone rotation settings
-- Run once against the `oppilot` database.
-- ============================================================

USE `oppilot`;

-- Account: profile picture path
ALTER TABLE `account`
  ADD COLUMN `acc_profile_pic` VARCHAR(300) DEFAULT NULL
    COMMENT 'Relative path under APP_ROOT, e.g. assets/images/profile-pics/prof_admin_1234.jpg';

-- Account: job title
ALTER TABLE `account`
  ADD COLUMN `acc_job_title` VARCHAR(100) DEFAULT NULL
    COMMENT 'User-facing job title / position label';

-- Account: user-selected primary theme color
ALTER TABLE `account`
  ADD COLUMN `acc_primary_color` VARCHAR(7) DEFAULT '#1a8f7a'
    COMMENT 'Hex color used as UI accent, e.g. #1a8f7a';

-- Zone: rotation cycle length
ALTER TABLE `zone`
  ADD COLUMN `zone_rotation_mins` INT DEFAULT 30
    COMMENT 'Rotation cycle length in minutes';

-- Zone: rotation start timestamp
ALTER TABLE `zone`
  ADD COLUMN `zone_rotation_start` DATETIME DEFAULT NULL
    COMMENT 'Timestamp when the current rotation cycle started; NULL = use current time as origin';
