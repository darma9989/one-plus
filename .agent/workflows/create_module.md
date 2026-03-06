---
description: Create a new module conforming to Starter Kit's strict Enterprise Rules
---

# Enterprise Starter Kit — Module Creation Guidelines

Whenever the USER asks to create a new module, you MUST strictly follow all the architectural, security, and UI/UX rules defined below. Do not deviate from these standards.

## 1. Database & Model Rules
*   **Soft Delete**: Every new table MUST have a `deleted_at DATETIME DEFAULT NULL` column. NEVER use a hard `DELETE` query in the primary module. Always execute `UPDATE deleted_at = CURRENT_TIMESTAMP`.
*   **Activity Log**: Every `INSERT`, `UPDATE`, `DELETE` (Soft), dan `RESTORE` wajib tercatat ke dalam tabel `activity_logs` menggunakan `$this->Log_model->write()`.
*   **Read Query**: Fungsi `get_all()` pada model selalu tambahkan klausa pendaring: `$this->db->where('deleted_at IS NULL');`
*   **Recycle Bin Integration**: Jika modul ini penting, tambahkan method `restore()` dan `hard_delete()` pada model-nya, lalu daftarkan nama tabelnya ke Controller dan Model Global `Recycle_bin`. **MANDATORI:** Model WAJIB memiliki fungsi `get_deleted()` (`where deleted_at IS NOT NULL`) agar menu Recycle Bin tidak memicu Fatal Error saat menghitung jumlah pembuangan sampah!

## 2. Security & Controller Rules
*   Semua Controller modul admin harus meng-extends `Admin_Controller`.
*   *Validation*: Semaksimal mungkin gunakan `$this->form_validation->set_rules` sebelum melakukan aksi Insert/Update. Kembalikan error menggunakan `validation_errors()`.
*   *AJAX JSON Standard*: Semua response dari form submission (Insert, Update, Delete) HARUS mengembalikan struktur JSON murni yang konsisten: `echo json_encode(['status' => 'success'/'error', 'message' => 'Detail pesan']);`. DILARANG me-redirect halaman langsung dari controller untuk proses CRUD.
*   *Role Logic*: Gunakan pengecekan permissions untuk mencegah akses jika diperlukan, atau filter data model berdasar role jika menyangkut privasi user.
*   *Auto Text Transformation*: Biasakan membersihkan data di Controller sebelum Insert/Update. Gunakan `strtoupper()` untuk nama ID/Kode, dan `ucwords()` untuk kalimat Deskripsi agar data di tabel selalu terlihat rapi (Enterprise standard).

## 3. UI/UX & Views Rules
*   **Modal Behavior (Strict)**: Modal TIDAK BOLEH bisa tertutup jika user klik area kosong di luar modal. Selalu tambahkan properti ini di elemen `<div class="modal fade">`: 
    `data-backdrop="static" data-keyboard="false"`
*   **Modal Headers**: Wajib berwarna biru elegan (atau merah untuk Delete) dengan text putih, tanpa border kasar.
    Gunakan `<div class="modal-header bg-primary shadow-sm" style="border:0;">`.
*   **JavaScript Handlers & Notification**: Selalu gunakan JQuery AJAX (`$.post` / `$.ajax`) untuk memproses form modal. Jangan gunakan submit tradisional. Response dari controller HARUS ditangkap dan ditampilkan menggunakan fungsi modern `App.toast()` (untuk alert notifikasi ringan) atau `App.alert()` / `App.confirm()` berbasis SweetAlert (untuk konfirmasi atau error).
*   **Global AJAX Loader (Anti-Spam)**: SETIAP pemanggilan AJAX request (Insert/Update/Delete), UI layar wajib dikunci dengan overlay spinner loading (misal menggunakan fungsi global seperti `App.showLoader()` jika tersedia, atau implementasi kustom jQuery `beforeSend` / `complete`). Ini mutlak diperlukan untuk mencegah user melakukan klik tombol Submit berkali-kali (Spamming) saat latency internet lambat.
*   **Button Styles**: Kombinasi warna Bootstrap dengan border-radius tipis atau tipe *.btn-flat* modern, gunakan ukuran *.btn-sm* pada tabel. Selalu prioritaskan class `.btn-flat`.
*   **Tables & DataTables**: Gunakan class `.table .table-hover` untuk semua tabel dasar. Jika menggunakan plugin DataTable, matikan/sembunyikan input pencarian "Search" bawaannya jika Anda membuat search bar khusus di dalam Header (*Box Header*). Hindari pola desain *Grid/Cards* untuk data iterasi, prioritaskan DataTable penuh agar panjang teks acak tidak merusak proporsi UI layar Anda.
*   **Javascript Arg Escaping (Krusial!!)**: Saat Anda menginjeksi variabel *string* PHP ke dalam HTML tag `onclick='...'`, Anda **WAJIB MUTLAK** menggunakan proteksi `htmlspecialchars(json_encode((string)$var), ENT_QUOTES, "UTF-8")`. Jika tidak memakai ini, string yang mengandung 'Enter' atau 'Tanda Kutip' akan langsung memicu error *Uncaught SyntaxError* di sisi peramban pengguna.
*   **Card/Box Style**: Selalu gunakan kombinasi class modern minimalis: `box box-primary border-0 shadow-sm`.
*   **Icons**: Konsisten menggunakan ikon dari pustaka FontAwesome 4.x (contoh: `fa-plus`, `fa-pencil`, `fa-trash`).

## 4. Naming Conventions & Security (MANDATORY)
*   **Controllers**: Disimpan di `application/controllers/admin/`, huruf pertama KAPITAL (cth: `Products.php`).
*   **Models**: Menggunakan akhiran `_model.php`, huruf pertama KAPITAL (cth: `Product_model.php`).
*   **Views**: Disimpan di folder *lowercase* `application/views/admin/{module_name}/` (cth: `admin/products/index.php`).
*   **XSS Protection**: SAAT mengambil input POST, SELALU gunakan filter XSS bawaan CodeIgniter: `$this->input->post('field_name', TRUE)`.
*   **Database PK**: Setiap tabel HARUS memiliki kolom `id INT(11) AUTO_INCREMENT PRIMARY KEY` agar sinkron dengan fungsi global Recycle Bin.

## Workflow Steps:
1. Pahami kebutuhan field dan struktur tabel dari USER. Pastikan ada field audit: `created_at`, `updated_at`, dan `deleted_at`.
2. Hasilkan Skema SQL tabel baru dan berikan kepada USER untuk di-execute, atau execute mandiri jika diberikan izin.
3. Struktur file `{Module_name}_model.php` dengan fungsi standar CRUD yang mematuhi Soft Delete (kecuali method `hard_delete()`) dan perekaman `Log_model->write()`. Jangan lupa fungsikan filter keamanan jika ada Role Privacy.
4. Struktur file `{Module_name}.php` di folder `application/controllers/admin/`, mewarisi `Admin_Controller` dan filter `XSS`.
5. **Excel Upload (Opsional)**: Jika modul mendukung Upload Excel, fitur upload HARUS memproses data untuk ditampilkan terlebih dahulu di tabel pratinjau (Preview) pada Frontend untuk diverifikasi User. Jangan pernah langsung menyimpan (Direct Save). Simpan tabel menggunakan AJAX Batch Insert setelah data diverifikasi di Frontend. Gunakan library SheetJS (xlsx) di client-side untuk membaca file Excel.
6. Rancang view `index.php` di dalam folder `application/views/admin/{module_name}/` menggunakan sintaks jQuery AJAX, Modals, tabel modern, dan `App.toast/App.confirm` untuk interaktivitas UI yang elegan.
7. Test operasional CRUD modul melalui skrip JS yang telah dibuat.
8. Hubungkan modul ke Menu Management di Database jika diperlukan. 
    *   **Catatan Letak Navigasi**: Menu pengaturan mesin (Uses, Role, dll) diletakkan di **System Administration**. Menu daftar operasional SDM/Fisik (Jabatan, Are, Kategori) diletakkan sebagai *child* dari menu **Master Data**.
