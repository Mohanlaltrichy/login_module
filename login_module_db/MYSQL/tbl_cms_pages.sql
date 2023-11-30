-- Adminer 4.8.1 MySQL 8.0.35-0ubuntu0.20.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tbl_cms_pages`;
CREATE TABLE `tbl_cms_pages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `page_name` varchar(50) NOT NULL,
  `page_url` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_name` (`page_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `tbl_cms_pages` (`id`, `page_name`, `page_url`, `module`, `status`, `created_at`, `updated_at`) VALUES
(1,	'admin_dashboard',	'/admin/dashboard',	'model_builder',	'inactive',	'2023-11-03 06:49:24',	'0000-00-00 00:00:00'),
(2,	'admin_company',	'/admin/company',	'model_builder',	'inactive',	'2023-11-03 06:49:27',	'0000-00-00 00:00:00'),
(3,	'admin_subscription',	'/admin/subscription',	'model_builder',	'inactive',	'2023-11-03 06:49:28',	'0000-00-00 00:00:00'),
(4,	'admin_role',	'/admin/role',	'model_builder',	'inactive',	'2023-11-03 06:49:30',	'0000-00-00 00:00:00'),
(5,	'admin_dataroot',	'/admin/dataroot',	'model_builder',	'inactive',	'2023-11-03 06:49:32',	'0000-00-00 00:00:00'),
(6,	'admin_user',	'/admin/user',	'model_builder',	'inactive',	'2023-11-03 06:49:34',	'0000-00-00 00:00:00'),
(7,	'user_dashboard',	'/user/dashboard',	'model_builder',	'inactive',	'2023-11-03 06:49:35',	'0000-00-00 00:00:00'),
(8,	'user_dataroot',	'/user/dataroot',	'model_builder',	'inactive',	'2023-11-03 06:49:37',	'0000-00-00 00:00:00'),
(9,	'user_project',	'/user/project',	'model_builder',	'inactive',	'2023-11-03 06:49:39',	'0000-00-00 00:00:00'),
(10,	'user_node',	'/user/node',	'model_builder',	'inactive',	'2023-11-03 06:49:41',	'0000-00-00 00:00:00'),
(11,	'user_deploy',	'/user/deploy',	'model_builder',	'inactive',	'2023-11-03 06:49:43',	'0000-00-00 00:00:00'),
(12,	'user_undeploy',	'/user/undeploy',	'model_builder',	'inactive',	'2023-11-03 06:49:45',	'0000-00-00 00:00:00'),
(13,	'user_search',	'/user/search',	'model_builder',	'inactive',	'2023-11-03 06:49:49',	'0000-00-00 00:00:00'),
(14,	'user_template',	'/user/template',	'model_builder',	'inactive',	'2023-11-03 06:49:51',	'0000-00-00 00:00:00'),
(15,	'user_uom',	'/user/unit',	'model_builder',	'inactive',	'2023-11-03 06:49:53',	'0000-00-00 00:00:00'),
(16,	'opc_add_server',	'/opc',	'cloud_connector',	'active',	'2023-11-29 17:52:51',	'0000-00-00 00:00:00'),
(17,	'opc_add_node',	'/opc/opc_add_more/0',	'cloud_connector',	'active',	'2023-11-03 06:48:32',	'0000-00-00 00:00:00'),
(18,	'opc_search_&_edit',	'/opc/opc_search',	'cloud_connector',	'active',	'2023-11-29 17:52:51',	'0000-00-00 00:00:00'),
(19,	'opc_bulk_import',	'/opc/opc_bulk_import/0',	'cloud_connector',	'active',	'2023-11-03 06:48:45',	'0000-00-00 00:00:00'),
(20,	'historian_create_table',	'/tag',	'cloud_connector',	'active',	'2023-11-29 17:52:51',	'0000-00-00 00:00:00'),
(21,	'historian_search_&_edit',	'/tag/tag_search',	'cloud_connector',	'active',	'2023-11-29 17:52:51',	'0000-00-00 00:00:00'),
(22,	'historian_bulk_import',	'/tag/tag_bulk_import/0/0',	'cloud_connector',	'active',	'2023-11-29 17:52:51',	'0000-00-00 00:00:00'),
(23,	'mqtt_add_topic',	'/mqtt',	'cloud_connector',	'active',	'2023-11-29 17:52:51',	'0000-00-00 00:00:00'),
(24,	'mqtt_add_node',	'/mqtt/mqtt_add_more/0',	'cloud_connector',	'active',	'2023-11-29 17:52:51',	'0000-00-00 00:00:00'),
(25,	'mqtt_search_&_edit',	'/mqtt/mqtt_search',	'cloud_connector',	'active',	'2023-11-29 17:52:51',	'0000-00-00 00:00:00'),
(26,	'mqtt_bulk_import',	'/mqtt/mqtt_bulk_import/0',	'cloud_connector',	'active',	'2023-11-03 06:50:01',	'0000-00-00 00:00:00'),
(27,	'bulk_import_status',	'/bulk_import_list',	'cloud_connector',	'active',	'2023-11-03 06:50:03',	'0000-00-00 00:00:00'),
(28,	'roles',	'/company_role',	'login_module',	'active',	'2023-11-03 06:51:17',	'0000-00-00 00:00:00'),
(29,	'http(s)_add_server',	'/http',	'cloud_connector',	'active',	'2023-11-29 17:55:31',	'0000-00-00 00:00:00'),
(30,	'http(s)_add_node',	'/http/http_add_node/0',	'cloud_connector',	'active',	'2023-11-29 17:55:31',	'0000-00-00 00:00:00'),
(31,	'http(s)_search_&_edit',	'/http/http_search',	'cloud_connector',	'active',	'2023-11-29 17:55:31',	'0000-00-00 00:00:00'),
(32,	'http(s)_bulk_import',	'/http/http_bulk_import/0',	'',	'active',	'2023-11-29 17:55:31',	'0000-00-00 00:00:00');

-- 2023-11-30 06:36:18
