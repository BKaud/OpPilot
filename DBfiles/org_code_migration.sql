-- ============================================================
-- Migration: org_code
-- Run once against the `oppilot` database.
--
-- Adds a unique human-readable code to each organization so
-- members can log in with e.g. "EVERPK" instead of a numeric ID.
-- ============================================================

USE `oppilot`;

ALTER TABLE `organization`
  ADD COLUMN `org_code` VARCHAR(30) DEFAULT NULL
    COMMENT 'Custom login code set at registration (letters, numbers, hyphens, underscores)',
  ADD UNIQUE KEY `uq_org_code` (`org_code`);
