@extends('Admin.Layouts.main')

@section('title', 'Transaksi Peminjaman - Admin')
@section('breadcrumb_active', 'Peminjaman Buku')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content tracking-tight">Data Peminjaman</h1>
        <p class="text-xs text-base-content/60 mt-1">Kelola sirkulasi buku yang sedang dipinjam oleh anggota.</p>
    </div>
    <div>
        <a href="{{ url('/admin/peminjaman/create') }}" class="btn btn-primary rounded-xl shadow-lg shadow-primary/25 gap-2 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Transaksi Baru
        </a>
    </div>
</div>

<div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl overflow-hidden">
    <div class="card-body p-5 md:p-6">
        <form method="GET" action="{{ url('/admin/peminjaman') }}" class="mb-6">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-base-content/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode Transaksi / Nama Anggota..." class="input input-sm input-bordered rounded-xl pl-10 w-full bg-base-200/40 focus:bg-base-100 text-xs transition-all" />
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-left">
                <thead>
                    <tr class="bg-base-200/50 text-base-content/70 text-xs font-semibold uppercase tracking-wider border-b border-base-200">
                        <th class="rounded-l-xl py-3.5">Kode Transaksi</th>
                        <th>Peminjam</th>
                        <th>Item Buku</th>
                        <th>Tgl Pinjam & Kembali</th>
                        <th class="rounded-r-xl text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/60 text-sm">
                    @forelse ($peminjamans as $trx)
                        <tr class="hover:bg-base-200/30 transition-colors">
                            <td class="font-mono text-xs font-bold text-primary py-3.5">{{ $trx->kode_transaksi }}</td>
                            <td>
                                <div class="font-semibold">{{ $trx->anggota->nama_lengkap }}</div>
                                <div class="text-[11px] text-base-content/50 uppercase">{{ $trx->anggota->jenis_anggota }}</div>
                            </td>
                            <td>
                                <ul class="list-disc list-inside text-xs text-base-content/80">
                                    @foreach($trx->detailPeminjaman as $detail)
                                        <li class="truncate max-w-xs">{{ $detail->buku->judul }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <div class="text-xs">Pinjam: {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}</div>
                                <div class="text-xs font-semibold text-error mt-0.5">Batas: {{ \Carbon\Carbon::parse($trx->tanggal_harus_kembali)->format('d M Y') }}</div>
                            </td>
                            <td class="text-center">
                                @if($trx->status == 'dipinjam')
                                    <span class="badge badge-warning/15 text-amber-700 border-amber-200 font-semibold text-xs rounded-lg">Dipinjam</span>
                                @elseif($trx->status == 'dikembalikan')
                                    <span class="badge badge-success/15 text-emerald-700 border-emerald-200 font-semibold text-xs rounded-lg">Dikembalikan</span>
                                @else
                                    <span class="badge badge-error/15 text-rose-700 border-rose-200 font-semibold text-xs rounded-lg">Terlambat</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-10 text-xs text-base-content/50">Belum ada transaksi peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($peminjamans->hasPages())
            <div class="mt-4 pt-4 border-t border-base-200 flex justify-end">{{ $peminjamans->links() }}</div>
        @endif
    </div>
</div>
@endsection