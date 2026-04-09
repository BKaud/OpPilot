-- ============================================================
-- Migration: Registration Wizard columns
-- Run once against the 'oppilot' database.
-- Safe to re-run — uses IF NOT EXISTS checks via procedure.
-- ============================================================
USE `oppilot`;

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

-- account: username, password, email
CALL _add_col('account', 'username', 'varchar(100) DEFAULT NULL');
CALL _add_col('account', 'password', 'varchar(255) DEFAULT NULL');
CALL _add_col('account', 'email',    'varchar(255) DEFAULT NULL');

-- organization: description, color scheme, pfp
CALL _add_col('organization', 'org_description', 'varchar(500) DEFAULT NULL');
CALL _add_col('organization', 'org_color',       "varchar(30) DEFAULT '#1a8f7a'");
CALL _add_col('organization', 'org_pfp',         'varchar(255) DEFAULT NULL');

DROP PROCEDURE IF EXISTS _add_col;
