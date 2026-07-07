<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController, CategoryController, ProductController, 
    BorrowingController, ReportController, ProfileController, AdminController
};
use App\Http\Middleware\CheckRole;

// --- Halaman Publik ---
Route::get('/', function () { return view('welcome'); });

// --- Rute Autentikasi (Sudah termasuk login/register dari auth.php) ---
require __DIR__.'/auth.php';

// --- Rute yang Memerlukan Login ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menu khusus Staff, Manager, & Admin
    Route::middleware('checkrole:staff,manager,admin')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('borrowings', BorrowingController::class);
        Route::post('/borrowings/upload-image', [BorrowingController::class, 'uploadImage'])->name('borrowings.upload-image');
        Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/{id}', [BorrowingController::class, 'show'])->name('peminjaman.show');
    });

    // Menu khusus Manager & Admin
    Route::middleware('checkrole:manager,admin')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/pdf/borrowing', [ReportController::class, 'exportPdfBorrowing'])->name('reports.pdf');
        Route::get('/reports/pdf/products', [ReportController::class, 'exportPdfProducts'])->name('products.export.pdf');
        Route::get('/reports/excel/borrowing', [ReportController::class, 'exportExcelBorrowing'])->name('reports.excel');
        Route::get('/reports/excel/products', [ReportController::class, 'exportExcelProducts'])->name('products.export.excel');
    });
    
    // Notifikasi (Semua yang login bisa akses)
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
});