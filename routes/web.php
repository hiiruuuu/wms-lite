<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockMutationController;
use App\Http\Controllers\ReportController;
use App\Models\Product;

// Route Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});

// Route yang membutuhkan Login
Route::middleware(['auth'])->group(function () {
    
    // Dashboard & Restock Alert
    Route::get('/dashboard', function () {
        $lowStockProducts = Product::lowStock()->get();
        return view('dashboard', compact('lowStockProducts'));
    })->name('dashboard');

    // Mutasi Stok (Staff & Admin)
    Route::middleware(['role:admin|warehouse_staff'])->group(function () {
        Route::get('/mutations', [StockMutationController::class, 'index'])->name('mutations.index');
        Route::post('/mutations', [StockMutationController::class, 'store'])->name('mutations.store');
    });

    // Laporan PDF (Manager & Admin)
    Route::middleware(['role:admin|manager'])->group(function () {
        Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    });
});
