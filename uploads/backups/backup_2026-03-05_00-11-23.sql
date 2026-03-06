#
# TABLE STRUCTURE FOR: activity_logs
#

DROP TABLE IF EXISTS `activity_logs`;

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) NOT NULL,
  `sub_module` varchar(50) DEFAULT NULL,
  `item_id` varchar(50) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `data_before` longtext,
  `data_after` longtext,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_module` (`module`),
  KEY `idx_action` (`action`),
  KEY `idx_user` (`user_id`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4;

INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (1, 'AUTH', NULL, '1', 'Super Administrator', 'LOGIN', NULL, NULL, 1, 'Super Administrator', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-04 23:11:29');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (2, 'AUTH', NULL, '1', 'Super Administrator', 'LOGOUT', NULL, NULL, 1, 'Super Administrator', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-04 23:13:37');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (3, 'AUTH', NULL, '1', 'Super Administrator', 'LOGIN', NULL, NULL, 1, 'Super Administrator', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-04 23:14:13');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (4, 'AUTH', NULL, '1', 'Super Administrator', 'LOGIN', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:16:34');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (5, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:16:47');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (6, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:16:55');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (7, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:17:04');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (8, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:17:16');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (9, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:17:23');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (10, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-04 23:19:47');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (11, 'AUTH', NULL, '1', 'Super Administrator', 'LOGOUT', NULL, NULL, 1, 'Super Administrator', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-04 23:21:46');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (12, 'AUTH', NULL, NULL, NULL, 'LOGOUT', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-04 23:24:03');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (13, 'AUTH', NULL, '1', 'Super Administrator', 'LOGOUT', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:25:14');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (14, 'AUTH', NULL, '1', 'Super Administrator', 'LOGIN', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:29:44');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (15, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"black\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:30:31');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (16, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"black\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:30:48');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (17, 'AUTH', NULL, '1', 'Super Administrator', 'LOGOUT', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:31:26');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (18, 'AUTH', NULL, '1', 'Super Administrator', 'LOGIN', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:31:33');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (19, 'AUTH', NULL, '1', 'Super Administrator', 'LOGIN', NULL, NULL, 1, 'Super Administrator', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-04 23:37:19');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (20, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"tabler\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:40:10');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (21, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:40:26');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (22, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"red\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:40:33');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (23, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"red\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"tabler\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"red\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:40:40');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (24, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"tabler\",\"sidebar_layout\":\"sidebar\",\"skin_color\":\"red\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:40:54');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (25, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:41:00');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (26, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:41:19');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (27, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:42:10');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (28, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"tabler\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:44:59');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (29, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"tabler\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:45:27');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (30, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"active_theme\":\"adminlte3\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:45:34');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (31, 'AUTH', NULL, '1', 'Super Administrator', 'LOGOUT', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:49:34');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (32, 'AUTH', NULL, '1', 'Super Administrator', 'LOGIN', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:50:29');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (33, 'SYSTEM', 'MENU', '13', 'My Profile', 'DELETE', '{\"id\":\"13\",\"menu_name\":\"My Profile\",\"menu_icon\":\"fa fa-user\",\"menu_link\":\"admin\\/profile\",\"parent_id\":null,\"menu_order\":\"99\",\"menu_status\":\"1\",\"created_at\":\"2026-03-04 23:44:51\",\"updated_at\":null}', NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:50:49');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (34, 'SYSTEM', 'MENU', '12', 'My Profile', 'DELETE', '{\"id\":\"12\",\"menu_name\":\"My Profile\",\"menu_icon\":\"fa fa-user\",\"menu_link\":\"admin\\/profile\",\"parent_id\":null,\"menu_order\":\"99\",\"menu_status\":\"1\",\"created_at\":\"2026-03-04 23:44:17\",\"updated_at\":null}', NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:50:54');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (35, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"blue\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"green\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:51:43');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (36, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"green\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:51:48');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (37, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"red\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"purple\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:51:53');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (38, 'SYSTEM', 'USERS', '1', 'Super Administrator', 'BLOCK', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:54:01');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (39, 'SYSTEM', 'USERS', '1', 'Super Administrator', 'UNBLOCK', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-04 23:54:03');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (40, 'SYSTEM', 'SETTINGS', NULL, NULL, 'UPDATE', '{\"app_name\":\"CI3 Enterprise Starter Kit\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"active_theme\":\"adminlte2\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"purple\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"login_attempts\":\"3\",\"backup_path\":\".\\/uploads\\/backups\\/\"}', '{\"app_name\":\"REKONLINK\",\"app_version\":\"1.0.0\",\"app_description\":\"Enterprise-grade CodeIgniter 3 Starter Kit\",\"footer_text\":\"\\u252c\\u00ae 2026 Starter Kit\",\"sidebar_layout\":\"topnav\",\"skin_color\":\"purple\",\"login_attempts\":\"3\"}', 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-05 00:08:57');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (41, 'SYSTEM', 'USERS', '1', 'Super Administrator', 'BLOCK', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-05 00:09:46');
INSERT INTO `activity_logs` (`id`, `module`, `sub_module`, `item_id`, `item_name`, `action`, `data_before`, `data_after`, `user_id`, `user_name`, `ip_address`, `user_agent`, `created_at`) VALUES (42, 'SYSTEM', 'USERS', '1', 'Super Administrator', 'UNBLOCK', NULL, NULL, 1, 'Super Administrator', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', '2026-03-05 00:09:49');


#
# TABLE STRUCTURE FOR: backup_history
#

DROP TABLE IF EXISTS `backup_history`;

CREATE TABLE `backup_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `filesize` varchar(50) DEFAULT NULL,
  `backup_type` enum('manual','scheduled') DEFAULT 'manual',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: menu
#

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(100) NOT NULL,
  `menu_icon` varchar(100) DEFAULT 'fa fa-circle-o',
  `menu_link` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_order` int(5) NOT NULL DEFAULT '0',
  `menu_status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_parent` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Dashboard', 'fa fa-dashboard', 'dashboard', NULL, 1, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 'Master Data', 'fa fa-database', '#', NULL, 2, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 'User Management', 'fa fa-users', 'admin/users', 2, 1, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, 'Role Management', 'fa fa-shield', 'admin/roles', 2, 2, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, 'Menu Management', 'fa fa-bars', 'admin/menus', 2, 3, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (6, 'Sistem', 'fa fa-cogs', '#', NULL, 3, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (7, 'Settings', 'fa fa-wrench', 'admin/settings', 6, 1, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (8, 'Database Backup', 'fa fa-database', 'admin/backups', 6, 2, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (9, 'Monitoring', 'fa fa-eye', '#', NULL, 4, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (10, 'Activity Log', 'fa fa-history', 'admin/activity_log', 9, 1, 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (11, 'Audit Trail', 'fa fa-file-text', 'admin/audit_trail', 9, 2, 1, '2026-03-04 23:10:23', NULL, NULL);


#
# TABLE STRUCTURE FOR: migrations
#

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  `executed_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: role_permissions
#

DROP TABLE IF EXISTS `role_permissions`;

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`menu_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 1);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 2);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 3);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 4);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 5);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 6);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 7);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 8);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 9);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 10);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (1, 11);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (2, 1);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (2, 2);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (2, 3);
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES (3, 1);


#
# TABLE STRUCTURE FOR: roles
#

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles` (`id`, `role_name`, `description`, `is_superadmin`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Super Admin', 'Akses penuh ke seluruh sistem', 1, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `roles` (`id`, `role_name`, `description`, `is_superadmin`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 'Admin', 'Akses administrasi terbatas', 0, '2026-03-04 23:10:23', NULL, NULL);
INSERT INTO `roles` (`id`, `role_name`, `description`, `is_superadmin`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 'User', 'Akses user biasa', 0, '2026-03-04 23:10:23', NULL, NULL);


#
# TABLE STRUCTURE FOR: settings
#

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_group` varchar(50) DEFAULT 'general',
  `description` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES (1, 'app_name', 'REKONLINK', 'general', 'Nama aplikasi', '2026-03-05 00:08:57');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES (2, 'app_version', '1.0.0', 'general', 'Versi aplikasi', '2026-03-05 00:08:57');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES (3, 'app_description', 'Enterprise-grade CodeIgniter 3 Starter Kit', 'general', 'Deskripsi aplikasi', '2026-03-05 00:08:57');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES (4, 'active_theme', 'adminlte2', 'appearance', 'Tema aktif (adminlte2 / adminlte3)', '2026-03-04 23:45:34');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES (5, 'sidebar_layout', 'topnav', 'appearance', 'Layout (sidebar / topnav)', '2026-03-05 00:08:57');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES (6, 'skin_color', 'purple', 'appearance', 'Warna skin tema', '2026-03-05 00:08:57');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES (7, 'footer_text', '┬® 2026 Starter Kit', 'appearance', 'Teks footer', '2026-03-05 00:08:57');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES (8, 'login_attempts', '3', 'security', 'Maksimal percobaan login sebelum blokir', '2026-03-05 00:08:57');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES (9, 'backup_path', './uploads/backups/', 'system', 'Path penyimpanan backup', NULL);


#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default.png',
  `role_id` int(11) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0',
  `failed_login` int(3) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `email`, `no_telp`, `avatar`, `role_id`, `is_active`, `is_blocked`, `failed_login`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'admin', '0192023a7bbd73250516f069df18b500', 'Super Administrator', 'admin@starterkit.local', NULL, 'default.png', 1, 1, 0, 0, '2026-03-04 23:50:29', '2026-03-04 23:10:23', '2026-03-05 00:09:49', NULL);


