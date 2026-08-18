<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman utama menu laporan & filter.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'detailPeminjaman.buku']);

        // Filter berdasarkan tanggal jika dikirim dari form
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();

        return view('Admin.Laporan.index', compact('peminjamans'));
    }

    /**
     * Generate file PDF menggunakan DomPDF v3.1
     */
    public function cetakPdf(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'detailPeminjaman.buku']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $peminjamans = $query->latest()->get();

        $pdf = Pdf::loadView('Admin.Laporan.pdf', compact('peminjamans'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-Sirkulasi-Perpustakaan.pdf');
    }
}