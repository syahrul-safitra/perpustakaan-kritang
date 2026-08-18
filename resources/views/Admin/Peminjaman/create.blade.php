{{-- @extends('Admin.Layouts.main')

@section("title", "Transaksi Baru - Admin")
@section("breadcrumb_active", "Transaksi Baru")

@section("content")
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
                    <input type="text" id="search_anggota" placeholder="Ketik nama atau NIS/NIP..." class="input input-sm input-bordered rounded-xl pl-9 w-full font-medium text-xs @error("anggota_id") input-error @enderror" autocomplete="off" />
                </div>

                <!-- Box List Auto-complete -->
                <ul id="list_anggota" class="absolute z-50 top-[60px] left-0 w-full bg-base-100 shadow-2xl max-h-56 overflow-y-auto hidden rounded-xl border border-base-200 p-1 text-xs">
                    <!-- List dirender via JS -->
                </ul>
                
                @error("anggota_id") <span class="text-[11px] text-error mt-1">{{ $message }}</span> @enderror
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
            
            @if (session("error"))
                <span class="text-[11px] text-error block mt-3 font-semibold">{{ session('error') }}</span>
            @endif

            <div class="pt-6 mt-6 border-t border-base-200 flex justify-end">
                <button type="submit" class="btn btn-primary btn-sm rounded-xl px-8 text-xs font-semibold shadow-lg shadow-primary/25">Proses Transaksi</button>
            </div>
        </div>
    </div>
</form>

@push("scripts")
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
@endsection --}}

@extends("Admin.Layouts.main")

@section("title", "Transaksi Peminjaman Baru - E-Perpus SMAN 1 Keritang")
@section("page_heading", "Peminjaman Buku Baru")

@section("content")
    <div class="space-y-6">

        <!-- Page Header & Action Back -->
        <div
            class="flex flex-col justify-between gap-4 rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center">
            <div>
                <h1 class="text-base font-bold tracking-tight text-slate-800">Formulir Peminjaman Buku</h1>
                <p class="mt-0.5 text-xs text-slate-400">Sistem akan secara otomatis memvalidasi stok buku dan status
                    keaktifan anggota.</p>
            </div>
            <div>
                <a href="{{ url("admin/peminjaman") }}"
                    class="btn btn-sm gap-2 rounded-xl border-none bg-slate-100 text-xs font-bold text-slate-700 transition-colors hover:bg-slate-200">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Main Form Container -->
        <form action="{{ url("admin/peminjaman") }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">

                <!-- Kolom Kiri: Detail Peminjam (5 Cols) -->
                <div class="space-y-4 rounded-3xl border border-slate-100 bg-white p-6 shadow-sm lg:col-span-5">
                    <h2
                        class="mb-4 flex items-center gap-2 border-b border-slate-100 pb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <i class="fa-solid fa-id-card text-emerald-600"></i> Informasi Peminjam
                    </h2>

                    <!-- CUSTOM SEARCHABLE DROPDOWN UNTUK ANGGOTA -->
                    <div class="relative flex flex-col gap-1" id="search_container">
                        <label class="text-xs font-bold text-slate-700">Pilih Anggota Peminjam <span
                                class="text-rose-500">*</span></label>

                        <!-- Input Hidden untuk ID Anggota -->
                        <input type="hidden" name="anggota_id" id="anggota_id_input" value="{{ old("anggota_id") }}"
                            required>

                        <!-- Input Visual untuk Cari Nama -->
                        <div class="relative">
                            <span
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text" id="search_anggota" placeholder="Ketik nama atau NIS/NIP..."
                                class="input input-sm input-bordered @error("anggota_id") input-error border-rose-500 @enderror w-full rounded-xl bg-slate-50 pl-9 text-xs font-medium text-slate-700 focus:border-emerald-500 focus:bg-white focus:outline-none"
                                autocomplete="off" />
                        </div>

                        <!-- Box List Auto-complete -->
                        <ul id="list_anggota"
                            class="absolute left-0 top-[62px] z-50 hidden max-h-56 w-full overflow-y-auto rounded-2xl border border-slate-100 bg-white p-1.5 text-xs shadow-2xl">
                            <!-- List dirender via JS -->
                        </ul>

                        @error("anggota_id")
                            <span class="mt-0.5 text-[10px] font-semibold text-rose-500"><i
                                    class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tanggal Pinjam & Batas Kembali -->
                    <div class="grid grid-cols-1 gap-4 pt-2 sm:grid-cols-2">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-bold text-slate-700">Tanggal Pinjam <span
                                    class="text-rose-500">*</span></label>
                            <input type="date" name="tanggal_pinjam" value="{{ old("tanggal_pinjam", date("Y-m-d")) }}"
                                class="input input-sm input-bordered w-full rounded-xl font-mono text-xs focus:border-emerald-500 focus:outline-none"
                                required />
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-bold text-slate-700">Harus Kembali <span
                                    class="text-rose-500">*</span></label>
                            <input type="date" name="tanggal_harus_kembali"
                                value="{{ old("tanggal_harus_kembali", date("Y-m-d", strtotime("+7 days"))) }}"
                                class="input input-sm input-bordered w-full rounded-xl font-mono text-xs font-bold text-rose-600 focus:border-emerald-500 focus:outline-none"
                                required />
                        </div>
                    </div>

                    <!-- Alert Catatan Durasi -->
                    <div
                        class="mt-2 flex items-start gap-2.5 rounded-2xl border border-emerald-200/60 bg-emerald-50/60 p-3 text-[11px] text-emerald-800">
                        <i class="fa-solid fa-circle-info mt-0.5 text-emerald-600"></i>
                        <span>Durasi peminjaman standar adalah <strong>7 hari</strong>. Pengembalian yang melewati tanggal
                            batas kembali akan dikenakan denda denda keterlambatan secara otomatis.</span>
                    </div>
                </div>

                <!-- Kolom Kanan: Keranjang Buku (7 Cols) -->
                <div
                    class="flex flex-col justify-between rounded-3xl border border-slate-100 bg-white p-6 shadow-sm lg:col-span-7">
                    <div>
                        <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                            <h2 class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                                <i class="fa-solid fa-basket-shopping text-emerald-600"></i> Item Buku Dipinjam
                            </h2>
                            <button type="button" onclick="addBookRow()"
                                class="btn btn-xs gap-1 rounded-xl border-none bg-emerald-50 px-3 font-bold text-emerald-700 hover:bg-emerald-100">
                                <i class="fa-solid fa-plus text-[10px]"></i> Tambah Baris
                            </button>
                        </div>

                        <div id="books_container" class="space-y-3">
                            <!-- Baris Buku Default -->
                            <div class="book-row flex items-center gap-2.5">
                                <div class="flex-1">
                                    <select name="buku_id[]"
                                        class="select select-sm select-bordered w-full rounded-xl text-xs text-slate-700 focus:border-emerald-500 focus:outline-none"
                                        required>
                                        <option value="" disabled selected>-- Pilih Judul Buku --</option>
                                        @foreach ($bukus as $buku)
                                            <option value="{{ $buku->id }}">
                                                {{ $buku->judul }} (ISBN: {{ $buku->isbn ?? "-" }} | Stok:
                                                {{ $buku->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" onclick="removeBookRow(this)"
                                    class="btn btn-square btn-sm shrink-0 rounded-xl border-none bg-slate-100 text-slate-400 transition-colors hover:bg-rose-50 hover:text-rose-600"
                                    title="Hapus Baris">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </div>

                        @if (session("error"))
                            <div
                                class="mt-4 flex items-center gap-2 rounded-xl border border-rose-200/60 bg-rose-50 p-3 text-xs font-semibold text-rose-600">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>{{ session("error") }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-6">
                        <a href="{{ url("admin/peminjaman") }}"
                            class="btn btn-ghost btn-sm rounded-xl text-xs text-slate-500">Batal</a>
                        <button type="submit"
                            class="btn btn-sm gap-2 rounded-xl border-none bg-emerald-600 px-6 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700">
                            <i class="fa-solid fa-check text-xs"></i> Proses Peminjaman
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>

    @push("scripts")
        <script>
            /* =========================================
                               1. LOGIKA CUSTOM SEARCHABLE DROPDOWN ANGGOTA
                               ========================================= */
            const dataAnggota = @json($anggotas);

            const searchInput = document.getElementById('search_anggota');
            const hiddenInput = document.getElementById('anggota_id_input');
            const listContainer = document.getElementById('list_anggota');
            const containerDiv = document.getElementById('search_container');

            function renderList(filteredData) {
                listContainer.innerHTML = '';
                if (filteredData.length === 0) {
                    listContainer.innerHTML = '<li class="p-3 text-slate-400 text-center italic">Anggota tidak ditemukan</li>';
                } else {
                    filteredData.forEach(item => {
                        const li = document.createElement('li');
                        li.className =
                            'px-3.5 py-2 hover:bg-emerald-50 cursor-pointer rounded-xl transition-colors flex flex-col';
                        li.innerHTML = `
                    <span class="font-bold text-slate-800">${item.nama_lengkap}</span>
                    <span class="font-mono text-[10px] text-slate-400 uppercase">${item.nomor_induk} • ${item.jenis_anggota} (${item.kelas_or_jabatan})</span>
                `;
                        li.addEventListener('mousedown', function() {
                            hiddenInput.value = item.id;
                            searchInput.value = item.nama_lengkap;
                            listContainer.classList.add('hidden');
                        });
                        listContainer.appendChild(li);
                    });
                }
            }

            searchInput.addEventListener('input', function() {
                const keyword = this.value.toLowerCase();
                listContainer.classList.remove('hidden');

                const filtered = dataAnggota.filter(item =>
                    item.nama_lengkap.toLowerCase().includes(keyword) ||
                    item.nomor_induk.toLowerCase().includes(keyword)
                );

                renderList(filtered);
            });

            searchInput.addEventListener('focus', function() {
                renderList(dataAnggota);
                listContainer.classList.remove('hidden');
            });

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
                const firstRow = container.querySelector('.book-row').cloneNode(true);

                firstRow.querySelector('select').selectedIndex = 0;
                container.appendChild(firstRow);
            }

            function removeBookRow(btn) {
                const container = document.getElementById('books_container');
                if (container.children.length > 1) {
                    btn.closest('.book-row').remove();
                } else {
                    alert('Minimal harus ada satu buku yang dipinjam.');
                }
            }
        </script>
    @endpush
@endsection
