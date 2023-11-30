-- Adminer 4.8.1 MySQL 8.0.35-0ubuntu0.20.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tbl_companies`;
CREATE TABLE `tbl_companies` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `customerId` varchar(50) NOT NULL COMMENT 'unique random key to access customer in URL',
  `company_name` varchar(250) NOT NULL COMMENT 'company name should be unique',
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `company_address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `zipcode` varchar(40) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `company_phone` varchar(15) NOT NULL,
  `contact_mobile` varchar(15) DEFAULT NULL,
  `company_website` varchar(100) DEFAULT NULL,
  `bank_details` text,
  `gstn` varchar(100) DEFAULT NULL,
  `subscription_id` int NOT NULL,
  `subscription_type` enum('monthly','yearly','lifetime') NOT NULL,
  `subscription_start` timestamp NULL DEFAULT NULL,
  `subscription_end` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive','deleted','expired') NOT NULL DEFAULT 'active' COMMENT 'Account active status',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name` (`company_name`),
  UNIQUE KEY `company_email` (`company_email`),
  UNIQUE KEY `customerId` (`customerId`),
  KEY `subscription` (`subscription_id`),
  CONSTRAINT `tbl_companies_ibfk_1` FOREIGN KEY (`subscription_id`) REFERENCES `tbl_subscriptions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2023-11-30 06:36:32
