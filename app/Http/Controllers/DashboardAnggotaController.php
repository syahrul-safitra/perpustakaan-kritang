<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAnggotaController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk anggota.
     */
    public function index()
    {
        $anggotaId = Auth::guard('anggota')->id();

        // Query transaksi peminjaman milik anggota yang sedang login
        $queryBase = Peminjaman::where('anggota_id', $anggotaId);

        // Statistic Cards
        $totalSedangDipinjam = (clone $queryBase)->where('status', 'dipinjam')->count();
        $totalSelesai        = (clone $queryBase)->where('status', 'dikembalikan')->count();
        $totalDenda          = (clone $queryBase)->where('status', 'dikembalikan')->sum('total_denda');

        // Mengambil daftar peminjaman terbaru beserta detail buku
        $peminjamans = (clone $queryBase)
                        ->with(['detailPeminjaman.buku'])
                        ->latest()
                        ->paginate(6);

        return view('Siswa.Dashboard.index', compact(
            'totalSedangDipinjam',
            'totalSelesai',
            'totalDenda',
            'peminjamans'
        ));
    }
}