<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'newest');

        $query = Category::withCount('products');

        if ($sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $categories = $query->paginate(8);
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories|max:255']);
        Category::create($request->all());
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|unique:categories,name,' . $category->id]);
        $category->update($request->all());
        return back()->with('success', 'Kategori diupdate!');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Gagal: Kategori memiliki ' . $category->products()->count() . ' barang.');
        }
        $category->delete();
        return back()->with('success', 'Kategori dihapus!');


        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki barang!');
        }

        $category->delete();
        return back()->with('success', 'Kategori dihapus!');
    }
}