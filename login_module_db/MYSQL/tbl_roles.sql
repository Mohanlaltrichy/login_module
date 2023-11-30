-- Adminer 4.8.1 MySQL 8.0.35-0ubuntu0.20.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tbl_roles`;
CREATE TABLE `tbl_roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  `description` text,
  `company_id` bigint DEFAULT '0',
  `admin_all_pages` char(1) DEFAULT 'N' COMMENT 'Y/N',
  `user_all_pages` char(1) DEFAULT 'N' COMMENT 'Y/N',
  `roles_all_pages` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `opc_all_pages` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `tag_all_pages` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `mqtt_all_pages` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `http_all_pages` char(1) NOT NULL DEFAULT 'N',
  `bulk_import_status_all_pages` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `utc_created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `local_created_at` datetime DEFAULT NULL,
  `utc_updated_at` datetime DEFAULT NULL,
  `local_updated_at` datetime DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2023-11-30 06:37:19
