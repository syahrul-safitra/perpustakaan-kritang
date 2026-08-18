@extends('Admin.Layouts.main')

@section('title', 'Tambah Buku Baru - Admin Perpustakaan')
@section('breadcrumb_active', 'Tambah Buku')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content tracking-tight">Tambah Buku Baru</h1>
        <p class="text-xs text-base-content/60 mt-1">Isi formulir berikut untuk menambah koleksi perpustakaan SMAN 1 Keritang.</p>
    </div>
    <div>
        <a href="{{ url('admin/buku/index') }}" class="btn btn-ghost btn-sm border border-base-200 rounded-xl gap-2 text-xs font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
</div>

<form action="{{ url('admin/buku') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Side: Cover Uploader Card (4 Cols) -->
        <div class="lg:col-span-4 card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-5">
            <h2 class="font-bold text-sm text-base-content mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Cover Buku
            </h2>

            <div class="flex flex-col items-center">
                <!-- Dropzone Box -->
                <div class="w-full h-72 rounded-xl bg-base-200/40 border-2 border-dashed border-base-300 flex flex-col items-center justify-center overflow-hidden relative group transition-all hover:border-primary/50">
                    <img id="cover_preview" class="w-full h-full object-cover hidden" alt="Preview Cover" />
                    
                    <div id="upload_placeholder" class="flex flex-col items-center text-center p-4">
                        <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-base-content/80">Upload Sampul Buku</span>
                        <span class="text-[10px] text-base-content/40 mt-1">Format: JPG, PNG (Maks. 2MB)</span>
                    </div>
                </div>

                <!-- Native Input Styled -->
                <div class="w-full mt-4">
                    <input type="file" name="cover" id="cover_input" accept="image/*" class="file-input file-input-sm file-input-bordered file-input-primary w-full rounded-xl bg-base-200/30 text-xs" onchange="previewImage(event)" />
                    @error('cover')
                        <span class="text-[11px] text-error mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Right Side: Form Content Card (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Section 1: Informasi Utama Buku -->
            <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-6">
                <h2 class="font-bold text-sm text-base-content mb-4 flex items-center gap-2 border-b border-base-200 pb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Informasi Utama
                </h2>

                <div class="space-y-4">
                    <!-- Judul Buku -->
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs text-base-content/70">Judul Buku <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul buku lengkap" class="input input-sm input-bordered rounded-xl bg-base-200/30 focus:bg-base-100 text-xs @error('judul') input-error @enderror" required />
                        @error('judul')
                            <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- ISBN & Kategori Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- ISBN -->
                        <div class="form-control">
                            <label class="label py-1">
                                <span class="label-text font-semibold text-xs text-base-content/70">Nomor ISBN</span>
                            </label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="978-602-xxxx-xx-x" class="input input-sm input-bordered rounded-xl bg-base-200/30 focus:bg-base-100 text-xs font-mono @error('isbn') input-error @enderror" />
                            @error('isbn')
                                <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="form-control">
                            <label class="label py-1">
                                <span class="label-text font-semibold text-xs text-base-content/70">Kategori Buku <span class="text-error">*</span></span>
                            </label>
                            <select name="kategori_id" class="select select-sm select-bordered rounded-xl bg-base-200/30 focus:bg-base-100 text-xs @error('kategori_id') select-error @enderror" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach ($kategoriList ?? [] as $kat)
                                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Pengarang & Penerbit Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Pengarang -->
                        <div class="form-control">
                            <label class="label py-1">
                                <span class="label-text font-semibold text-xs text-base-content/70">Pengarang / Penulis <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="pengarang" value="{{ old('pengarang') }}" placeholder="Nama pengarang" class="input input-sm input-bordered rounded-xl bg-base-200/30 focus:bg-base-100 text-xs @error('pengarang') input-error @enderror" required />
                            @error('pengarang')
                                <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Penerbit -->
                        <div class="form-control">
                            <label class="label py-1">
                                <span class="label-text font-semibold text-xs text-base-content/70">Penerbit <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit" class="input input-sm input-bordered rounded-xl bg-base-200/30 focus:bg-base-100 text-xs @error('penerbit') input-error @enderror" required />
                            @error('penerbit')
                                <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Inventaris & Pengaturan Rak -->
            <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-6">
                <h2 class="font-bold text-sm text-base-content mb-4 flex items-center gap-2 border-b border-base-200 pb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Inventaris & Lokasi
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Tahun Terbit -->
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs text-base-content/70">Tahun Terbit <span class="text-error">*</span></span>
                        </label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}" class="input input-sm input-bordered rounded-xl bg-base-200/30 focus:bg-base-100 text-xs @error('tahun_terbit') input-error @enderror" required />
                        @error('tahun_terbit')
                            <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs text-base-content/70">Jumlah Stok <span class="text-error">*</span></span>
                        </label>
                        <input type="number" name="stok" value="{{ old('stok', 1) }}" min="0" class="input input-sm input-bordered rounded-xl bg-base-200/30 focus:bg-base-100 text-xs @error('stok') input-error @enderror" required />
                        @error('stok')
                            <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Lokasi Rak -->
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text font-semibold text-xs text-base-content/70">Lokasi Rak <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak') }}" placeholder="Misal: Rak A-01" class="input input-sm input-bordered rounded-xl bg-base-200/30 focus:bg-base-100 text-xs uppercase @error('lokasi_rak') input-error @enderror" required />
                        @error('lokasi_rak')
                            <span class="text-[11px] text-error mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="pt-6 mt-6 border-t border-base-200 flex items-center justify-end gap-3">
                    <a href="{{ url('admin.buku.index') }}" class="btn btn-ghost btn-sm rounded-xl text-xs">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm rounded-xl px-5 shadow-lg shadow-primary/25 text-xs font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Buku
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const imageField = document.getElementById('cover_preview');
        const placeholder = document.getElementById('upload_placeholder');

        reader.onload = function() {
            if (reader.readyState === 2) {
                imageField.src = reader.result;
                imageField.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        }

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endpush
@endsection