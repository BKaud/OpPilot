-- ============================================================
-- Migration: account_management
-- Run once against the `oppilot` database.
--
-- Adds:
--   1. permtier_name to permtier (needed by perm-group dropdowns)
--   2. org_job_position table  (org-scoped HR positions)
--   3. acc_job_position_id on account (assigned position)
--   4. acc_permtier_id on account    (manual perm-group override)
-- ============================================================

USE `oppilot`;

DELIMITER $$
CREATE PROCEDURE IF NOT EXISTS _add_col_acctmgmt(
    IN tbl VARCHAR(64), IN col VARCHAR(64), IN def TEXT)
BEGIN
  IF NOT EXISTS (
    SELECT 1 FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = tbl
      AND COLUMN_NAME  = col
  ) THEN
    SET @_sql = CONCAT('ALTER TABLE `', tbl, '` ADD COLUMN `', col, '` ', def);
    PREPARE _st FROM @_sql;
    EXECUTE _st;
    DEALLOCATE PREPARE _st;
  END IF;
END$$
DELIMITER ;

-- 1. Give permtier a human-readable name
CALL _add_col_acctmgmt('permtier', 'permtier_name', "VARCHAR(100) DEFAULT NULL COMMENT 'Display name for this permission group'");

-- 2. org_job_position — HR-level positions scoped to an org
CREATE TABLE IF NOT EXISTS `org_job_position` (
  `ojp_id`                  INT           NOT NULL AUTO_INCREMENT,
  `ojp_org_id`              INT           NOT NULL,
  `ojp_name`                VARCHAR(100)  NOT NULL,
  `ojp_default_permtier_id` INT           DEFAULT NULL
    COMMENT 'Default perm group auto-applied when a user is assigned this position (overridable)',
  `ojp_created_at`          DATETIME      DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ojp_id`),
  KEY `idx_ojp_org` (`ojp_org_id`),
  KEY `idx_ojp_permtier` (`ojp_default_permtier_id`),
  CONSTRAINT `ojp_fk_org`
    FOREIGN KEY (`ojp_org_id`) REFERENCES `organization` (`org_id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ojp_fk_permtier`
    FOREIGN KEY (`ojp_default_permtier_id`) REFERENCES `permtier` (`permtier_id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 3. Account: assigned job position
CALL _add_col_acctmgmt('account', 'acc_job_position_id',
  "INT DEFAULT NULL COMMENT 'FK to org_job_position.ojp_id'");

-- 4. Account: manual permission-group override
--    NULL = use position default; non-NULL = manually assigned
CALL _add_col_acctmgmt('account', 'acc_permtier_id',
  "INT DEFAULT NULL COMMENT 'Manual perm-group override; NULL means fall back to position default'");

DROP PROCEDURE IF EXISTS _add_col_acctmgmt;
