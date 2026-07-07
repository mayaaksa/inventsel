<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        $admin = User::firstOrCreate(['email' => 'admin@telkomsel.com'], ['name' => 'Administrator', 'password' => Hash::make('password')]);
        $budi = User::firstOrCreate(['email' => 'budi@telkomsel.com'], ['name' => 'Budi Santoso', 'password' => Hash::make('password')]);
        $siti = User::firstOrCreate(['email' => 'siti@telkomsel.com'], ['name' => 'Siti Aisyah', 'password' => Hash::make('password')]);
        $andi = User::firstOrCreate(['email' => 'andi@telkomsel.com'], ['name' => 'Andi Pratama', 'password' => Hash::make('password')]);

        // 2. Categories
        $katIT = Category::create(['name' => 'Elektronik & IT']);
        $katFoto = Category::create(['name' => 'Fotografi & Videografi']);
        $katATK = Category::create(['name' => 'Peralatan Kantor']);

        // 3. Products (stok awal dibuat lebih besar agar tersedia tetap banyak meski ada 221 unit dipinjam)
        $p1 = Product::firstOrCreate(['kode_barang' => 'IT-001'], ['nama_barang' => 'Laptop Lenovo ThinkPad T14', 'category_id' => $katIT->id, 'stok' => 140, 'lokasi_penyimpanan' => 'Ruang IT', 'kondisi_barang' => 'Baik']);
        $p2 = Product::firstOrCreate(['kode_barang' => 'IT-002'], ['nama_barang' => 'iPhone 14 Pro 256GB', 'category_id' => $katIT->id, 'stok' => 90, 'lokasi_penyimpanan' => 'Brankas IT', 'kondisi_barang' => 'Baik']);
        $p3 = Product::firstOrCreate(['kode_barang' => 'IT-003'], ['nama_barang' => 'MacBook Pro M2', 'category_id' => $katIT->id, 'stok' => 80, 'lokasi_penyimpanan' => 'Ruang IT', 'kondisi_barang' => 'Baik']);
        $p4 = Product::firstOrCreate(['kode_barang' => 'FV-001'], ['nama_barang' => 'Kamera Canon EOS R10', 'category_id' => $katFoto->id, 'stok' => 55, 'lokasi_penyimpanan' => 'Studio', 'kondisi_barang' => 'Baik']);
        $p5 = Product::firstOrCreate(['kode_barang' => 'FV-002'], ['nama_barang' => 'Tripod Manfrotto', 'category_id' => $katFoto->id, 'stok' => 65, 'lokasi_penyimpanan' => 'Studio', 'kondisi_barang' => 'Baik']);
        $p6 = Product::firstOrCreate(['kode_barang' => 'ATK-001'], ['nama_barang' => 'Projector Epson EB-X51', 'category_id' => $katATK->id, 'stok' => 60, 'lokasi_penyimpanan' => 'Ruang Meeting', 'kondisi_barang' => 'Baik']);

        // 4. Borrowing details hanya dibuat untuk borrowings yang sudah ada di tabel.
        // Tujuan: jangan menambah borrowings baru, cukup sesuaikan detail terhadap data yang sudah ada.
        $users = [$budi, $siti, $andi];
        $products = [$p1, $p2, $p3, $p4, $p5, $p6];

        $existingBorrowings = Borrowing::query()->get();

        if ($existingBorrowings->isEmpty()) {
            $borrow = Borrowing::create([
                'user_id' => $users[array_rand($users)]->id,
                'tanggal_pinjam' => now()->subDays(rand(1, 30))->toDateString(),
                'status' => 'Dipinjam',
            ]);

            BorrowingDetail::firstOrCreate(
                ['borrowing_id' => $borrow->id],
                [
                    'product_id' => $products[array_rand($products)]->id,
                    'jumlah' => 1,
                    'status_barang' => 'Dipinjam',
                ]
            );

            return;
        }

        foreach ($existingBorrowings as $borrow) {
            if ($borrow->details()->exists()) {
                continue;
            }

            $randStatus = rand(1, 100);
            if ($randStatus <= 60) {
                $statusBarang = 'Dikembalikan';
            } elseif ($randStatus <= 85) {
                $statusBarang = 'Dipinjam';
            } else {
                $statusBarang = 'Dipinjam';
            }

            BorrowingDetail::firstOrCreate(
                ['borrowing_id' => $borrow->id],
                [
                    'product_id' => $products[array_rand($products)]->id,
                    'jumlah' => rand(1, 2),
                    'status_barang' => $statusBarang,
                ]
            );
        }
    }
}