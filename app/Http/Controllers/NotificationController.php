<?php

namespace App\Http\Controllers;

use App\Models\Product;

class NotificationController extends Controller
{
    public function index()
    {
        // Ambil barang yang stoknya <= 5 (atau angka sesuai kebutuhanmu)
        $lowStockProducts = Product::where('stok', '<=', 5)->get();
        return view('notifications.index', compact('lowStockProducts'));
    }
}