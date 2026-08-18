{{-- @extends('Admin.Layouts.main')

@section("title", "Koleksi Buku - Admin Perpustakaan")
@section("breadcrumb_active", "Data Koleksi Buku")

@section("content")
<!-- Page Header & Action Button -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content tracking-tight">Koleksi Buku Perpustakaan</h1>
        <p class="text-xs md:text-sm text-base-content/60 mt-1">Kelola data buku, ketersediaan stok, serta lokasi rak buku SMA Negeri 1 Keritang.</p>
    </div>
    <div>
        <a href="{{ url('admin/buku/create') }}" class="btn btn-primary rounded-xl shadow-lg shadow-primary/25 gap-2 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Buku Baru
        </a>
    </div>
</div>

<!-- Main Card Content -->
<div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl overflow-hidden">
    <div class="card-body p-5 md:p-6">
        
        <!-- Filter Bar & Search Input -->
        <form method="GET" action="{{ url('admin/buku') }}" class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <!-- Search Field -->
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-base-content/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, ISBN, pengarang..." 
                       class="input input-sm input-bordered rounded-xl pl-10 w-full bg-base-200/40 focus:bg-base-100 text-xs transition-all" />
            </div>

            <!-- Category Filter & Action Button -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select name="kategori_id" class="select select-sm select-bordered rounded-xl bg-base-200/40 focus:bg-base-100 text-xs w-full md:w-48">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList ?? [] as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-sm btn-ghost border border-base-200 rounded-xl px-4 gap-2 text-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
            </div>
        </form>

        <!-- Table Data Buku -->
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-left">
                <!-- Table Head -->
                <thead>
                    <tr class="bg-base-200/50 text-base-content/70 text-xs font-semibold uppercase tracking-wider border-b border-base-200">
                        <th class="rounded-l-xl py-3.5">Buku & ISBN</th>
                        <th>Kategori</th>
                        <th>Pengarang / Penerbit</th>
                        <th>Lokasi Rak</th>
                        <th class="text-center">Stok</th>
                        <th class="rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-base-200/60 text-sm">
                    @forelse ($bukus ?? [] as $buku)
                        <tr class="hover:bg-base-200/30 transition-colors">
                            <!-- Cover & Judul -->
                            <td class="py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-12 h-16 rounded-lg bg-base-200 border border-base-300 shadow-xs overflow-hidden flex items-center justify-center">
                                            @if ($buku->cover)
                                                <img src="{{ asset('uploads/buku/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="object-cover w-full h-full" />
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-base-content leading-tight hover:text-primary transition-colors">{{ $buku->judul }}</span>
                                        <span class="font-mono text-[11px] text-base-content/50 mt-1">ISBN: {{ $buku->isbn ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td>
                                <span class="badge badge-primary/10 text-primary border-primary/20 font-medium text-xs rounded-lg px-2.5 py-2">
                                    {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Pengarang & Penerbit -->
                            <td>
                                <div class="flex flex-col">
                                    <span class="font-medium text-base-content/90">{{ $buku->pengarang }}</span>
                                    <span class="text-xs text-base-content/50">{{ $buku->penerbit }} ({{ $buku->tahun_terbit }})</span>
                                </div>
                            </td>

                            <!-- Lokasi Rak -->
                            <td>
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-base-200/60 text-xs font-mono font-medium text-base-content/70">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-base-content/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    {{ $buku->lokasi_rak }}
                                </div>
                            </td>

                            <!-- Badge Stok -->
                            <td class="text-center">
                                @if ($buku->stok > 5)
                                    <span class="badge badge-success/15 text-emerald-700 border-emerald-200 font-semibold text-xs px-2.5 py-1 rounded-lg">
                                        {{ $buku->stok }} Tersedia
                                    </span>
                                @elseif ($buku->stok > 0)
                                    <span class="badge badge-warning/15 text-amber-700 border-amber-200 font-semibold text-xs px-2.5 py-1 rounded-lg">
                                        Sisa {{ $buku->stok }}
                                    </span>
                                @else
                                    <span class="badge badge-error/15 text-rose-700 border-rose-200 font-semibold text-xs px-2.5 py-1 rounded-lg">
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Edit Button -->
                                    <a href="{{ url('admin/buku/' . $buku->id . '/edit') }}" 
                                       class="btn btn-square btn-ghost btn-xs text-base-content/60 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" 
                                       title="Edit Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <!-- Delete Button (Trigger Modal) -->
                                    <button onclick="confirmDelete('{{ $buku->id }}', '{{ $buku->judul }}')" 
                                            class="btn btn-square btn-ghost btn-xs text-base-content/60 hover:text-error hover:bg-error/10 rounded-lg transition-colors" 
                                            title="Hapus Buku">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <!-- Empty State -->
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-base-200/80 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-base text-base-content">Belum ada koleksi buku</h3>
                                    <p class="text-xs text-base-content/50 mt-1 max-w-sm">Data buku perpustakaan belum ditambahkan atau tidak ditemukan sesuai pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if (isset($bukus) && method_exists($bukus, "links"))
            <div class="mt-6 pt-4 border-t border-base-200 flex items-center justify-between">
                {{ $bukus->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box rounded-2xl border border-base-200 p-6">
        <h3 class="font-bold text-lg text-base-content">Konfirmasi Hapus Buku</h3>
        <p class="py-3 text-sm text-base-content/70">
            Apakah Anda yakin ingin menghapus buku <span id="buku_title" class="font-bold text-base-content"></span>? Tindakan ini tidak dapat dibatalkan.
        </p>
        
        <form id="delete_form" method="POST" class="modal-action gap-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="delete_modal.close()" class="btn btn-ghost rounded-xl">Batal</button>
            <button type="submit" class="btn btn-error rounded-xl text-white">Ya, Hapus Buku</button>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@push("scripts")
<script>
    function confirmDelete(id, title) {
        const form = document.getElementById('delete_form');
        const titleSpan = document.getElementById('buku_title');
        
        // Dynamic Action Route
        form.action = `/admin/buku/${id}`;
        titleSpan.innerText = `"${title}"`;
        
        // Show DaisyUI Modal
        document.getElementById('delete_modal').showModal();
    }
</script>
@endpush
@endsection --}}

@extends("Admin.Layouts.main")

@section("title", "Koleksi Buku - E-Perpus SMAN 1 Keritang")
@section("page_heading", "Kelola Koleksi Buku")

@section("content")
    <div class="space-y-6">

        <!-- Header Action & Search Card (Light Emerald Style) -->
        <div class="space-y-4 rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">

            <!-- Baris Atas: Judul & Tombol Tambah -->
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Daftar Koleksi Buku</h2>
                    <p class="text-xs text-slate-400">Kelola katalog buku, stok eksemplar, lokasi rak, dan sampul buku</p>
                </div>

                <a href="{{ url("admin/buku/create") }}"
                    class="btn btn-sm gap-2 self-start rounded-2xl border-none bg-emerald-600 px-4 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700 md:self-auto">
                    <i class="fa-solid fa-plus text-xs"></i> Tambah Buku Baru
                </a>
            </div>

            <!-- Baris Bawah: Form Pencarian & Filter -->
            <form method="GET" action="{{ url("/admin/buku") }}"
                class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 pt-3 md:flex-row">

                <!-- Input Search Field -->
                <div class="relative w-full md:w-80">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request("search") }}"
                        placeholder="Cari judul, ISBN, atau pengarang..."
                        class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-slate-50 pl-9 text-xs text-slate-700 transition-all focus:border-emerald-500 focus:bg-white focus:outline-none" />
                </div>

                <!-- Filter Kategori & Stok -->
                <div class="flex w-full items-center gap-2 md:w-auto">
                    <select name="kategori_id"
                        class="select select-sm select-bordered rounded-xl border-slate-200 bg-slate-50 text-xs text-slate-700 focus:border-emerald-500 focus:outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ request("kategori_id") == $kat->id ? "selected" : "" }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="btn btn-sm gap-1.5 rounded-xl border border-slate-200 bg-slate-100 px-4 text-xs font-bold text-slate-700 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                        <i class="fa-solid fa-filter text-[11px]"></i> Filter
                    </button>

                    @if (request("search") || request("kategori_id"))
                        <a href="{{ url("/admin/buku") }}"
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
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Koleksi:
                    {{ $bukus->total() ?? count($bukus) }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-xs">
                    <thead>
                        <tr
                            class="border-b border-slate-100 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="w-12 px-4 py-3.5">No</th>
                            <th class="px-4 py-3.5">Buku & ISBN</th>
                            <th class="px-4 py-3.5">Kategori</th>
                            <th class="px-4 py-3.5">Pengarang / Penerbit</th>
                            <th class="px-4 py-3.5">Rak</th>
                            <th class="px-4 py-3.5 text-center">Stok Available</th>
                            <th class="w-28 px-4 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($bukus as $index => $item)
                            <tr class="transition-colors hover:bg-slate-50/80">
                                <td class="px-4 py-3.5 font-mono text-slate-400">
                                    {{ $bukus->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-12 w-9 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-slate-200 bg-slate-100 shadow-sm">
                                            @if ($item->cover)
                                                <img src="{{ asset("uploads/buku/" . $item->cover) }}"
                                                    alt="{{ $item->judul }}" class="h-full w-full object-cover">
                                            @else
                                                <i class="fa-solid fa-book text-base text-slate-300"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="line-clamp-1 font-bold text-slate-800">{{ $item->judul }}</div>
                                            <div class="font-mono text-[10px] text-slate-400">ISBN:
                                                {{ $item->isbn ?? "-" }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5">
                                    <span
                                        class="inline-flex items-center rounded-full border border-emerald-200/60 bg-emerald-50 px-2.5 py-0.5 text-[10px] font-bold text-emerald-700">
                                        {{ $item->kategori->nama_kategori ?? "Umum" }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="font-medium text-slate-800">{{ $item->pengarang }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $item->penerbit }}
                                        ({{ $item->tahun_terbit }})
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 font-mono text-slate-600">
                                    {{ $item->lokasi_rak ?? "-" }}
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    @if ($item->stok > 0)
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full border border-emerald-200/60 bg-emerald-50 px-2.5 py-0.5 text-[10px] font-bold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            {{ $item->stok }} Buku
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full border border-rose-200/60 bg-rose-50 px-2.5 py-0.5 text-[10px] font-bold text-rose-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Link Ke Halaman Edit Terpisah -->
                                        <a href="{{ url("admin/buku/" . $item->id . "/edit") }}"
                                            class="btn btn-xs btn-square flex items-center justify-center rounded-xl border-none bg-slate-100 text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600"
                                            title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>

                                        <!-- Tombol Pemicu Modal Hapus -->
                                        <button
                                            onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                            class="btn btn-xs btn-square rounded-xl border-none bg-slate-100 text-slate-600 transition-colors hover:bg-rose-50 hover:text-rose-600"
                                            title="Hapus Data">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center italic text-slate-400">
                                    Belum ada data buku yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($bukus->hasPages())
                <div class="border-t border-slate-100 p-4">
                    {{ $bukus->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Modal Konfirmasi Hapus Buku -->
    <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-11/12 max-w-md rounded-3xl border border-slate-100 bg-white p-6 text-center shadow-2xl">
            <div
                class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-xl text-rose-500">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-base font-bold text-slate-800">Konfirmasi Hapus Data</h3>
            <p class="mt-2 text-xs text-slate-500">
                Apakah Anda yakin ingin menghapus buku <span id="delete_buku_title"
                    class="font-bold text-slate-800"></span>? Data yang terhapus tidak dapat dikembalikan.
            </p>

            <form id="delete_form" method="POST" class="mt-6">
                @csrf
                @method("DELETE")
                <div class="flex items-center justify-center gap-3">
                    <button type="button" onclick="delete_modal.close()"
                        class="btn btn-ghost btn-sm w-1/2 rounded-xl text-xs text-slate-500">Batal</button>
                    <button type="submit"
                        class="btn btn-sm w-1/2 rounded-xl border-none bg-rose-600 text-xs font-bold text-white shadow-md shadow-rose-600/20 hover:bg-rose-700">Hapus
                        Sekarang</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    @push("scripts")
        <script>
            function confirmDelete(id, judul) {
                document.getElementById('delete_form').action = `/admin/buku/${id}`;
                document.getElementById('delete_buku_title').innerText = `"${judul}"`;
                document.getElementById('delete_modal').showModal();
            }
        </script>
    @endpush
@endsection
