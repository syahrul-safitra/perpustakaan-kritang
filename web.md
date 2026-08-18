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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin/dashboard', [DashboardController::class, 'index']);
// Jika ingin menjadikannya halaman utama bagian admin:
Route::get('/admin', [DashboardController::class, 'index']);

Route::resource('admin/buku', BukuController::class);

Route::resource('admin/kategori', KategoriController::class);

Route::resource('admin/anggota', AnggotaController::class);

Route::resource('admin/peminjaman', PeminjamanController::class);

Route::get('/admin/pengembalian', [PengembalianController::class, 'index']);
Route::put('/admin/pengembalian/{id}', [PengembalianController::class, 'update']);

Route::get('/admin/laporan', [LaporanController::class, 'index']);
Route::get('/admin/laporan/cetak', [LaporanController::class, 'cetakPdf']);



// -----------------------------------------------------------------

// Rute untuk OPAC (Katalog Publik / Siswa)
Route::get('/katalog', [KatalogController::class, 'index']);
// Jika ingin menjadikannya halaman utama saat aplikasi dibuka:
Route::get('/', [KatalogController::class, 'index']);
Route::get('/katalog/{id}', [KatalogController::class, 'show']); // <--- Tambahkan ini


Route::post('/logout', function() {
    return "Testing";
})->name('logout');


// Auth : 
// Halaman Login (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'login']);
});

// Proteksi Halaman Admin (Wajib Login)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/cetak', [LaporanController::class, 'cetakPdf']);
});


// Rute Guest Anggota (Belum Login)
Route::middleware('guest:anggota')->group(function () {
    Route::get('/anggota/login', [LoginAnggotaController::class, 'showLoginForm'])->name('anggota.login');
    Route::post('/anggota/login', [LoginAnggotaController::class, 'login']);
});

// Rute Protected Anggota (Wajib Login Guard Anggota)
Route::middleware('auth:anggota')->prefix('anggota')->group(function () {
    Route::post('/logout', [LoginAnggotaController::class, 'logout'])->name('anggota.logout');

    // Nanti akan diarahkan ke DashboardAnggotaController
    // Route::get('/dashboard', [DashboardAnggotaController::class, 'index']);
});


Route::middleware('auth:anggota')->prefix('anggota')->group(function () {
    Route::post('/logout', [LoginAnggotaController::class, 'logout'])->name('anggota.logout');
    
    // Dashboard Anggota
    Route::get('/dashboard', [DashboardAnggotaController::class, 'index'])->name('anggota.dashboard');
});

Route::get('/test1', function() {
    return auth()->user();
});

Route::get('/test2', function() {
    return auth()->guard('anggota')->user();
});