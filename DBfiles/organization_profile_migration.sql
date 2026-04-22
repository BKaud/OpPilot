-- Migration: Add profile picture and color columns to organization table
-- This allows organization owners to customize their organization's appearance

ALTER TABLE `organization` 
ADD COLUMN `org_profile_pic` varchar(500) DEFAULT NULL COMMENT 'Path to organization profile picture',
ADD COLUMN `org_color` varchar(7) DEFAULT '#1a8f7a' COMMENT 'Organization primary color (hex)';
