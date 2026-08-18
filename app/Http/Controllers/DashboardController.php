<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Ringkasan Kartu Atas
        $totalBuku      = Buku::sum('stok'); // Atau total jenis buku: Buku::count();
        $totalKoleksi   = Buku::count();
        $totalAnggota   = Anggota::where('status_aktif', 'aktif')->count();
        $totalDipinjam  = Peminjaman::where('status', 'dipinjam')->count();

        // 2. Data Tabel: 5 Peminjaman Terbaru yang Belum Kembali
        $peminjamanTerbaru = Peminjaman::with(['anggota', 'detailPeminjaman.buku'])
            ->where('status', 'dipinjam')
            ->latest()
            ->take(5)
            ->get();

        // 3. Statistik Kategori Buku untuk Grafik/Indikator Singkat
        $kategoris = Kategori::withCount('bukus')->get();

        return view('Admin.Dashboard.index', compact(
            'totalBuku', 
            'totalKoleksi', 
            'totalAnggota', 
            'totalDipinjam', 
            'peminjamanTerbaru',
            'kategoris'
        ));
    }
}