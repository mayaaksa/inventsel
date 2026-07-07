InvenTsel - Telkomsel Inventory Management System

InvenTsel adalah sistem informasi inventaris berbasis web yang dikembangkan menggunakan Laravel. Sistem ini digunakan untuk mengelola data barang, kategori, peminjaman, pengembalian, serta pembuatan laporan inventaris secara efisien.

## Teknologi yang Digunakan
- Laravel 12
- PHP 8.2+
- MySQL
- Tailwind CSS
- Alpine.js
- Chart.js
- Laravel Breeze
- Vite
- API DiceBear (Avatar Default)

## Cara Instalasi
1. Clone repository ini:
   `git clone https://github.com/mayaaksa/inventsel.git`
2. Masuk ke folder proyek:
   `cd inventsel`
3. Copy file environment:
   `cp .env.example .env`
4. Install dependencies:
   `composer install`
   `npm install`
5. Generate key:
   `php artisan key:generate`
6. Konfigurasi database di file `.env`, lalu jalankan migrasi:
   `php artisan migrate`

## Cara Menjalankan Project
1. Jalankan server lokal:
   `php artisan serve`
2. Jalankan watcher untuk Tailwind:
   `npm run dev`
3. Buka browser di: `http://localhost:8000`

## Akun Login Testing
- Role: Admin
Email: admin@telkomsel.com
Password: password

- Role: Manager
Email: manager@telkomsel.com
Password: password

- Role: Staff
Email: budi@telkomsel.com, siti@telkomsel.com, andi@telkomsel.com
Password: password

## Fitur
- Login/Register
- Dashboard
- Manajemen Barang
- Manajemen Kategori
- Manajemen Peminjaman
- Riwayat Peminjaman
- Laporan Inventaris
- Pencarian Data
- Grafik Statistik
- Upload Gambar Bukti Peminjaman
- Export PDF Laporan Peminjaman dan Barang
- Export Excel Laporan Peminjaman dan Barang
- Notifikasi Stok Menipis


## Struktur Folder
- app/
- bootstrap/
- config/
- database/
- node_modules/
- public/
- resources/
- routes/
- storage/
- tests/
