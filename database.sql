-- ============================================================
-- CI3 Enterprise Starter Kit — Database Schema
-- Database: starter_kit_db
-- ============================================================

CREATE DATABASE IF NOT EXISTS `starter_kit_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `starter_kit_db`;

-- ============================================================
-- 1. TABEL USERS — Data profil user
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `nama` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    `no_telp` VARCHAR(20) DEFAULT NULL,
    `avatar` VARCHAR(255) DEFAULT 'default.png',
    `role_id` INT(11) NOT NULL DEFAULT 1,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_blocked` TINYINT(1) NOT NULL DEFAULT 0,
    `failed_login` INT(3) NOT NULL DEFAULT 0,
    `last_login` DATETIME DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT NULL,
    `deleted_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 2. TABEL ROLES — Daftar role dinamis
-- ============================================================
CREATE TABLE IF NOT EXISTS `roles` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `role_name` VARCHAR(50) NOT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `is_superadmin` TINYINT(1) NOT NULL DEFAULT 0,
    `can_add_user` TINYINT(1) NOT NULL DEFAULT 0,
    `can_view_all_users` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT NULL,
    `deleted_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_role_name` (`role_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 3. TABEL MENU — Menu hierarchical dinamis
-- ============================================================
CREATE TABLE IF NOT EXISTS `menu` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `menu_name` VARCHAR(100) NOT NULL,
    `menu_icon` VARCHAR(100) DEFAULT 'fa fa-circle-o',
    `menu_link` VARCHAR(255) DEFAULT NULL,
    `parent_id` INT(11) DEFAULT NULL,
    `menu_order` INT(5) NOT NULL DEFAULT 0,
    `menu_status` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT NULL,
    `deleted_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_parent` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 4. TABEL ROLE_PERMISSIONS — Mapping role <-> menu
-- ============================================================
CREATE TABLE IF NOT EXISTS `role_permissions` (
    `role_id` INT(11) NOT NULL,
    `menu_id` INT(11) NOT NULL,
    PRIMARY KEY (`role_id`, `menu_id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`menu_id`) REFERENCES `menu`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 5. TABEL SETTINGS — Konfigurasi sistem key-value
-- ============================================================
CREATE TABLE IF NOT EXISTS `settings` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `setting_key` VARCHAR(100) NOT NULL,
    `setting_value` TEXT DEFAULT NULL,
    `setting_group` VARCHAR(50) DEFAULT 'general',
    `description` VARCHAR(255) DEFAULT NULL,
    `updated_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 6. TABEL ACTIVITY_LOGS — Log aktivitas global
-- ============================================================
CREATE TABLE IF NOT EXISTS `activity_logs` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `module` VARCHAR(50) NOT NULL,
    `sub_module` VARCHAR(50) DEFAULT NULL,
    `item_id` VARCHAR(50) DEFAULT NULL,
    `item_name` VARCHAR(255) DEFAULT NULL,
    `action` VARCHAR(50) NOT NULL,
    `data_before` LONGTEXT DEFAULT NULL,
    `data_after` LONGTEXT DEFAULT NULL,
    `user_id` INT(11) DEFAULT NULL,
    `user_name` VARCHAR(100) DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` TEXT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_module` (`module`),
    KEY `idx_action` (`action`),
    KEY `idx_user` (`user_id`),
    KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 7. TABEL MIGRATIONS — Tracking versi migrasi
-- ============================================================
CREATE TABLE IF NOT EXISTS `migrations` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT(11) NOT NULL,
    `executed_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 8. TABEL BACKUP_HISTORY — Riwayat backup database
-- ============================================================
CREATE TABLE IF NOT EXISTS `backup_history` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(255) NOT NULL,
    `filesize` VARCHAR(50) DEFAULT NULL,
    `backup_type` ENUM('manual','scheduled') DEFAULT 'manual',
    `created_by` INT(11) DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================================
-- SEED DATA
-- ============================================================

-- Roles default
INSERT INTO `roles` (`id`, `role_name`, `description`, `is_superadmin`) VALUES
(1, 'Super Admin', 'Akses penuh ke seluruh sistem', 1),
(2, 'Admin', 'Akses administrasi terbatas', 0),
(3, 'User', 'Akses user biasa', 0);

-- User Super Admin default (password: admin123)
INSERT INTO `users` (`id`, `username`, `password`, `nama`, `email`, `role_id`, `is_active`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Super Administrator', 'admin@starterkit.local', 1, 1);

-- Menu default
INSERT INTO `menu` (`id`, `menu_name`, `menu_icon`, `menu_link`, `parent_id`, `menu_order`, `menu_status`) VALUES
(1,  'Dashboard',               'fa fa-dashboard',    'dashboard',            NULL, 1,  1),
(2,  'System Administration',   'fa fa-cogs',         '#',                    NULL, 2,  1),
(3,  'User Management',         'fa fa-users',        'admin/users',          2,    1,  1),
(4,  'Role Management',         'fa fa-shield',       'admin/roles',          2,    2,  1),
(5,  'Menu Management',         'fa fa-bars',         'admin/menus',          2,    3,  1),
(7,  'Settings',                'fa fa-wrench',       'admin/settings',       2,    4,  1),
(8,  'Database Backup',         'fa fa-database',     'admin/backups',        2,    5,  1),
(9,  'System Monitoring',       'fa fa-desktop',      '#',                    NULL, 3,  1),
(10, 'Activity Log',            'fa fa-history',      'admin/activity_log',   9,    1,  1),
(11, 'Audit Trail',             'fa fa-file-text',    'admin/audit_trail',    9,    2,  1);

-- Permission: Super Admin dapat akses semua menu
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 7), (1, 8), (1, 9), (1, 10), (1, 11);

-- Permission: Admin dapat akses Dashboard + User Management
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES
(2, 1), (2, 2), (2, 3);

-- Permission: User hanya Dashboard
INSERT INTO `role_permissions` (`role_id`, `menu_id`) VALUES
(3, 1);

-- Settings default
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`, `description`) VALUES
('app_name',        'CI3 Enterprise Starter Kit',   'general',    'Nama aplikasi'),
('app_version',     '1.0.0',                        'general',    'Versi aplikasi'),
('app_description', 'Enterprise-grade CodeIgniter 3 Starter Kit', 'general', 'Deskripsi aplikasi'),
('active_theme',    'adminlte2',                    'appearance', 'Tema aktif (adminlte2 / adminlte3)'),
('sidebar_layout',  'sidebar',                      'appearance', 'Layout (sidebar / topnav)'),
('skin_color',      'blue',                         'appearance', 'Warna skin tema'),
('footer_text',     '© 2026 Starter Kit',           'appearance', 'Teks footer'),
('login_attempts',  '3',                            'security',   'Maksimal percobaan login sebelum blokir'),
('backup_path',     './uploads/backups/',            'system',     'Path penyimpanan backup');
