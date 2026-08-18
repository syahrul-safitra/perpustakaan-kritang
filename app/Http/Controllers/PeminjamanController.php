<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan riwayat transaksi peminjaman.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'detailPeminjaman.buku']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('anggota', function ($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nomor_induk', 'like', "%{$search}%");
                  });
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();

        return view('Admin.Peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menampilkan form transaksi baru.
     */
    public function create()
    {
        // Hanya ambil anggota yang aktif
        $anggotas = Anggota::where('status_aktif', 'aktif')->get(['id', 'nomor_induk', 'nama_lengkap', 'jenis_anggota']);
        
        // Hanya ambil buku yang stoknya lebih dari 0
        $bukus = Buku::where('stok', '>', 0)->get(['id', 'judul', 'isbn', 'stok']);

        return view('Admin.Peminjaman.create', compact('anggotas', 'bukus'));
    }

    /**
     * Menyimpan transaksi peminjaman ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'            => 'required|exists:anggotas,id',
            'tanggal_pinjam'        => 'required|date',
            'tanggal_harus_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'buku_id'               => 'required|array|min:1',
            'buku_id.*'             => 'required|exists:bukus,id',
        ], [
            'anggota_id.required' => 'Pilih anggota terlebih dahulu.',
            'buku_id.required'    => 'Pilih minimal satu buku untuk dipinjam.',
        ]);

        // Cek apakah ada duplikasi buku dalam satu transaksi
        if (count($request->buku_id) !== count(array_unique($request->buku_id))) {
            return back()->withInput()->with('error', 'Terdapat judul buku yang sama. Pilih buku yang berbeda.');
        }

        try {
            DB::beginTransaction();

            // Generate Kode Transaksi (Format: TRX-YYYYMMDD-XXXX)
            $lastTrx = Peminjaman::whereDate('created_at', Carbon::today())->count();
            $kodeTransaksi = 'TRX-' . Carbon::today()->format('Ymd') . '-' . str_pad($lastTrx + 1, 4, '0', STR_PAD_LEFT);

            // 1. Simpan Header Transaksi
            $peminjaman = Peminjaman::create([
                'kode_transaksi'        => $kodeTransaksi,
                'anggota_id'            => $request->anggota_id,
                // Gunakan auth()->id() jika fitur login sudah jalan. 
                // Jika belum jalan/masih testing, gunakan fallback ke ID 1.
                'user_id'               => auth()->id() ?? 1, 
                'tanggal_pinjam'        => $request->tanggal_pinjam,
                'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
                'status'                => 'dipinjam',
                'total_denda'           => 0
            ]);

            // 2. Simpan Detail & Kurangi Stok Buku
            foreach ($request->buku_id as $buku_id) {
                $buku = Buku::lockForUpdate()->find($buku_id);

                if ($buku->stok < 1) {
                    throw new \Exception("Stok buku '{$buku->judul}' habis.");
                }

                // Insert detail
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id'       => $buku_id,
                    'jumlah'        => 1
                ]);

                // Kurangi stok
                $buku->decrement('stok', 1);
            }

            DB::commit();

            return redirect(url('/admin/peminjaman'))->with('success', 'Transaksi peminjaman berhasil diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }
}
