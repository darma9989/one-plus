# Perbaikan Bug & Peningkatan Sistem

File ini berisi catatan perbaikan dan peningkatan sistem yang dilakukan berdasarkan temuan audit internal aplikasi Starter Kit Enterprise.

## 1. Perbaikan Bug Fatal SQL di Dashboard Generator (Point 1)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/models/Dashboard_model.php`
**Deskripsi Masalah:** 
Sebelumnya, sistem Dashboard mengasumsikan semua tabel memiliki kolom `deleted_at` untuk fitur Soft Delete. Ketika pengguna membuat widget yang mengambil data dari tabel sistem (seperti `activity_logs` atau `settings` yang tidak memiliki kolom tersebut), aplikasi akan crash dengan pesan Error Database (Unknown column 'deleted_at').
**Solusi:**
Menambahkan validasi dinamis `field_exists('deleted_at', $table)` di semua fungsi pemrosesan widget (`get_stat_value`, `get_chart_data`, `get_recent_list`, `get_pivot_data`). Kondisi `WHERE deleted_at IS NULL` kini hanya diterapkan jika tabel tersebut benar-benar mendukung Soft Delete.

---
## 2. Peningkatan Fitur Pivot Table (Relational Heuristics - Point 2)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/models/Dashboard_model.php`
**Deskripsi Masalah:**
Fitur *Pivot Summary Table* pada Dashboard Generator sebelumnya hanya menampilkan angka mentah (ID) jika kolom target yang dipilih adalah *Foreign Key* (misalnya `role_id` atau `user_id`), karena fungsi `group_by` tidak memiliki relasi `JOIN` ke tabel asal.
**Solusi:**
Menambahkan algoritma *Relational Heuristics* pada fungsi `get_pivot_data`. Sistem sekarang otomatis mendeteksi jika kolom target diakhiri dengan `_id`. Jika ya, sistem akan melakukan pencarian *lazy-loading* ke tabel sumber dan melakukan fungsi `LEFT JOIN` otomatis untuk mengambil label/nama data (misalnya mengambil nama role dari tabel `roles`), dan menggunakan `COALESCE` untuk menampilkannya di Pivot Table.

---
## 3. Pembersihan Modul Log Duplikat (Point 3)
**Tanggal:** 06 Maret 2026
**File/Folder yang Dihapus:** 
- `application/controllers/admin/Audit_trail.php`
- `application/views/admin/audit_trail/`
**Deskripsi Masalah:**
Aplikasi memiliki dua antarmuka (UI) yang memanggil log database yang sama (`activity_logs`), yaitu menu **Activity Log** dan **Audit Trail**. Hal ini menyebabkan redundansi fitur dalam sistem.
**Solusi:**
Mempertahankan modul `Activity_log` karena memiliki fungsionalitas Forensic JSON/Diff yang jauh lebih lengkap dan menghapus modul `Audit_trail` beserta navigasinya pada Database `menu` agar kode aplikasi menjadi lebih ringan.

---
## 4. Keamanan & Stabilitas Sesi Server (Database Session)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/config/config.php`
**Deskripsi Masalah:**
Sistem login sebelumnya menggunakan session berbasis file lokal (di folder temp OS). Metode ini rentan terhadap penghapusan massal oleh OS dan kurang cocok untuk arsitektur server tingkat lanjut.
**Solusi:**
Mengalihkan `sess_driver` dari `files` menjadi `database`. Tabel `ci_sessions` telah dibuat. Dengan ini sesi login dijamin persisten, lebih sulit dibajak, dan mendukung skenario load balancing *multi-server*.

## 5. Stabilitas Restore SQL (Tanpa Shell Exec)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/models/Backup_model.php`
**Deskripsi Masalah:**
Fitur restore *Database Backup* sebelumnya bergantung pada pemanggilan command-line OS (`exec` string mysql.exe). Fungsi `exec()` ini secara default diblokir/dinonaktifkan oleh sebagian besar penyedia *Shared Hosting* karena isu keamanan.
**Solusi:**
Merombak fungsi `restore_backup()` dari shell exec ke script *PHP-Native Chunk Reader*. Script kini membaca file `.sql` baris per baris (`fgets`), mendeteksi akhir pernyataan (semicolon), dan mengeksekusinya via *multi_query* berbatas memori. Sistem sekarang 100% jalan di environment hosting mana pun tanpa kendala permissions server.

## 6. User Experience: Auto Login (Remember Me)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** 
- `application/controllers/Auth.php`
- `application/core/MY_Controller.php`
- `application/models/Auth_model.php`
- `application/views/auth/login.php`
**Deskripsi Masalah:**
Sistem login sebelumnya tidak memiliki fitur penyimpanan identitas di sisi *client*. Jika browser ditutup atau sesi *expired*, pengguna dipaksa untuk mengisi form login dari awal, yang mana mengurangi pengalaman pengguna (UX).
**Solusi:**
Menambahkan kolom `remember_token` pada tabel `users`. Lalu menginjeksi algoritma pengecekan `auto_login()` di *Core Controller*. Jika user mencentang opsi "Remember my credentials" di UI Login, sistem akan mengatur *Secure Cookie Token* (kedaluwarsa dalam 30 hari) yang memungkinkan mereka melewati form autentikasi di kunjungan berikutnya.

## 7. Kompatibilitas Sistem (PHP 5.6 Support)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/models/Auth_model.php`
**Deskripsi Masalah:**
Fitur token acak untuk *Remember Me* sebelumnya menggunakan fungsi PHP 7+ yaitu `random_bytes()`, menyebabkan *Fatal error: Call to undefined function random_bytes()* di server dengan versi PHP lama (seperti PHP 5.6).
**Solusi:**
Mengganti *generator* random string menggunakan `openssl_random_pseudo_bytes()`. Pendekatan ini secara _native_ mendukung versi PHP >= 5.3.0 sekaligus tetap mempertahankan tingkat keacakan _Cryptographically Secure_.

## 8. Halaman Error Tersendiri (403 Forbidden Access)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/core/MY_Controller.php`
**Deskripsi Masalah:**
Saat pengguna mencoba *by-pass* URL untuk mengakses modul yang di luar hak (*Role*) akses mereka, sistem sebelumnya hanya membuang (me-*redirect*) mereka kembali ke halaman utama Dashboard dengan pesan _Flashdata_, hal ini kurang memperlihatkan wibawa pembatasan sistem dan berpotensi membuat pengguna bingung.
**Solusi:**
Pemanggilan `show_error()` bawaan CodeIgniter kadang dibaca sebagai bentuk _Error General / Miss Route 404_ di beberapa versi lingkungan server karena _conflict_ dengan *Header Responder*. Karenanya, skrip dirombak untuk tidak lagi menggunakan `show_error()`, melainkan meload _Template View Mandiri_ murni untuk 403 Forbidden dengan nama `application/views/errors/html/error_403.php` dan mengunci status headernya di angka HTTP 403. Tampilannya pun kini sangat berbeda dengan halaman 404 (menggunakan ikon Gembok Peringatan) sehingga tidak perlu ditakutkan user akan ambigu.

## 9. Celah Duplikasi Menu di CRUD Generator
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/controllers/admin/Crud_generator.php`
**Deskripsi Masalah:**
Saat _Developer_ mengeksekusi alat "CRUD Generator" untuk meng-_update_ atau me-_regenerate_ modul yang sudah ada di sistem, generator secara membabi-buta (`insert` method) selalu mendaftarkan ulang navigasi menu tanpa mengecek apakah menu untuk modul tersebut sudah pernah dibuat sebelumnya. Dampaknya adalah Menu Dashboard yang terus menumpuk jika suatu modul dibuat ulang.
**Solusi:**
Merombak skema registrasi menu di file generator. Sebelum melakukan injeksi `$this->db->insert()`, skrip sekarang diharuskan melakukan pengecekan ganda (`$this->db->get_where()`) baik pada Menu Induk (*Parent Menu*) maupun Menu Anak (*Child Menu*). Jika identitas navigasi sudah ada, generator hanya akan mem-_bypass_ pembuatannya namun tetap murni memperbarui (_replace_) file-file _Controller/Model/View_ program.

## 10. Konfigurasi `base_url` Dinamis (Deployment-Ready)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/config/config.php`
**Deskripsi Masalah:**
Nilai `base_url` di-hardcode secara statis (`http://localhost/starter_kit/`). Hal ini memaksa *Developer* untuk merombak ulang pengaturannya setiap kali aplikasi diunggah (deploy) ke dalam _Real Server / Hosting_ maupun saat terjadi perubahan dari http ke https.
**Solusi:**
Mengubah isian `base_url` menjadi satu blok fungsi logika `if-else` gabungan server global variables (`$_SERVER`). Skrip otomatis mengenali protokol server (HTTP/HTTPS), _host name_ (localhost, ip, maupun nama domain beneran), beserta nama folder direktorinya. Ketika aplikasi ini Anda pindahkan ke hosting dengan domain `https://perusahaanku.com`, Anda tidak perlu lagi mengubah file `config.php` sampa ke akar-akarnya!

## 11. Standarisasi Teks Input Modal Secara Global (Email & Telepon)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/views/templates/adminlte2/template.php`
**Deskripsi Masalah:**
Saat mengisi *form input* yang ada di dalam *Modal* (khususnya untuk penambahan *User* atau manipulasi data lain), pengguna secara tidak sengaja sering menyimpan data alamat Email dalam balutan huruf besar (*Uppercase*). Hal terbalik juga terjadi pada *form* input Nomor Telepon di mana antarmuka sistem sebelumnya masih memperbolehkan pengguna untuk mengetikkan karakter Alfabet (huruf).
**Solusi:**
Menanamkan *skrip jQuery Event Listener (`on input`)* murni ke dalam kerangka master utama (`template.php`).
Kini secara global, setiap elemen *input* yang berada di dalam *Modal* dan bernama (atau bertipe) **email** akan **otomatis dikonversi ke karakter kecil (*Lowercase*)** *real-time* saat ditekan. Begitu pula untuk **nomor telepon**, sistem secara proaktif langsung *mem-_block/remove_* ketikan yang berupa angka huruf/simbol non-telepon, menjamin data basis data yang solid di semua sisi antarmuka.

**[UPDATE] Integrasi CRUD Generator:**
Menyadari pentingnya hal ini, sistem *Core Builder (Generator_core.php)* juga telah diperbarui. Setiap kali Developer mencetak/meng-_generate_ modul baru yang kolom tabelnya mengandung kata kunci "email" atau "telp/phone", skrip generator akan:
1. Otomatis membuatkan *tag HTML* `<input type="email">` atau `<input type="tel">` pada form View.
2. Otomatis menambahkan validasi konversi `strtolower()` (untuk email) dan *Regex Strip Number* (untuk telepon) pada file *Controller* saat fungsi *insert/update* dan juga pada mode *Import Excel*, mencegah pemaksaan konversi *Uppercase* default generator.

## 12. Integrasi Multi-Database pada CRUD Generator (Mendukung `db_lama`)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** 
- `application/controllers/admin/Crud_generator.php`
- `application/models/Crud_generator_model.php`
- `application/views/admin/crud_generator/index.php`
- `application/libraries/Generator_core.php`
**Deskripsi Masalah:**
Fitur "Dual Database" (*Read-Only Legacy DB*) telah didukung pada sistem _Config_. Namun tim *Developer* kesulitan ketika ingin membuat UI *Data Table* secara otomatis yang isinya merujuk pada tabel dari *database* lama tersebut karena CRUD Generator hanya membaca `default` database.
**Solusi:**
Merombak arsitektur mesin CRUD Generator secara besar-besaran agar bersifat *Multi-Connection Aware* (Sadar Multi-Koneksi):
1. **Frontend UI generator:** Ditambahkan tombol saklar _Radio Button_ AJAX untuk memilih Sumber Tarikan Tabel. Jika dipilih "Database Sekunder", sistem akan memuat daftar isi _database_ `db_lama`.
2. **Backend Fetcher:** Metode `list_tables()` kini dibuat dinamis dengan menyuntikkan Parameter `$db_group` yang memuat koneksi _on-the-fly_ lalu memunculkan kolom (_field_) yang bersangkutan dari database lama.
3. **Core Scaffolding:** Mesin pembuat _Controller_ dan _Model_ (`Generator_core.php`) kini mendeteksi jika yang dibuat adalah modul Secondary. File tipe (*Model*) yang di-*generate* secara ajaib akan menggunakan sintaks `$this->db_lama = $this->load->database('db_lama', TRUE);` sebagai pengganti `$this->db` bawaan, membuat modul ini 100% aman beroperasi di atas kerangka *Dual Connection* tanpa bentrok!

## 13. Dynamic Primary Key (Antipasi Struktur Database Legacy)
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/libraries/Generator_core.php`
**Deskripsi Masalah:**
Saat pengguna mencoba me-load tabel dari database lama (contoh: `listmaterialwh`), *form* dan *script* selalu error karena generator memaksa mencari kolom bernama `id`, padahal di database lama kolom utamanya (*Primary Key*) bernama aneh seperti `id_list_material_wh`.
**Solusi:**
Ditambahkan logika deteksi cerdas `_get_pk_name($fields)`. AI di dalam Code Generator sekarang sanggup men-scan meta-data tabel untuk melacak kolom mana yang sebenarnya berstatus *Primary Key*. Seluruh koding *Backend* (WHERE id = ?) dan *Frontend Component* (<?php echo $r['id_list_material_wh']; ?>) secara ajaib akan menyesuaikan penulisannya mengikuti nama asli PK dari database warisan (*Legacy DB*).

## 14. Penambahan Fitur "Tools": Export & Import Excel Berbasis JavaScript di Generator
**Tanggal:** 06 Maret 2026
**File yang Diubah:** `application/libraries/Generator_core.php`
**Deskripsi Masalah:**
Fitur Import Excel sebelumnya berdiri sendiri sebagai satu tombol khusus. Pengguna (*User*) kini juga membutuhkan fitur "Export Excel" yang cerdas—yakni mampu mengunduh tepat *hanya* data yang sedang dilihat atau difilter (Filter Pencarian DataTable).
**Solusi:**
1. Menggabungkan tombol *Import* dan *Export* ke dalam sebuah *Dropdown Menu* *"Tools"* (ber-ikon *Wrench* / Kunci Pas) yang diletakkan elegan di *header* tabel.
2. Membangun fungsi `exportExcel()` di Client-Side (*JavaScript*) murni tanpa perlu membebani server PHP. Skrip canggih ini menembus lapisan virtual tabel dari *browser*, membaca data filter terbaru yang tersaji (`tblData.rows({ search: 'applied' }).data()`), menghilangkan kolom "Aksi", menyatukan *header*, dan membungkusnya ke dalam file murni `.xlsx` dalam kecepatan kilat milidetik!

## 15. Recycle Bin: Dual-Database Awareness & Dynamic PK
**Tanggal:** 07 Maret 2026
**File yang Diubah:** `application/models/Recycle_bin_model.php` & `application/views/admin/recycle_bin/index.php`
**Deskripsi Masalah:**
Data dari modul yang beroperasi pada *Legacy Database* (`db_lama`) dan menggunakan kolom *Primary Key* khusus (selain `id`) gagal ditampilkan di layar antarmuka *Recycle Bin*. Menekan tombol 'Restore' atau 'Del' berujung eror JavaScript karena `<button>` dirender dengan merujuk referensi `.id` yang bernilai `undefined`.
**Solusi:**
1. **Multi-DB Crawler**: Menanamkan helper `_get_db()` pada kelas inti `Recycle_bin_model` agar *engine* ini memindai silang tabel-tabel di koneksi `default` dan `db_lama`.
2. **Dynamic PK Fallback**: Jika sebuah tabel tidak menggunakan konvensi nama `id`, generator dinamis `_get_pk_name()` di dalam Recycle Bin Model otomatis menemukan nama asli kunci unik tersebut di database dan meneruskannya (`_pk_id`) menuju *Frontend* (`item._pk_id`) sehingga *Controller* tetap aman menjalankan `restore()` dan `hard_delete()` menggunakan atribut identitas sejati.
3. **UI Scrollability**: Mengantisipasi lonjakan daftar modul di *sidebar* akibat scanning tabel yang menyeluruh, telah ditambahkan proporsi `max-height` dan perilaku `overflow-y` agar panel *Navigation Vault* memunculkan *scrollbar* secara elegan apabila daftar melebih tinggi layar.

## 16. Migrasi Resource CDN Eksternal ke Vendor Lokal
**Tanggal:** 07 Maret 2026
**File yang Diubah:** `application/views/templates/adminlte2/template.php` beserta direktori `assets/starter_kit/vendor/`
**Deskripsi Masalah:**
Ketergantungan desain antarmuka Starter Kit terhadap link CDN (*Content Delivery Network*) eksternal untuk memuat pustaka CSS, Fonts, dan Javascript (Bootstrap, jQuery, AdminLTE, SweetAlert2, dll). Hal ini berisiko sangat tinggi: jika tautan tersebut kedaluwarsa, berubah (*corrupt*), atau aplikasi kelak didistribusikan ke jaringan Server Intranet tertutup tanpa koneksi Internet (Offline), seluruh *User Interface* sistem akan hancur lebur tidak karuan.
**Solusi:**
Proses Isolasi Dependensi Mandiri. Keseluruhan pustaka (*library*) statis mulai dari JS, CSS, tipe Font, hingga *Image Sorting Datatables* dari *Server* pihak ketiga tersebut telah diekstraksi dan disemayamkan secara permanen ke dalam direktori internal `/assets/starter_kit/vendor/`. Selanjutnya, semua tag `<link>` dan `<script src="...">` dirombak murni memanfaatkan pemanggil *relative path* `base_url()`. Starter Kit ini sekarang tersertifikasi **100% Standalone**, anti degradasi, dan kebal mati lampu koneksi internet Global!

---
*(Semua pembaruan Core untuk Dual-Database Synchronization telah diinisialisasi sepenuhnya)*
