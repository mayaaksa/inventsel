<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = (int) Product::sum('stok');

        $activeBorrowingIds = Borrowing::query()
        ->whereIn('status', ['Dipinjam', 'Terlambat'])
        ->pluck('id');

        $barangDipinjam = BorrowingDetail::join('borrowings', 'borrowing_details.borrowing_id', '=', 'borrowings.id')
        ->whereIn('borrowings.status', ['Dipinjam', 'Terlambat'])
        ->sum('jumlah');

        $barangTersedia = max(0, $totalBarang - $barangDipinjam);
        $peminjamanHariIni = (int) Borrowing::query()
            ->whereDate('tanggal_pinjam', Carbon::today())
            ->count();

$chartLabels = [];
    $chartData = [];

    $now = \Carbon\Carbon::now();

    for ($i = 5; $i >= 0; $i--) {
        $month = $now->copy()->subMonths($i);
        $chartLabels[] = $month->format('M'); // 'Jul', 'Jun', 'May', 'Apr', 'Mar', 'Feb'

        $count = Borrowing::query()
            ->whereYear('tanggal_pinjam', $month->year)
            ->whereMonth('tanggal_pinjam', $month->month)
            ->count();
        
        $chartData[] = (int) $count;
        }

    $sedangDipinjam = (int) Borrowing::where('status', 'Dipinjam')->count();
    $dikembalikan = (int) Borrowing::where('status', 'Dikembalikan')->count();
    $terlambat = (int) Borrowing::where('status', 'Terlambat')->count();

    $recentBorrowings = Borrowing::with(['user', 'details.product'])
        ->latest()
        ->take(4)
        ->get();

    return view('dashboard.index', compact(
        'totalBarang',
        'barangDipinjam',
        'barangTersedia',
        'peminjamanHariIni',
        'chartData',
        'chartLabels', // Kirim juga labelnya agar chart tidak bingung
        'sedangDipinjam',
        'dikembalikan',
        'terlambat',
        'recentBorrowings'
    ));
    }
}
