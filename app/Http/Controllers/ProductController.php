<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_barang', 'like', '%' . $search . '%')
                ->orWhere('kode_barang', 'like', '%' . $search . '%');
        }

        $totalStock = Product::sum('stok');
        $lowStockCount = Product::where('stok', '<', 5)->count();
        $totalItems = Product::count();
        $categories = Category::orderBy('name')->get();

    if ($request->filled('category')) {
    $query->where('category_id', $request->category);
}
    if ($request->sort == 'newest') $query->latest();
    if ($request->sort == 'oldest') $query->oldest();

        $products = $query->paginate(8)->through(function ($product) {
            return [
                'id' => $product->id,
                'code' => $product->kode_barang,
                'name' => $product->name,
                'stok' => $product->stok,
                'location' => $product->lokasi_penyimpanan,
                'condition' => $product->condition,
                'category_id' => $product->category_id,
                'category_name' => $product->category->name ?? '-',
                'updated_at' => $product->updated_at
                    ? $product->updated_at->format('d M Y, H:i')
                    : 'Belum pernah diupdate'
            ];
        });

        return view('products.index', compact('products', 'totalStock', 'lowStockCount', 'totalItems', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer',
            'location' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
        ]);

        Product::create($this->mapProductPayload($request));

        return back()->with('success', 'Barang berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer',
            'location' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update($this->mapProductPayload($request));

        return back()->with('success', 'Barang berhasil diupdate!');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Barang dihapus!');
    }

    private function mapProductPayload(Request $request): array
    {
        return [
            'kode_barang' => $request->input('code'),
            'nama_barang' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'stok' => $request->input('stok'),
            'lokasi_penyimpanan' => $request->input('location'),
            'kondisi_barang' => $request->input('condition', 'Baik'),
        ];
    }
}