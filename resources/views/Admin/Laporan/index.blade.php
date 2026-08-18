@extends('Admin.Layouts.main')

@section('title', 'Laporan Sirkulasi - Admin Perpustakaan')
@section('breadcrumb_active', 'Laporan')

@section('content')

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-black text-base-content tracking-tight">Laporan Rekapitulasi Sirkulasi</h1>
        <p class="text-xs md:text-sm text-base-content/60 mt-1">
            Filter dan cetak rekapitulasi transaksi peminjaman serta pengembalian buku perpustakaan.
        </p>
    </div>
</div>

<!-- Card Filter Rentang Tanggal & Tombol Aksi -->
<div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-5 md:p-6 mb-8">
    <form action="{{ url('/admin/laporan') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
        
        <!-- Input Tanggal Mulai -->
        <div class="form-control md:col-span-4">
            <label class="label py-1">
                <span class="label-text font-semibold text-xs text-base-content/70">Tanggal Mulai</span>
            </label>
            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="input input-bordered input-md w-full rounded-xl focus:outline-none focus:border-primary text-xs" />
        </div>

        <!-- Input Tanggal Selesai -->
        <div class="form-control md:col-span-4">
            <label class="label py-1">
                <span class="label-text font-semibold text-xs text-base-content/70">Tanggal Selesai</span>
            </label>
            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="input input-bordered input-md w-full rounded-xl focus:outline-none focus:border-primary text-xs" />
        </div>

        <!-- Tombol Filter & Reset -->
        <div class="md:col-span-4 flex items-center gap-2">
            <button type="submit" class="btn btn-primary btn-md rounded-xl text-xs flex-1 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                Filter Data
            </button>

            @if(request('tanggal_mulai') || request('tanggal_selesai'))
                <a href="{{ url('/admin/laporan') }}" class="btn btn-ghost btn-md rounded-xl text-xs border border-base-300">
                    Reset
                </a>
            @endif

            <!-- Tombol Cetak PDF -->
            <a href="{{ url('/admin/laporan/cetak?' . http_build_query(request()->all())) }}" target="_blank" class="btn btn-error btn-md text-white rounded-xl text-xs gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Cetak PDF
            </a>
        </div>
    </form>
</div>

<!-- Tabel Pratinjau Data Laporan -->
<div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl overflow-hidden">
    <div class="card-body p-5 md:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-base text-base-content">Pratinjau Data Rekapitulasi</h2>
            <span class="text-xs text-base-content/50">Total Data: <strong>{{ $peminjamans->total() }}</strong> Transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-left">
                <thead>
                    <tr class="bg-base-200/50 text-base-content/70 text-xs font-semibold uppercase tracking-wider border-b border-base-200">
                        <th class="rounded-l-xl py-3">No</th>
                        <th>Kode TRX & Peminjam</th>
                        <th>Buku Dipinjam</th>
                        <th class="text-center">Tgl Pinjam / Kembali</th>
                        <th class="rounded-r-xl text-center">Status / Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/60 text-sm">
                    @forelse ($peminjamans as $index => $trx)
                        <tr class="hover:bg-base-200/30 transition-colors">
                            <td class="font-semibold text-xs py-3">{{ $peminjamans->firstItem() + $index }}</td>
                            <td>
                                <span class="font-mono text-xs font-bold text-primary">{{ $trx->kode_transaksi }}</span>
                                <div class="font-semibold text-base-content mt-0.5">{{ $trx->anggota->nama_lengkap ?? '-' }}</div>
                                <span class="text-[10px] text-base-content/50 uppercase font-bold">{{ $trx->anggota->jenis_anggota ?? '-' }}</span>
                            </td>
                            <td>
                                <ul class="list-disc list-inside text-xs text-base-content/70">
                                    @foreach($trx->detailPeminjaman as $detail)
                                        <li class="truncate max-w-[240px]">{{ $detail->buku->judul ?? '-' }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center text-xs">
                                <div>{{ date('d/m/Y', strtotime($trx->tanggal_pinjam)) }}</div>
                                <div class="text-error font-semibold mt-0.5">s/d {{ date('d/m/Y', strtotime($trx->tanggal_harus_kembali)) }}</div>
                            </td>
                            <td class="text-center">
                                @if($trx->status == 'dipinjam')
                                    <span class="badge badge-warning badge-sm font-bold">DIPINJAM</span>
                                @elseif($trx->status == 'dikembalikan')
                                    <span class="badge badge-success badge-sm font-bold text-white">SELESAI</span>
                                    @if($trx->total_denda > 0)
                                        <div class="text-[10px] text-error font-bold mt-1">Rp {{ number_format($trx->total_denda, 0, ',', '.') }}</div>
                                    @endif
                                @else
                                    <span class="badge badge-error badge-sm font-bold text-white">TERLAMBAT</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-xs text-base-content/50">
                                Tidak ada data transaksi peminjaman yang cocok dengan rentang tanggal tersebut.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $peminjamans->links() }}
        </div>
    </div>
</div>

@endsection