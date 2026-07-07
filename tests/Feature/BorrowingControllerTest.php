<?php

namespace Tests\Feature;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_uses_existing_borrowings_and_creates_details_without_adding_new_borrowings(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Alat Tulis']);
        $product = Product::create([
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Laptop',
            'category_id' => $category->id,
            'stok' => 3,
            'lokasi_penyimpanan' => 'Rak A',
            'kondisi_barang' => 'Baik',
        ]);

        $borrowing = Borrowing::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'Dipinjam',
        ]);

        $this->artisan('db:seed', ['--force' => true]);

        $this->assertDatabaseCount('borrowings', 1);
        $this->assertDatabaseHas('borrowing_details', ['borrowing_id' => $borrowing->id]);
    }

    public function test_borrowing_page_shows_product_name_from_borrowing_details(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Alat Tulis']);
        $product = Product::create([
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Laptop',
            'category_id' => $category->id,
            'stok' => 3,
            'lokasi_penyimpanan' => 'Rak A',
            'kondisi_barang' => 'Baik',
        ]);

        $borrowing = Borrowing::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'Dipinjam',
        ]);

        BorrowingDetail::create([
            'borrowing_id' => $borrowing->id,
            'product_id' => $product->id,
            'jumlah' => 1,
            'status_barang' => 'Dipinjam',
        ]);

        $response = $this->actingAs($user)->get('/borrowings');

        $response->assertStatus(200);
        $response->assertSee($product->nama_barang);
        $response->assertDontSee('Barang Dihapus');
    }

    public function test_borrowing_page_can_filter_and_sort_records(): void
    {
        $user = User::factory()->create();
        $older = Borrowing::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->subDays(10)->toDateString(),
            'status' => 'Dipinjam',
        ]);
        $newer = Borrowing::create([
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'Terlambat',
        ]);

        $response = $this->actingAs($user)->get('/borrowings?view=active&search=terlambat&sort=oldest');

        $response->assertStatus(200);
        $response->assertSee('Terlambat');
        $response->assertDontSee('Tidak ada data peminjaman pada kategori ini.');
    }

    public function test_borrowing_can_be_created_and_deleted_via_controller(): void
    {
        $user = User::factory()->create();

        $createResponse = $this->actingAs($user)->post('/borrowings', [
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'Dipinjam',
        ]);

        $createResponse->assertRedirect(route('borrowings.index'));
        $this->assertDatabaseHas('borrowings', ['user_id' => $user->id, 'status' => 'Dipinjam']);

        $borrowing = Borrowing::latest()->first();
        $deleteResponse = $this->actingAs($user)->delete('/borrowings/' . $borrowing->id);

        $deleteResponse->assertRedirect(route('borrowings.index'));
        $this->assertDatabaseMissing('borrowings', ['id' => $borrowing->id]);
    }
}
