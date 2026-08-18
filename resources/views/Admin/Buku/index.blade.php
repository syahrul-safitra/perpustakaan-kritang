@extends('Admin.Layouts.main')

@section('title', 'Koleksi Buku - Admin Perpustakaan')
@section('breadcrumb_active', 'Data Koleksi Buku')

@section('content')
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
        @if (isset($bukus) && method_exists($bukus, 'links'))
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

@push('scripts')
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
@endsection