<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PengembalianController extends Controller
{
    /**
     * Menampilkan daftar buku yang sedang dipinjam (belum dikembalikan).
     */
    public function index(Request $request)
    {
        // Hanya ambil data dengan status 'dipinjam'
        $query = Peminjaman::with(['anggota', 'detailPeminjaman.buku'])->where('status', 'dipinjam');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('anggota', function ($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%")
                         ->orWhere('nomor_induk', 'like', "%{$search}%");
                  });
            });
        }

        // Urutkan berdasarkan tanggal jatuh tempo terdekat atau yang sudah lewat
        $peminjamans = $query->oldest('tanggal_harus_kembali')->paginate(10)->withQueryString();

        // Menyuntikkan perhitungan denda sementara dan hari keterlambatan ke setiap baris data
        $hariIni = Carbon::now()->startOfDay();
        foreach ($peminjamans as $trx) {
            $tglHarusKembali = Carbon::parse($trx->tanggal_harus_kembali)->startOfDay();
            
            if ($hariIni->greaterThan($tglHarusKembali)) {
                $trx->hari_terlambat = $tglHarusKembali->diffInDays($hariIni);
                $trx->denda_sementara = $trx->hari_terlambat * Peminjaman::TARIF_DENDA_PER_HARI; // Misal Rp 1.000 / hari
            } else {
                $trx->hari_terlambat = 0;
                $trx->denda_sementara = 0;
            }
        }

        return view('Admin.Pengembalian.index', compact('peminjamans'));
    }

    /**
     * Memproses pengembalian buku (Update Status, Denda, dan Stok).
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Gunakan lockForUpdate agar tidak terjadi race condition / klik ganda
            $peminjaman = Peminjaman::with('detailPeminjaman')->lockForUpdate()->findOrFail($id);

            // Validasi jika buku ternyata sudah dikembalikan
            if ($peminjaman->status !== 'dipinjam') {
                throw new \Exception('Transaksi ini sudah diproses sebelumnya.');
            }

            // 1. Kalkulasi denda dan catat tanggal kembali aktual
            $peminjaman->tanggal_kembali = Carbon::now()->toDateString();
            $dendaFinal = $peminjaman->hitungDendaOtomatis();

            // 2. Perbarui data transaksi
            $peminjaman->total_denda = $dendaFinal;
            $peminjaman->status = 'dikembalikan';
            $peminjaman->save();

            // 3. Kembalikan stok buku
            foreach ($peminjaman->detailPeminjaman as $detail) {
                Buku::where('id', $detail->buku_id)->increment('stok', $detail->jumlah);
            }

            DB::commit();

            // Buat pesan notifikasi dinamis
            $pesan = 'Buku berhasil dikembalikan.';
            if ($dendaFinal > 0) {
                $pesan .= ' Denda sebesar Rp ' . number_format($dendaFinal, 0, ',', '.') . ' telah dikenakan.';
            }

            return redirect(url('/admin/pengembalian'))->with('success', $pesan);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }
}
