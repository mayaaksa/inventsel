<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_index_passes_low_stock_and_category_counts_to_view(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Alat Tulis']);
        Product::create([
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Pensil',
            'category_id' => $category->id,
            'stok' => 3,
            'lokasi_penyimpanan' => 'Rak A',
            'kondisi_barang' => 'Baik',
        ]);

        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('lowStockCount', 1);
        $response->assertViewHas('categoriesCount', 1);
    }

    public function test_product_can_be_updated_via_controller(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Alat Tulis']);
        $product = Product::create([
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Pensil',
            'category_id' => $category->id,
            'stok' => 3,
            'lokasi_penyimpanan' => 'Rak A',
            'kondisi_barang' => 'Baik',
        ]);

        $response = $this->actingAs($user)->patch('/products/' . $product->id, [
            'code' => 'BRG-002',
            'name' => 'Pensil Baru',
            'category_id' => $category->id,
            'stok' => 8,
            'location' => 'Rak B',
            'condition' => 'Rusak Ringan',
        ]);

        $response->assertRedirect();
        $product->refresh();
        $this->assertSame('BRG-002', $product->kode_barang);
        $this->assertSame('Pensil Baru', $product->nama_barang);
        $this->assertSame(8, $product->stok);
        $this->assertSame('Rak B', $product->lokasi_penyimpanan);
        $this->assertSame('Rusak Ringan', $product->kondisi_barang);
    }

    public function test_product_can_be_deleted_via_controller(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Alat Tulis']);
        $product = Product::create([
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Pensil',
            'category_id' => $category->id,
            'stok' => 3,
            'lokasi_penyimpanan' => 'Rak A',
            'kondisi_barang' => 'Baik',
        ]);

        $response = $this->actingAs($user)->delete('/products/' . $product->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
