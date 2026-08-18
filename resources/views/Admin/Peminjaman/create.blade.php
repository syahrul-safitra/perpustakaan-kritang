@extends('Admin.Layouts.main')

@section('title', 'Transaksi Baru - Admin')
@section('breadcrumb_active', 'Transaksi Baru')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content tracking-tight">Transaksi Peminjaman</h1>
        <p class="text-xs text-base-content/60 mt-1">Sistem otomatis memvalidasi stok buku dan status anggota.</p>
    </div>
    <div>
        <a href="{{ url('/admin/peminjaman') }}" class="btn btn-ghost btn-sm border border-base-200 rounded-xl gap-2 text-xs font-semibold">Kembali</a>
    </div>
</div>

<form action="{{ url('/admin/peminjaman') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Kolom Kiri: Detail Peminjam (4 Cols) -->
        <div class="lg:col-span-5 card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-6">
            <h2 class="font-bold text-sm text-base-content mb-4 border-b border-base-200 pb-3">Informasi Peminjam</h2>

            <!-- CUSTOM SEARCHABLE DROPDOWN UNTUK ANGGOTA -->
            <div class="form-control mb-4 relative" id="search_container">
                <label class="label py-1"><span class="label-text font-semibold text-xs text-base-content/70">Pilih Anggota <span class="text-error">*</span></span></label>
                
                <!-- Input Hidden untuk dikirim ke Controller -->
                <input type="hidden" name="anggota_id" id="anggota_id_input" value="{{ old('anggota_id') }}" required>
                
                <!-- Input Visual untuk Cari Nama -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-base-content/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </span>
                    <input type="text" id="search_anggota" placeholder="Ketik nama atau NIS/NIP..." class="input input-sm input-bordered rounded-xl pl-9 w-full font-medium text-xs @error('anggota_id') input-error @enderror" autocomplete="off" />
                </div>

                <!-- Box List Auto-complete -->
                <ul id="list_anggota" class="absolute z-50 top-[60px] left-0 w-full bg-base-100 shadow-2xl max-h-56 overflow-y-auto hidden rounded-xl border border-base-200 p-1 text-xs">
                    <!-- List dirender via JS -->
                </ul>
                
                @error('anggota_id') <span class="text-[11px] text-error mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Tanggal Pinjam & Kembali -->
            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Tanggal Pinjam</span></label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" class="input input-sm input-bordered rounded-xl text-xs" required />
                </div>
                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Harus Kembali</span></label>
                    <input type="date" name="tanggal_harus_kembali" value="{{ old('tanggal_harus_kembali', date('Y-m-d', strtotime('+7 days'))) }}" class="input input-sm input-bordered rounded-xl text-xs" required />
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Keranjang Buku (7 Cols) -->
        <div class="lg:col-span-7 card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4 border-b border-base-200 pb-3">
                <h2 class="font-bold text-sm text-base-content">Buku yang Dipinjam</h2>
                <button type="button" onclick="addBookRow()" class="btn btn-sm btn-ghost text-primary hover:bg-primary/10 rounded-xl gap-1 text-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Buku
                </button>
            </div>

            <div id="books_container" class="space-y-3">
                <!-- Baris Buku Default -->
                <div class="flex items-center gap-3 book-row">
                    <div class="flex-1">
                        <select name="buku_id[]" class="select select-sm select-bordered w-full rounded-xl text-xs" required>
                            <option value="" disabled selected>-- Pilih Judul Buku --</option>
                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->id }}">{{ $buku->judul }} (ISBN: {{ $buku->isbn ?? '-' }} | Stok: {{ $buku->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" onclick="removeBookRow(this)" class="btn btn-square btn-sm btn-ghost text-error hover:bg-error/10 rounded-xl" title="Hapus Baris">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </div>
            </div>
            
            @if(session('error'))
                <span class="text-[11px] text-error block mt-3 font-semibold">{{ session('error') }}</span>
            @endif

            <div class="pt-6 mt-6 border-t border-base-200 flex justify-end">
                <button type="submit" class="btn btn-primary btn-sm rounded-xl px-8 text-xs font-semibold shadow-lg shadow-primary/25">Proses Transaksi</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    /* =========================================
       1. LOGIKA CUSTOM SEARCHABLE DROPDOWN
       ========================================= */
    const dataAnggota = @json($anggotas); // Lempar data PHP ke JS
    
    const searchInput = document.getElementById('search_anggota');
    const hiddenInput = document.getElementById('anggota_id_input');
    const listContainer = document.getElementById('list_anggota');
    const containerDiv = document.getElementById('search_container');

    // Fungsi Render List HTML
    function renderList(filteredData) {
        listContainer.innerHTML = '';
        if (filteredData.length === 0) {
            listContainer.innerHTML = '<li class="p-3 text-base-content/50 text-center">Anggota tidak ditemukan</li>';
        } else {
            filteredData.forEach(item => {
                const li = document.createElement('li');
                li.className = 'px-4 py-2.5 hover:bg-base-200/50 cursor-pointer border-b border-base-100 last:border-0 transition-colors flex flex-col';
                li.innerHTML = `
                    <span class="font-semibold text-base-content">${item.nama_lengkap}</span>
                    <span class="font-mono text-[10px] text-base-content/50">${item.nomor_induk} - ${item.jenis_anggota.toUpperCase()}</span>
                `;
                // Jika diklik, set nilai ke input
                li.addEventListener('mousedown', function() {
                    hiddenInput.value = item.id;
                    searchInput.value = item.nama_lengkap;
                    listContainer.classList.add('hidden');
                });
                listContainer.appendChild(li);
            });
        }
    }

    // Event Ketik di Kolom Pencarian
    searchInput.addEventListener('input', function() {
        const keyword = this.value.toLowerCase();
        listContainer.classList.remove('hidden');
        
        const filtered = dataAnggota.filter(item => 
            item.nama_lengkap.toLowerCase().includes(keyword) || 
            item.nomor_induk.toLowerCase().includes(keyword)
        );
        
        renderList(filtered);
    });

    // Menampilkan list saat input di-klik
    searchInput.addEventListener('focus', function() {
        renderList(dataAnggota);
        listContainer.classList.remove('hidden');
    });

    // Sembunyikan list saat klik di luar area
    document.addEventListener('click', function(e) {
        if (!containerDiv.contains(e.target)) {
            listContainer.classList.add('hidden');
        }
    });

    /* =========================================
       2. LOGIKA KERANJANG BUKU DINAMIS
       ========================================= */
    function addBookRow() {
        const container = document.getElementById('books_container');
        const firstRow = container.querySelector('.book-row').cloneNode(true); // Clone elemen pertama
        
        // Reset nilai select pada row baru
        firstRow.querySelector('select').selectedIndex = 0;
        
        container.appendChild(firstRow);
    }

    function removeBookRow(btn) {
        const container = document.getElementById('books_container');
        // Jangan izinkan hapus jika hanya tersisa 1 baris
        if (container.children.length > 1) {
            btn.closest('.book-row').remove();
        } else {
            alert('Minimal harus ada satu buku yang dipinjam.');
        }
    }
</script>
@endpush
@endsection