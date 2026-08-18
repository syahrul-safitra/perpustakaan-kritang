{{-- @extends('Admin.Layouts.main')

@section("title", "Laporan Sirkulasi - Admin Perpustakaan")
@section("breadcrumb_active", "Laporan")

@section("content")

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

            @if (request("tanggal_mulai") || request("tanggal_selesai"))
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
                                    @foreach ($trx->detailPeminjaman as $detail)
                                        <li class="truncate max-w-[240px]">{{ $detail->buku->judul ?? '-' }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center text-xs">
                                <div>{{ date('d/m/Y', strtotime($trx->tanggal_pinjam)) }}</div>
                                <div class="text-error font-semibold mt-0.5">s/d {{ date('d/m/Y', strtotime($trx->tanggal_harus_kembali)) }}</div>
                            </td>
                            <td class="text-center">
                                @if ($trx->status == "dipinjam")
                                    <span class="badge badge-warning badge-sm font-bold">DIPINJAM</span>
                                @elseif($trx->status == 'dikembalikan')
                                    <span class="badge badge-success badge-sm font-bold text-white">SELESAI</span>
                                    @if ($trx->total_denda > 0)
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

@endsection --}}

@extends("Admin.Layouts.main")

@section("title", "Laporan Sirkulasi - E-Perpus SMAN 1 Keritang")
@section("page_heading", "Laporan Rekapitulasi Sirkulasi")

@section("content")
    <div class="space-y-6">

        <!-- Card Filter Rentang Tanggal & Tombol Aksi -->
        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <div class="mb-4 border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-800">Filter Rekapitulasi Transactions</h2>
                <p class="text-xs text-slate-400">Tentukan rentang tanggal untuk menyaring dan mencetak laporan sirkulasi
                    peminjaman & pengembalian buku.</p>
            </div>

            <form action="{{ url("/admin/laporan") }}" method="GET" class="grid grid-cols-1 items-end gap-4 md:grid-cols-12">

                <!-- Input Tanggal Mulai -->
                <div class="flex flex-col gap-1 md:col-span-4">
                    <label class="text-xs font-bold text-slate-700">Tanggal Mulai</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-regular fa-calendar text-xs"></i>
                        </span>
                        <input type="date" name="tanggal_mulai" value="{{ request("tanggal_mulai") }}"
                            class="input input-sm input-bordered w-full rounded-xl bg-slate-50 pl-9 font-mono text-xs text-slate-700 focus:border-emerald-500 focus:bg-white focus:outline-none" />
                    </div>
                </div>

                <!-- Input Tanggal Selesai -->
                <div class="flex flex-col gap-1 md:col-span-4">
                    <label class="text-xs font-bold text-slate-700">Tanggal Selesai</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-regular fa-calendar-check text-xs"></i>
                        </span>
                        <input type="date" name="tanggal_selesai" value="{{ request("tanggal_selesai") }}"
                            class="input input-sm input-bordered w-full rounded-xl bg-slate-50 pl-9 font-mono text-xs text-slate-700 focus:border-emerald-500 focus:bg-white focus:outline-none" />
                    </div>
                </div>

                <!-- Tombol Filter, Reset & Cetak PDF -->
                <div class="flex items-center gap-2 md:col-span-4">
                    <button type="submit"
                        class="btn btn-sm flex-1 gap-1.5 rounded-xl border-none bg-emerald-600 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700">
                        <i class="fa-solid fa-filter text-xs"></i> Filter Data
                    </button>

                    @if (request("tanggal_mulai") || request("tanggal_selesai"))
                        <a href="{{ url("/admin/laporan") }}"
                            class="btn btn-sm btn-ghost rounded-xl border border-slate-200 px-3 text-xs font-semibold text-slate-500"
                            title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    @endif

                    <!-- Tombol Cetak PDF -->
                    <a href="{{ url("/admin/laporan/cetak?" . http_build_query(request()->all())) }}" target="_blank"
                        class="btn btn-sm gap-1.5 rounded-xl border-none bg-rose-600 px-4 text-xs font-bold text-white shadow-md shadow-rose-600/20 hover:bg-rose-700">
                        <i class="fa-solid fa-file-pdf text-xs"></i> Cetak PDF
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabel Pratinjau Data Laporan -->
        <div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                    Pratinjau Data Rekapitulasi
                </span>
                <span class="text-xs font-semibold text-slate-600">
                    Total: <strong class="font-mono text-emerald-600">{{ $peminjamans->total() }}</strong> Transaksi
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-xs">
                    <thead>
                        <tr
                            class="border-b border-slate-100 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="w-12 px-4 py-3.5 text-center">No</th>
                            <th class="px-4 py-3.5">Kode TRX & Peminjam</th>
                            <th class="px-4 py-3.5">Item Buku Dipinjam</th>
                            <th class="px-4 py-3.5 text-center">Tgl Pinjam / Kembali</th>
                            <th class="px-4 py-3.5 text-center">Status & Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse ($peminjamans as $index => $trx)
                            <tr class="transition-colors hover:bg-slate-50/80">
                                <td class="px-4 py-3.5 text-center font-mono font-bold text-slate-400">
                                    {{ $peminjamans->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3.5">
                                    <span class="font-mono font-bold text-emerald-600">{{ $trx->kode_transaksi }}</span>
                                    <div class="mt-0.5 font-bold text-slate-800">{{ $trx->anggota->nama_lengkap ?? "-" }}
                                    </div>
                                    <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                                        {{ $trx->anggota->jenis_anggota ?? "-" }}
                                    </div>
                                </td>
                                <td class="px-4 py-3.5">
                                    <ul class="space-y-1">
                                        @foreach ($trx->detailPeminjaman as $detail)
                                            <li
                                                class="flex max-w-xs items-center gap-1.5 truncate font-medium text-slate-700">
                                                <i class="fa-solid fa-book-bookmark text-[10px] text-emerald-500"></i>
                                                <span>{{ $detail->buku->judul ?? "-" }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-4 py-3.5 text-center font-mono">
                                    <div class="text-slate-600">{{ date("d/m/Y", strtotime($trx->tanggal_pinjam)) }}</div>
                                    <div class="mt-0.5 font-bold text-rose-600">s/d
                                        {{ date("d/m/Y", strtotime($trx->tanggal_harus_kembali)) }}</div>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    @if ($trx->status == "dipinjam")
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full border border-amber-200/60 bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Dipinjam
                                        </span>
                                    @elseif($trx->status == "dikembalikan")
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full border border-emerald-200/60 bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Selesai
                                        </span>
                                        @if ($trx->total_denda > 0)
                                            <div class="mt-1 font-mono text-[10px] font-bold text-rose-600">
                                                Denda: Rp {{ number_format($trx->total_denda, 0, ",", ".") }}
                                            </div>
                                        @endif
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full border border-rose-200/60 bg-rose-50 px-2.5 py-1 text-[10px] font-bold text-rose-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Terlambat
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center italic text-slate-400">
                                    Tidak ada data transaksi peminjaman yang cocok dengan rentang tanggal tersebut.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($peminjamans->hasPages())
                <div class="border-t border-slate-100 p-4">
                    {{ $peminjamans->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
