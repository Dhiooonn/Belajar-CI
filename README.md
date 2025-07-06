# 🛒 Toko Online - CodeIgniter 4

Proyek ini adalah platform toko online modern yang dibangun menggunakan [CodeIgniter 4](https://codeigniter.com/). Sistem ini menyediakan fungsionalitas lengkap seperti manajemen produk, keranjang belanja, checkout dengan ongkos kirim, diskon harian, API transaksi, serta dashboard laporan berbasis web service.

---

## 📑 Daftar Isi

- [✨ Fitur](#-fitur)
- [⚙️ Persyaratan Sistem](#️-persyaratan-sistem)
- [🚀 Instalasi](#-instalasi)
- [📁 Struktur Proyek](#-struktur-proyek)
- [🔌 Web Service / API](#-web-service--api)

---

## ✨ Fitur

### 🎯 Fitur Umum
- ✅ Katalog produk + pencarian
- ✅ Keranjang belanja (CRUD)
- ✅ Checkout dengan ongkos kirim (RajaOngkir)
- ✅ Diskon harian otomatis saat login
- ✅ Riwayat transaksi

### 🔐 Sistem Autentikasi
- Login/Register
- Role-based session (admin/user)

### 🛒 Panel Admin
- Manajemen Produk (CRUD)
- Manajemen Kategori Produk
- Manajemen Diskon (CRUD)
- Export laporan transaksi ke PDF

### 📊 Dashboard API
- Dashboard laporan transaksi via web service `API`
- Menampilkan total item per transaksi
- Filter transaksi berdasarkan status selesai

---

## ⚙️ Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL
- XAMPP / Laragon / Web server

---

## 🚀 Instalasi

1. **Clone repository**
   ```bash
   git clone [URL repository]
   cd belajar-ci-tugas


1. **Clone repository**
   ```bash
   git clone [URL repository]
   cd belajar-ci-tugas


1. **Clone repository ini**
   ```bash
   git clone [URL repository]
   cd belajar-ci-tugas
   ```
2. **Install dependensi**
   ```bash
   composer install
   ```
3. **Konfigurasi database**

   - Start module Apache dan MySQL pada XAMPP
   - Buat database **db_ci4** di phpmyadmin.
   - copy file .env dari tutorial https://www.notion.so/april-ns/Codeigniter4-Migration-dan-Seeding-045ffe5f44904e5c88633b2deae724d2

4. **Jalankan migrasi database**
   ```bash
   php spark migrate
   ```
5. **Seeder data**
   ```bash
   php spark db:seed ProductSeeder
   ```
   ```bash
   php spark db:seed UserSeeder
   ```
6. **Jalankan server**
   ```bash
   php spark serve
   ```
7. **Akses aplikasi**
   Buka browser dan akses `http://localhost:8080` untuk melihat aplikasi.

## Struktur Proyek

Proyek menggunakan struktur MVC CodeIgniter 4:

- app/Controllers - Logika aplikasi dan penanganan request
  - AuthController.php - Autentikasi pengguna
  - ProdukController.php - Manajemen produk
  - TransaksiController.php - Proses transaksi
  - DiskonCOntroller.php - untuk proses pemberian Diskon saat checkout
- app/Models - Model untuk interaksi database
  - ProductModel.php - Model produk
  - UserModel.php - Model pengguna
- app/Views - Template dan komponen UI
  - v_produk.php - Tampilan produk
  - v_keranjang.php - Halaman keranjang
- public/img - Gambar produk dan aset
- public/NiceAdmin - Template admin
