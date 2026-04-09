-- ============================================================
-- Migration: navbar_prefs
-- Run once against the `oppilot` database.
--
-- Links to account.account_id via acc_username (VARCHAR) as the
-- interim key while the auth system is still placeholder-based.
-- Once real auth stores account_id in session, add the FK below.
-- ============================================================

USE `oppilot`;

CREATE TABLE IF NOT EXISTS `navbar_prefs` (
  `pref_id`         INT           NOT NULL AUTO_INCREMENT,
  `pref_username`   VARCHAR(100)  NOT NULL  COMMENT 'Matches $_SESSION[user]',
  `pref_account_id` INT           DEFAULT NULL COMMENT 'FK to account.account_id – populate once auth stores account_id in session',
  `slot_index`      TINYINT       NOT NULL  COMMENT '1-9',
  `widget_key`      VARCHAR(50)   DEFAULT NULL COMMENT 'NULL = empty slot',
  `widget_config`   JSON          DEFAULT NULL COMMENT 'Widget-specific options e.g. {"zone_id":1,"label":"My Link","url":"/page"}',
  `updated_at`      DATETIME      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pref_id`),
  UNIQUE KEY `uq_user_slot` (`pref_username`, `slot_index`),
  KEY `fk_navbar_account_idx` (`pref_account_id`),
  CONSTRAINT `fk_navbar_account`
    FOREIGN KEY (`pref_account_id`) REFERENCES `account` (`account_id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
