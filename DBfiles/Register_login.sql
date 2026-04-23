-- ============================================================
-- TEAM SYNC — run this once to bring your database up to date.
-- Import via phpMyAdmin: select `oppilot` database → Import tab.
-- Safe to re-run (all changes are guarded with IF NOT EXISTS).
-- ============================================================

USE `oppilot`;

-- ============================================================
-- STEP 1: Registration columns (DBregister.sql)
-- Adds username/password/email to account,
-- and description/color/pfp to organization.
-- ============================================================

DELIMITER $$
CREATE PROCEDURE _add_col(IN tbl VARCHAR(64), IN col VARCHAR(64), IN def TEXT)
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

CALL _add_col('account', 'username',          'varchar(100) DEFAULT NULL');
CALL _add_col('account', 'password',          'varchar(255) DEFAULT NULL');
CALL _add_col('account', 'email',             'varchar(255) DEFAULT NULL');
CALL _add_col('account', 'acc_primary_color', "varchar(7) DEFAULT '#1a8f7a'");

CALL _add_col('organization', 'org_description', 'varchar(500) DEFAULT NULL');
CALL _add_col('organization', 'org_color',       "varchar(30) DEFAULT '#1a8f7a'");
CALL _add_col('organization', 'org_pfp',         'varchar(255) DEFAULT NULL');

-- ============================================================
-- STEP 2: Profile & zone rotation columns
-- (profile_rotation_migration.sql)
-- ============================================================

CALL _add_col('account', 'acc_profile_pic', 'varchar(300) DEFAULT NULL');
CALL _add_col('account', 'acc_job_title',   'varchar(100) DEFAULT NULL');

CALL _add_col('zone', 'zone_rotation_mins',  'int DEFAULT 30');
CALL _add_col('zone', 'zone_rotation_start', 'datetime DEFAULT NULL');

-- ============================================================
-- STEP 3: Org code (org_code_migration.sql)
-- Adds a unique short login code to organization, e.g. "EVERPK"
-- ============================================================

CALL _add_col('organization', 'org_code', 'varchar(30) DEFAULT NULL');

DROP PROCEDURE IF EXISTS _add_col;

-- Add the unique index on org_code if it doesn't already exist
SET @idx_exists = (
  SELECT COUNT(*) FROM information_schema.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME   = 'organization'
    AND INDEX_NAME   = 'uq_org_code'
);

SET @sql2 = IF(
  @idx_exists = 0,
  'ALTER TABLE `organization` ADD UNIQUE KEY `uq_org_code` (`org_code`)',
  'SELECT ''uq_org_code index already exists, skipping'' AS info'
);
PREPARE _st2 FROM @sql2;
EXECUTE _st2;
DEALLOCATE PREPARE _st2;

-- ============================================================
-- STEP 4: Navbar prefs table (navbar_prefs_migration.sql)
-- ============================================================

CREATE TABLE IF NOT EXISTS `navbar_prefs` (
  `pref_id`         INT           NOT NULL AUTO_INCREMENT,
  `pref_username`   VARCHAR(100)  NOT NULL  COMMENT 'Matches $_SESSION[user]',
  `pref_account_id` INT           DEFAULT NULL,
  `slot_index`      TINYINT       NOT NULL  COMMENT '1-9',
  `widget_key`      VARCHAR(50)   DEFAULT NULL COMMENT 'NULL = empty slot',
  `widget_config`   JSON          DEFAULT NULL,
  `updated_at`      DATETIME      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pref_id`),
  UNIQUE KEY `uq_user_slot` (`pref_username`, `slot_index`),
  KEY `fk_navbar_account_idx` (`pref_account_id`),
  CONSTRAINT `fk_navbar_account`
    FOREIGN KEY (`pref_account_id`) REFERENCES `account` (`account_id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
