---
description: Membangun Dashboard Insera (Database db_master)
---

# Workflow: Membangun Dashboard Insera

Workflow ini bertugas men-generate secara otomatis sebuah Model, Controller, dan View AdminLTE untuk menampilkan halaman Dashboard Insera dengan mengambil data dari secondary database (`db_lama`) di tabel `insera`.

1. **Membuat Model Pembaca Data**
   Buat file `application/models/Dashboard_insera_model.php`.
   - Buat minimal satu method `get_stats()` yang menghitung:
     1. Total keseluruhan tiket Insera
     2. Total tiket Open (di mana `ticket_status` IN ('NEW', 'DRAFT', 'ANALYSIS', 'PENDING', 'BACKEND'))
     3. Total tiket Closed (selain status Open, misal `ticket_status` == 'CLOSED')
   - Buat method tambahan `get_pivot_by_category()` untuk menyiapkan data Pivot, yang dipisah secara spesifik antara tiket **OPEN** dan **CLOSED**:
     1. Ambil seluruh `scrape_category` yang unik.
     2. Lakukan pengelompokan (GROUP BY) berdasarkan `work_zone` untuk masing-masing kategori.
     3. **Untuk tiket OPEN**: Hitung distribusi tiket berdasarkan durasi/aging (dari `reported_date` ke waktu saat ini) ke dalam *bucket*: `< 1 jam`, `1-2 jam`, `2-3 jam`, `3-6 jam`, `6-12 jam`, `12-36 jam`, `36-72 jam`, dan `> 72 jam`.
     4. **Untuk tiket CLOSED**: Hitung distribusi tiket berdasarkan durasi yang sama (misalnya dari `reported_date` hingga `resolve_date`) dengan pengelompokan *bucket* yang sama.
   - Buat method `get_detail_tickets($params)`:
     1. Terima parameter `scrape_category`, `work_zone`, `status_type`, dan `bucket`.
     2. Jika `work_zone` bernilai `'ALL'`, jangan sertakan filter `work_zone` di query (mendukung drill-down Grand Total).
     3. Return detail data tiket untuk ditampilkan di Modal.

2. **Membuat Controller Admin**
   Buat file `application/controllers/admin/Dashboard_insera.php`.
   - Controller ini *extends* `Admin_Controller`.
   - Di `__construct()`, load `Dashboard_insera_model`.
   - Di method `index()`, ambil hasil dari `get_stats()` ke variabel `$data` lalu parsing ke View dengan menulis: `$this->template->load('admin/dashboard/insera_index', $data);`.
   - Tambahkan method `ajax_get_detail_tickets()` sebagai *endpoint AJAX*.

3. **Membuat Halaman View Dashboard**
   Buat file `application/views/admin/dashboard/insera_index.php`.
   - Tampilkan ringkasan statistik global menggunakan 3 blok *info-box* (`bg-aqua`, `bg-red`, `bg-green`).
   - Gunakan **Nav-Tabs (Bootstrap)**: **Distribusi Tiket OPEN** dan **Distribusi Tiket CLOSED**.
   - Di dalam Tab, buat **Tabel Pivot Dinamis** per kategori.
   - Susun struktur **Header Tabel 2 Tingkat** profesional:
     - Baris 1: Kolom `Workzone` (rowspan 2) | Kolom `DURASI` (colspan 8) | Kolom `Total` (rowspan 2).
     - Baris 2: `< 1 jam` | `1-2 Jam` | ... | `> 72 jam`.
   - **Desain Estetik Mac Tahoe Dark Mode:**
     - Terapkan skema warna **Dark Mode** secara global pada halaman dashboard (Latar belakang gelap `#1c1c1e`).
     - Gunakan kartu/kotak dengan sudut melengkung (`border-radius: 12px`) dan bayangan lembut.
     - Nav-Tabs harus mendukung transparansi dan efek *blur* (*backdrop-filter: blur*).
     - **Tabel Pivot Dark Theme:**
       - Header dan Footer tabel menggunakan warna hitam pekat atau biru gelap.
       - Teks di dalam tabel harus berwarna putih atau abu-abu terang.
       - Hilangkan penggunaan warna latar belakang sel yang bersifat statis (putih/abu-abu terang).
     - **Elemen Aksi (Tombol/Link):**
       - Gunakan warna aksen Apple (Red `#ff453a`, Green `#32d74b`, Blue `#0a84ff`) untuk tombol dan link drill-down.
   - **Implementasi Grand Total Footer:**
     - Tambahkan `tfoot` yang mengakumulasi total tiap kolom durasi dan **Grand Total Keseluruhan**.
   - **Tabel Dapat Diklik (Drill-down):**
     - Angka di `tbody` (per workzone) dan di `tfoot` (per kategori) harus bisa **diklik**.
     - Jika Grand Total diklik, kirim filter `work_zone = 'ALL'`.
   - **Pop-Up Modal Detail AJAX:**
     - Pastikan Modal juga mengikuti tema Dark Mode dengan latar belakang gelap dan rincian tabel yang kontras.
