# 🚀 CodeIgniter 3 Ultimate Starter Kit & CRUD Generator

Sebuah fondasi (*Starter Kit*) premium berbasis **CodeIgniter 3.1.13** (Kompatibel PHP 8.x) yang dirancang khusus untuk mempercepat pengembangan aplikasi level *Enterprise*. Repositori ini dilengkapi dengan **The Ultimate CRUD Generator** yang ditenagai oleh AI-logic untuk menganalisis kolom secara *on-the-fly*, mendukung multi-database, serta menerapkan kaidah *best-practice* (Soft Delete, Audit Trail, dan RBAC).

![Dashboard Preview](https://img.shields.io/badge/CodeIgniter-3.1.13-ef4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![AdminLTE](https://img.shields.io/badge/AdminLTE-2.4-blue?style=for-the-badge)
![jQuery](https://img.shields.io/badge/jQuery-3.6.0-0769AD?style=for-the-badge&logo=jquery&logoColor=white)

---

## ✨ Fitur Utama (Core Features)

### 1. ⚙️ Mesin CRUD Generator Sangat Cerdas
Hanya dengan beberapa klik, sistem akan menyintesis kode:
- **Controller (Logic):** Auto-validasi form standar, *DataTables Server-side/Client-side handling*.
- **Model (DB Core):** Secara ajaib merangkai sintaks untuk `insert`, `update`, `soft-delete`, `get_all`, dan *Logging*.
- **Views (UI/UX):** Menyusun Antarmuka Web (Tabel, *Modal Add/Edit*, SweetAlert konfirmasi hapus).
- **Auto-Install:** File dapat diunduh manual (.php) ATAU langsung disuntikkan secara otomatis (*Auto-deploy*) ke kerangka aplikasi berkat fitur `generate_to_file`.

### 2. 🗄️ Multi-Database & Legacy Db Scanner (Dual-Connection Aware)
Punya sistem warisan / *Legacy Database*? Tidak masalah!
- CRUD Generator mampu **memindai database eksternal** (seperti `db_lama`).
- **Dynamic Primary Key:** Generator secara otomatis melacak nama *Primary Key* yang bukan "id" (contoh: `id_mitra`, `id_list_material_wh`) dan menyesuaikan seluruh kueri PHP maupun Javascript.

### 3. 🗑️ The Vault: Unified Recycle Bin
Semua tabel secara bawaan diubah modenya menjadi **Soft Delete** (`deleted_at`).
Sistem merangkum *seluruh rekaman* yang dihapus dari berbagai jenis modul *(Users, Menu, Master Data)* ke dalam satu pangkalan **Recycle Bin Global**. Memungkinkan *Restore* atau *Vaporize* (Hapus Permanen) dengan antarmuka yang elegan berscroll dinamis.

### 4. 🔒 Role-Based Access Control (Dinamis)
- Manajemen Pengguna, Jabatan, dan Hak Akses (_Role_).
- Dinamis menentukan Menu mana saja yang bisa diakses untuk level *Role* tertentu langsung dari panel UI.

### 5. 📊 Excel Import & Client-Side Export
- Modul *Generated* langsung membawa tombol unggah (Import) File `.xls` / `.xlsx` (menggunakan pustaka Shuchkin/SimpleXLSX).
- **Export Data Pintar:** Mengekspor Excel secepat kilat menggunakan *Library* Javascript (SheetJS), di mana data excel ditarik akurat berdasarkan *Pencarian/Filter* yang sedang tertampil di DataTables!

### 6. 📝 Audit Trail / Activity Logging
Merekam seluruh rekam jejak operasi sensitif (`insert`, `update`, `soft-delete`, `import-excel`, `permanent-delete`) yang dilakukan oleh pengguna secara transparan.

---

## 🛠️ Instalasi

1. **Clone Repository ini:**
   ```bash
   git clone https://github.com/darma9989/starter_kit_ci3.git
   cd starter_kit_ci3
   ```
2. **Setup Lingkungan (*Environment*):**
   - Import file sql awal yang berada pada `/database` (jika Anda menyediakan file `.sql` dasar di kemudian hari) ke dalam _MySQL_ Anda (misal db: `db_starter`).
   - Salin file konfigurasi jika ada atau buka konfigurasi di `application/config/database.php`.
   ```php
   // Konfigurasi Standar
   'hostname' => 'localhost',
   'username' => 'root',
   'password' => '',
   'database' => 'db_starter',
   // Setup untuk Database Lama (Legacy) jika ada
   $db['db_lama'] = array(
       'hostname' => 'ip_server',
       //...
   );
   ```
3. **Konfigurasi URL Utama (`config.php`):**
   ```php
   $config['base_url'] = 'http://localhost/starter_kit/';
   $config['index_page'] = ''; // Asumsi .htaccess berjalan normal
   ```
4. **Login:**
   Akses `http://localhost/starter_kit/auth` di browser.
   - Hak Akses Root: Super Admin
   *(Harap atur ulang default password root pada iterasi rilis Anda).*

---

## 📚 Aturan Main (Best Practices)

- **Database Harus Punya Waktu:** Agar modul buatan CRUD Generator berjalan mulus 100%, pastikan semua tabel obyek Anda memiliki setidaknya kolom `created_at (DATETIME)`, `updated_at (DATETIME)`, dan `deleted_at (DATETIME)`. 
-  Recycle Bin terintegrasi murni menggunakan kaidah kolom `deleted_at`.
-  Fitur Auto-Installer Generator membutuhkan hak ases akses tulis direktorat (`chmod 755` atau sejenisnya) untuk struktur map CodeIgniter: `application/controllers`, `application/models`, dan `application/views`.

---

## 🎨 Teknologi & Libraries

- **CodeIgniter 3** (Inti MVC)
- **AdminLTE v2.4.18** (Kerangka Tampilan UI)
- **Bootstrap 3.3.7**
- **DataTables Plugin** (Grid Data & Pagination)
- **SheetJS (XLSX.js)** (Eksportir Excel sisi Klien)
- **SimpleXLSX** (PHP Importir)
- **Font Awesome** / **Ionicons**

*Dibuat untuk memudahkan produktivitas developer mencetak Aplikasi Basis-Data modern skala Enterprise dalam tempo hitungan detik!*
