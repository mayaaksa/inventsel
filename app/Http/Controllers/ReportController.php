<?php
namespace App\Http\Controllers;

use App\Models\Borrowing;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BorrowingExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller {
    public function index() {
    $totalBarang = \App\Models\Product::sum('stok');
    
    $dikembalikan = \App\Models\BorrowingDetail::where('status_barang', 'Dikembalikan')->count();
    $dipinjam = \App\Models\BorrowingDetail::where('status_barang', 'Dipinjam')->count();
    $terlambat = \App\Models\BorrowingDetail::where('status_barang', 'Terlambat')->count();
    
    $chartData = [
        'labels' => ['Dikembalikan', 'Dipinjam', 'Terlambat'],
        'values' => [$dikembalikan, $dipinjam, $terlambat]
    ];

    $categories = \App\Models\Category::withSum('products', 'stok')->get();
    $catLabels = $categories->pluck('name'); // Sesuaikan nama kolom tabel
    $catValues = $categories->pluck('products_sum_stok');

    $popularItems = \App\Models\BorrowingDetail::join('products', 'borrowing_details.product_id', '=', 'products.id')
        ->select('products.nama_barang as name', \DB::raw('count(borrowing_details.product_id) as total'))
        ->groupBy('products.id', 'products.nama_barang') 
        ->orderBy('total', 'desc')
        ->limit(5)
        ->get();
        return view('reports.index', compact('totalBarang', 'dikembalikan', 'dipinjam', 'terlambat', 'chartData', 'popularItems', 'catLabels', 'catValues', 'categories'));
    }

// --- Untuk Export PDF ---
public function exportPdfBorrowing() {
    $borrowings = Borrowing::with(['details.product'])->get();
    $pdf = Pdf::loadView('reports.pdf-peminjaman', compact('borrowings'));
    return $pdf->download('laporan-peminjaman.pdf');
}

public function exportPdfProducts() {
    $products = \App\Models\Product::all();
    $pdf = Pdf::loadView('reports.pdf-products', compact('products'));
    return $pdf->download('data-barang.pdf');
}

// --- Untuk Export Excel ---
public function exportExcelBorrowing() {
    return Excel::download(new BorrowingExport, 'laporan-peminjaman.xlsx');
}

public function exportExcelProducts() {
    return Excel::download(new \App\Exports\ProductsExport, 'data-barang.xlsx');
}
}