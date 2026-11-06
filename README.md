# 📦 WMS-Lite (Warehouse Management System)

WMS-Lite adalah aplikasi sistem manajemen gudang (*Warehouse Management System*) berskala ringan yang dirancang khusus untuk mengelola inventaris, mutasi stok barang masuk/keluar, dan sistem peringatan stok kritis secara aman, akurat, dan real-time.

Proyek ini dibangun menggunakan **Laravel 13** dengan penekanan khusus pada integritas backend (*atomic transactions*), pengelolaan hak akses berjenjang, serta antarmuka modern berbasis **Tailwind CSS**.

---

## 🚀 Fitur Utama

1. **Atomic Stock Mutation (Anti-Race Condition)**
   - Menggunakan layanan berbasis `DB::transaction` dan `lockForUpdate()` untuk memastikan mutasi stok barang masuk (IN) dan keluar (OUT) aman dari konflik transaksi bersamaan.
2. **Role-Based Access Control (RBAC)**
   - Integrasi **Spatie Permission** dengan pembagian peran yang jelas:
     - **Admin:** Memiliki akses penuh ke seluruh fitur sistem.
     - **Warehouse Staff:** Bertugas mengelola mutasi stok barang.
     - **Manager:** Berwenang mengunduh laporan rekapitulasi gudang.
3. **Restock Alert (Peringatan Stok Kritis)**
   - Widget pintar di dashboard yang secara otomatis mendeteksi produk dengan stok di bawah batas minimum (*min_stock*).
4. **Export Laporan PDF**
   - Fitur rekapitulasi data menggunakan **DomPDF** yang dibatasi hak aksesnya khusus untuk peran Manager dan Admin.
5. **Dashboard Interaktif & Modern**
   - Dilengkapi *Metric Cards* statistik ringkasan gudang dan navigasi cepat yang elegan menggunakan **Tailwind CSS**.

---

## 🛠️ Tech Stack

- **Framework:** Laravel 13
- **Database:** MySQL
- **Authorization:** Spatie Laravel Permission (RBAC)
- **PDF Generation:** Barryvdh DomPDF
- **Styling:** Tailwind CSS (via CDN)
- **Environment:** Laragon / PHP 8.4 / Composer

---

## 🔑 Akun Demo (Default Seeders)

Gunakan akun berikut untuk menguji tingkat hak akses (*RBAC*):

* **Admin:** `admin@wms.com` / `password123`
* **Staff Gudang:** `staff@wms.com` / `password123`
* **Manager:** `manager@wms.com` / `password123`