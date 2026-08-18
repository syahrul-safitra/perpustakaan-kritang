{{-- @extends('Admin.Layouts.main')

@section("title", "Transaksi Peminjaman - Admin")
@section("breadcrumb_active", "Peminjaman Buku")

@section("content")
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
                                    @foreach ($trx->detailPeminjaman as $detail)
                                        <li class="truncate max-w-xs">{{ $detail->buku->judul }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <div class="text-xs">Pinjam: {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}</div>
                                <div class="text-xs font-semibold text-error mt-0.5">Batas: {{ \Carbon\Carbon::parse($trx->tanggal_harus_kembali)->format('d M Y') }}</div>
                            </td>
                            <td class="text-center">
                                @if ($trx->status == "dipinjam")
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
@endsection --}}

@extends("Admin.Layouts.main")

@section("title", "Data Peminjaman Buku - E-Perpus SMAN 1 Keritang")
@section("page_heading", "Kelola Sirkulasi Peminjaman")

@section("content")
    <div class="space-y-6">

        <!-- Header Action & Search Card (Light Emerald Style) -->
        <div class="space-y-4 rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">

            <!-- Baris Atas: Judul & Tombol Transaksi Baru -->
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Daftar Transaksi Peminjaman</h2>
                    <p class="text-xs text-slate-400">Kelola sirkulasi koleksi buku yang sedang dipinjam oleh anggota</p>
                </div>

                <a href="{{ url("/admin/peminjaman/create") }}"
                    class="btn btn-sm gap-2 self-start rounded-2xl border-none bg-emerald-600 px-4 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700 md:self-auto">
                    <i class="fa-solid fa-plus text-xs"></i> Transaksi Baru
                </a>
            </div>

            <!-- Baris Bawah: Form Pencarian & Filter Status -->
            <form method="GET" action="{{ url("/admin/peminjaman") }}"
                class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 pt-3 md:flex-row">

                <!-- Input Search Field -->
                <div class="relative w-full md:w-96">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request("search") }}"
                        placeholder="Cari Kode Transaksi / Nama Anggota..."
                        class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-slate-50 pl-9 text-xs text-slate-700 transition-all focus:border-emerald-500 focus:bg-white focus:outline-none" />
                </div>

                <!-- Filter Status Peminjaman -->
                <div class="flex w-full items-center gap-2 md:w-auto">
                    <select name="status"
                        class="select select-sm select-bordered rounded-xl border-slate-200 bg-slate-50 text-xs text-slate-700 focus:border-emerald-500 focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="dipinjam" {{ request("status") == "dipinjam" ? "selected" : "" }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request("status") == "dikembalikan" ? "selected" : "" }}>
                            Dikembalikan</option>
                        <option value="terlambat" {{ request("status") == "terlambat" ? "selected" : "" }}>Terlambat
                        </option>
                    </select>

                    <button type="submit"
                        class="btn btn-sm gap-1.5 rounded-xl border border-slate-200 bg-slate-100 px-4 text-xs font-bold text-slate-700 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                        <i class="fa-solid fa-filter text-[11px]"></i> Filter
                    </button>

                    @if (request("search") || request("status"))
                        <a href="{{ url("/admin/peminjaman") }}"
                            class="btn btn-sm btn-ghost rounded-xl px-2 text-xs font-semibold text-rose-500 hover:bg-rose-50"
                            title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i> Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Table Data Container -->
        <div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Transaksi:
                    {{ $peminjamans->total() ?? count($peminjamans) }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-xs">
                    <thead>
                        <tr
                            class="border-b border-slate-100 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="px-4 py-3.5">Kode TRX</th>
                            <th class="px-4 py-3.5">Peminjam</th>
                            <th class="px-4 py-3.5">Item Buku Dipinjam</th>
                            <th class="px-4 py-3.5">Tgl Pinjam & Batas</th>
                            <th class="px-4 py-3.5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse ($peminjamans as $trx)
                            <tr class="transition-colors hover:bg-slate-50/80">
                                <td class="px-4 py-3.5 font-mono font-bold text-emerald-600">
                                    {{ $trx->kode_transaksi }}
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="font-bold text-slate-800">{{ $trx->anggota->nama_lengkap ?? "-" }}</div>
                                    <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                                        {{ $trx->anggota->jenis_anggota ?? "Anggota" }}
                                        <span class="font-mono text-slate-300">|</span>
                                        {{ $trx->anggota->nomor_induk ?? "-" }}
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
                                <td class="px-4 py-3.5">
                                    <div class="font-medium text-slate-600">
                                        <i class="fa-regular fa-calendar-check mr-1 text-slate-400"></i> Pinjam:
                                        {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format("d M Y") }}
                                    </div>
                                    <div class="mt-0.5 font-bold text-rose-600">
                                        <i class="fa-regular fa-calendar-xmark mr-1 text-rose-400"></i> Batas:
                                        {{ \Carbon\Carbon::parse($trx->tanggal_harus_kembali)->format("d M Y") }}
                                    </div>
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
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Dikembalikan
                                        </span>
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
                                    Belum ada data transaksi peminjaman.
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
