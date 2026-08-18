<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginAnggotaController;
use App\Http\Controllers\DashboardAnggotaController;

use App\Http\Middleware\CekStatusPustakawan;
use App\Http\Middleware\CekStatusAnggota;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIC / GUEST ROUTES (OPAC & KATALOG BUKU)
// =========================================================================
Route::get('/', [KatalogController::class, 'index']);
Route::get('/katalog', [KatalogController::class, 'index']);
Route::get('/katalog/{id}', [KatalogController::class, 'show']);


// =========================================================================
// 2. PORTAL PUSTAKAWAN / ADMIN (Guard Web)
// =========================================================================
// Guest Admin (Hanya bisa dibuka jika BELUM login admin)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'login']);
});

// Protected Admin (Wajib Login Pustakawan via CekStatusPustakawan)
Route::middleware(CekStatusPustakawan::class)->prefix('admin')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Resource Management
    Route::resource('buku', BukuController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    
    // Transaksi Pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index']);
    Route::put('/pengembalian/{id}', [PengembalianController::class, 'update']);
    
    // Modul Laporan & Cetak PDF
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/cetak', [LaporanController::class, 'cetakPdf']);
});


// =========================================================================
// 3. PORTAL ANGGOTA / SISWA & GURU (Guard Anggota)
// =========================================================================
// Guest Anggota (Hanya bisa dibuka jika BELUM login anggota)
Route::middleware('guest:anggota')->group(function () {
    Route::get('/anggota/login', [LoginAnggotaController::class, 'showLoginForm'])->name('anggota.login');
    Route::post('/anggota/login', [LoginAnggotaController::class, 'login']);
});

// Protected Anggota (Wajib Login Anggota via CekStatusAnggota)
Route::middleware(CekStatusAnggota::class)->prefix('anggota')->group(function () {
    Route::post('/logout', [LoginAnggotaController::class, 'logout'])->name('anggota.logout');
    Route::get('/dashboard', [DashboardAnggotaController::class, 'index'])->name('anggota.dashboard');
});


// =========================================================================
// 4. TESTING ROUTES (Bisa dihapus jika sudah tidak digunakan)
// =========================================================================
Route::get('/test1', function() {
    return auth()->user();
});

Route::get('/test2', function() {
    return auth()->guard('anggota')->user();
});