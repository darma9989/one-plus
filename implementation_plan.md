# CI3 Enterprise Starter Kit — Implementation Plan

Membangun fondasi starter kit CodeIgniter 3 level enterprise yang bisa digunakan ulang untuk semua project ke depan. Kompatibel dengan **PHP 5.6+**, menggunakan **AdminLTE 2** sebagai template standar untuk konsistensi visual dan performa.

## Filosofi

> **"Semua project baru = implementasi, bukan development dari nol."**

Starter Kit ini berisi semua infrastruktur yang biasa dibangun berulang: authentication, RBAC, menu dinamis, logging, backup, dan konfigurasi sistem. Tinggal clone, ganti database, dan fokus ke fitur bisnis.

---

## Arsitektur Overview

```
starter_kit/
├── application/
│   ├── config/          # Konfigurasi CI3 + starter_kit config
│   ├── controllers/     # Auth + Admin modules
│   ├── core/            # MY_Controller (Auth_Controller)
│   ├── helpers/         # Custom helpers
│   ├── libraries/       # Template, Migration, Module Loader
│   ├── models/          # Auth, Role, Permission, Menu, Log, Backup, Setting
│   └── views/
│       ├── auth/        # Login page
│       ├── templates/   # AdminLTE 2 template only
│       └── admin/       # Semua admin module views
├── assets/
│   ├── adminlte2/       # AdminLTE 2 CSS/JS (CDN references)
│   └── starter_kit/     # Custom CSS/JS
├── uploads/             # Upload directory
├── database.sql         # Full database schema + seed data
├── .htaccess            # URL rewrite
└── index.php            # CI3 entry point
```

---

## Proposed Changes

### 1. Database Schema ([database.sql](file:///d:/xampp/htdocs/crud_generator/database.sql))

#### [NEW] [database.sql](file:///d:/xampp/htdocs/starter_kit/database.sql)

Tabel-tabel inti:

| Tabel | Fungsi |
|-------|--------|
| [users](file:///d:/xampp/htdocs/kpi/application/models/Users_model.php#115-130) | Data user (username, password, email, nama, avatar, status) |
| [roles](file:///d:/xampp/htdocs/kpi/application/models/Users_model.php#131-137) | Daftar role (nama, deskripsi) |
| [menu](file:///d:/xampp/htdocs/kpi/application/models/Menu_model.php#70-74) | Menu hierarchical (nama, icon, link, parent_id, order, status) |
| [role_permissions](file:///d:/xampp/htdocs/kpi/application/models/Users_model.php#82-91) | Mapping role ↔ menu (many-to-many) |
| `settings` | Key-value system configuration |
| `activity_logs` | Activity log (module, action, user, IP, data before/after) |
| `migrations` | Tracking versi migration |
| `backup_schedules` | Jadwal & history backup |

Seed data: 1 Super Admin user, role "Super Admin" & "User", menu default, dan default settings.

---

### 2. Core Framework

#### [NEW] [MY_Controller.php](file:///d:/xampp/htdocs/starter_kit/application/core/MY_Controller.php)

- [MY_Controller](file:///d:/xampp/htdocs/kpi/application/core/MY_Controller.php#7-12) — Base controller kosong
- [Auth_Controller](file:///d:/xampp/htdocs/kpi/application/core/MY_Controller.php#16-56) — Extends MY_Controller, berisi:
  - Cek session `is_logged_in`
  - Cek permission via `Permission_model->has_access(role, uri)`
  - Load global data: menu sidebar, user info, system settings, active theme
- `Admin_Controller` — Extends Auth_Controller, khusus untuk admin area

#### [NEW] [Template.php](file:///d:/xampp/htdocs/starter_kit/application/libraries/Template.php)

- **Theme Engine**: Load template berdasarkan setting `active_theme` (adminlte2 / adminlte3)
- **Layout Toggle**: Support sidebar layout & top-nav layout via setting
- Auto-inject system config variables ke semua view

#### [NEW] [Migration_lib.php](file:///d:/xampp/htdocs/starter_kit/application/libraries/Migration_lib.php)

- Auto-detect file migration di `application/migrations/`
- Jalankan migration yang belum dieksekusi berdasarkan tabel `migrations`
- Format file: `001_create_users.php`, `002_add_avatar_column.php`

#### [NEW] [Module_loader.php](file:///d:/xampp/htdocs/starter_kit/application/libraries/Module_loader.php)

- Baca config `modules.php` untuk daftar module aktif
- Enable/disable module tanpa hapus kode
- Auto-register routes dari module

---

### 3. Authentication & RBAC

#### [NEW] [Auth_model.php](file:///d:/xampp/htdocs/starter_kit/application/models/Auth_model.php)

- [login($username, $password)](file:///d:/xampp/htdocs/kpi/application/models/Users_model.php#13-20) — Verifikasi dengan MD5 (kompatibel PHP 5)
- Brute-force protection (3x salah = blokir)
- Session management
- Audit log on login/logout/failed

#### [NEW] [Role_model.php](file:///d:/xampp/htdocs/starter_kit/application/models/Role_model.php)

- CRUD role dinamis (tidak hardcode)
- Get semua role, get role by ID, insert, update, delete

#### [NEW] [Permission_model.php](file:///d:/xampp/htdocs/starter_kit/application/models/Permission_model.php)

- [has_access($role_name, $uri)](file:///d:/xampp/htdocs/kpi/application/models/Menu_m.php#20-48) — Cek apakah role punya akses ke URI
- `get_menu_for_role($role_name)` — Ambil menu tree berdasarkan role
- `save_permissions($role_id, $menu_ids)` — Simpan permission matrix
- `get_permissions($role_id)` — Ambil daftar menu_id yang diizinkan

#### [NEW] [Auth.php](file:///d:/xampp/htdocs/starter_kit/application/controllers/Auth.php)

- [index()](file:///d:/xampp/htdocs/kpi/application/controllers/Menu.php#12-23) — Tampilkan halaman login
- [login()](file:///d:/xampp/htdocs/kpi/application/models/Users_model.php#13-20) — Proses login
- `logout()` — Destroy session & redirect

---

### 4. System Models

#### [NEW] [Menu_model.php](file:///d:/xampp/htdocs/starter_kit/application/models/Menu_model.php)

- CRUD menu hierarchical
- [get_menu_tree()](file:///d:/xampp/htdocs/kpi/application/models/Menu_model.php#17-30) — Build tree structure dari flat data
- [update_order($items)](file:///d:/xampp/htdocs/kpi/application/controllers/Menu.php#101-112) — Update urutan dari drag & drop
- Activity log on setiap perubahan

#### [NEW] [Log_model.php](file:///d:/xampp/htdocs/starter_kit/application/models/Log_model.php)

- [write($params)](file:///d:/xampp/htdocs/kpi/application/models/Log_model.php#38-60) — Tulis log aktivitas (module, action, before/after, user, IP)
- `get_logs($filters)` — Ambil log dengan filter
- Auto-create table jika belum ada

#### [NEW] [Backup_model.php](file:///d:/xampp/htdocs/starter_kit/application/models/Backup_model.php)

- `create_backup()` — Generate SQL dump
- `restore_backup($file)` — Restore dari file SQL
- [get_history()](file:///d:/xampp/htdocs/kpi/application/models/Log_model.php#61-73) — Daftar backup yang pernah dilakukan
- Support XAMPP mysql path

#### [NEW] [Setting_model.php](file:///d:/xampp/htdocs/starter_kit/application/models/Setting_model.php)

- [get($key)](file:///d:/xampp/htdocs/kpi/application/models/Menu_model.php#70-74) — Ambil setting by key
- [set($key, $value)](file:///d:/xampp/htdocs/kpi/application/libraries/Template.php#7-11) — Simpan setting
- [get_all()](file:///d:/xampp/htdocs/kpi/application/models/Users_model.php#131-137) — Ambil semua settings sebagai associative array
- Settings default: `app_name`, `active_theme`, `sidebar_layout`, `app_version`

---

### 5. Admin Controllers

#### [NEW] Controller-controller admin:

| Controller | Fungsi |
|-----------|--------|
| `Dashboard.php` | Halaman utama setelah login, statistik ringkasan |
| [Users.php](file:///d:/xampp/htdocs/kpi/application/controllers/Users.php) | CRUD user, reset password, block/unblock |
| `Roles.php` | CRUD role, permission matrix checkbox |
| `Menus.php` | CRUD menu hierarchical, drag & drop reorder |
| `Audit_trail.php` | Viewer log dengan DataTables server-side |
| `Backups.php` | Backup & restore database |
| `Settings.php` | System configuration (nama app, theme, layout) |
| `Activity_log.php` | Viewer activity log |

---

### 6. Views & Templates

#### Login Page
- Design modern dengan support AdminLTE 2 & 3
- Logo/nama aplikasi dari system settings
- Flash message untuk error

#### AdminLTE 2 Template
- `templates/adminlte2/template.php` — Main wrapper
- `templates/adminlte2/sidebar.php` — Dynamic sidebar dari menu tree
- `templates/adminlte2/navbar.php` — Top navbar
- `templates/adminlte2/footer.php` — Footer

#### AdminLTE 3 Template
- `templates/adminlte3/template.php` — Main wrapper
- `templates/adminlte3/sidebar.php` — Dynamic sidebar dari menu tree
- `templates/adminlte3/navbar.php` — Top navbar
- `templates/adminlte3/footer.php` — Footer

#### Admin Module Views
- Setiap module punya folder sendiri di `views/admin/`
- Menggunakan DataTables untuk listing
- Modal-based CRUD untuk UX yang responsif

---

### 7. Assets (CDN-Based)

Karena ini starter kit yang ringan, aset AdminLTE akan di-load via **CDN** untuk menghindari file besar:

- **AdminLTE 2**: Bootstrap 3 + AdminLTE 2.4.x
- **AdminLTE 3**: Bootstrap 4 + AdminLTE 3.2.x
- **DataTables**, **SweetAlert2**, **jQuery**, **Font Awesome** semua via CDN
- `assets/starter_kit/custom.css` dan `custom.js` untuk styling tambahan

---

### 8. Konfigurasi CI3

#### [NEW] [config.php](file:///d:/xampp/htdocs/starter_kit/application/config/config.php)
- Base URL, encryption key, session config

#### [NEW] [database.php](file:///d:/xampp/htdocs/starter_kit/application/config/database.php)
- Default MySQL connection ke `starter_kit_db`

#### [NEW] [autoload.php](file:///d:/xampp/htdocs/starter_kit/application/config/autoload.php)
- Auto-load: database, session, form_validation, template, log_model

#### [NEW] [routes.php](file:///d:/xampp/htdocs/starter_kit/application/config/routes.php)
- Default route ke [auth](file:///d:/xampp/htdocs/kpi/application/models/Login_m.php#6-90)
- Admin routes

#### [NEW] [modules.php](file:///d:/xampp/htdocs/starter_kit/application/config/modules.php)
- Daftar module aktif (enable/disable per module)

---

## User Review Required

> [!IMPORTANT]
> **Password Hashing**: Menggunakan MD5 untuk kompatibilitas PHP 5. Jika nanti upgrade ke PHP 7+, disarankan migrasi ke `password_hash()`.

> [!IMPORTANT]
> **Aset via CDN**: AdminLTE, Bootstrap, jQuery dll via CDN untuk menjaga ukuran starter kit tetap kecil. Jika butuh offline, aset bisa di-download ke folder `assets/`.

> [!WARNING]
> **Database**: Starter Kit akan membuat database baru `starter_kit_db`. Pastikan MySQL berjalan di XAMPP.

---

## Verification Plan

### Browser Testing (via browser tool)
1. **Buka** `http://localhost/starter_kit/` → harus redirect ke halaman login
2. **Login** dengan Super Admin (admin / admin123) → harus masuk dashboard
3. **Navigasi** ke setiap menu admin (Users, Roles, Menus, Settings, dll)
4. **Test RBAC**: Buat role baru, assign hanya beberapa menu, login dengan user role tersebut → menu yang tidak di-assign tidak muncul
5. **Test Theme Switch**: Ubah theme dari AdminLTE 2 ke AdminLTE 3 → layout berubah
6. **Test Backup**: Klik backup → file SQL terdownload
7. **Test Audit Trail**: Lakukan beberapa aksi → cek log tercatat

### Manual Verification
- User diminta memverifikasi tampilan visual AdminLTE 2 vs AdminLTE 3
- User diminta memverifikasi semua menu admin berfungsi
