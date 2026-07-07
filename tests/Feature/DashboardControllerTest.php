<?php

namespace Tests\Feature;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_stock_based_borrowing_stats(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Test Category',
            'description' => 'Category for dashboard test',
        ]);
        $product = Product::create([
            'kode_barang' => 'TEST-001',
            'nama_barang' => 'Laptop',
            'category_id' => $category->id,
            'stok' => 10,
            'lokasi_penyimpanan' => 'A1',
            'kondisi_barang' => 'Baik',
        ]);

        $activeBorrowing = Borrowing::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->subDay()->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'Dipinjam',
        ]);

        BorrowingDetail::create([
            'borrowing_id' => $activeBorrowing->id,
            'product_id' => $product->id,
            'jumlah' => 2,
            'status_barang' => 'Dipinjam',
        ]);

        $lateBorrowing = Borrowing::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->subDays(2)->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'Terlambat',
        ]);

        BorrowingDetail::create([
            'borrowing_id' => $lateBorrowing->id,
            'product_id' => $product->id,
            'jumlah' => 1,
            'status_barang' => 'Dipinjam',
        ]);

        $returnedBorrowing = Borrowing::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->subDays(3)->toDateString(),
            'tanggal_kembali' => now()->toDateString(),
            'status' => 'Dikembalikan',
        ]);

        BorrowingDetail::create([
            'borrowing_id' => $returnedBorrowing->id,
            'product_id' => $product->id,
            'jumlah' => 5,
            'status_barang' => 'Dikembalikan',
        ]);

        $todayBorrowing = Borrowing::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'Dipinjam',
        ]);

        BorrowingDetail::create([
            'borrowing_id' => $todayBorrowing->id,
            'product_id' => $product->id,
            'jumlah' => 1,
            'status_barang' => 'Dipinjam',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertViewHas('barangDipinjam', 4);
        $response->assertViewHas('peminjamanHariIni', 1);
        $response->assertViewHas('sedangDipinjam', 3);
        $response->assertViewHas('terlambat', 1);
        $response->assertViewHas('dikembalikan', 1);
    }
}
