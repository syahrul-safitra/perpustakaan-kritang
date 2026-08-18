@extends('Siswa.Layouts.main')

@section('title', $buku->judul . ' - Detail Buku')

@section('content')
<!-- Breadcrumb Navigation -->
<div class="text-xs breadcrumbs text-base-content/60 mb-6">
    <ul>
        <li><a href="{{ url('/katalog') }}" class="hover:text-primary transition-colors">Katalog Perpustakaan</a></li>
        <li><span class="text-base-content/80 font-semibold truncate max-w-xs">{{ $buku->judul }}</span></li>
    </ul>
</div>

<!-- Main Detail Card -->
<div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-3xl overflow-hidden p-6 md:p-8 lg:p-10">
    
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12">
        
        <!-- Kolom Kiri: Cover Buku (4 Cols) -->
        <div class="md:col-span-4 lg:col-span-3 flex flex-col items-center">
            <div class="w-full max-w-[240px] aspect-[3/4] rounded-2xl overflow-hidden shadow-2xl shadow-base-300/50 border border-base-200 relative group">
                @if ($buku->cover)
                    <img src="{{ asset("uploads/buku/" . $buku->cover) }}" alt="{{ $buku->judul }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" />
                @else
                    <div class="w-full h-full bg-base-200 flex flex-col items-center justify-center text-base-content/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        <span class="text-xs font-medium">Cover Tidak Tersedia</span>
                    </div>
                @endif
            </div>

            <!-- Status Ketersediaan (Mobile & Desktop) -->
            <div class="w-full max-w-[240px] mt-6 flex flex-col gap-3">
                @if($buku->stok > 0)
                    <div class="flex items-center justify-center gap-2 bg-emerald-50 text-emerald-700 border border-emerald-200 py-3 px-4 rounded-xl font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Buku Tersedia ({{ $buku->stok }})
                    </div>
                @else
                    <div class="flex items-center justify-center gap-2 bg-rose-50 text-rose-700 border border-rose-200 py-3 px-4 rounded-xl font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Stok Habis
                    </div>
                @endif

                <a href="{{ url('/katalog') }}" class="btn btn-ghost border border-base-200 rounded-xl w-full text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke Katalog
                </a>
            </div>
        </div>

        <!-- Kolom Kanan: Informasi Buku (8 Cols) -->
        <div class="md:col-span-8 lg:col-span-9 flex flex-col">
            
            <div class="mb-6">
                <span class="badge bg-primary/10 text-primary border-primary/20 font-bold px-3 py-3 rounded-lg mb-4">
                    {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                </span>
                <h1 class="text-3xl lg:text-4xl font-black text-base-content leading-tight mb-2">{{ $buku->judul }}</h1>
                <p class="text-lg text-base-content/70 font-medium">Oleh <span class="text-base-content">{{ $buku->pengarang }}</span></p>
            </div>

            <!-- Tabel Informasi Terstruktur -->
            <div class="bg-base-200/40 rounded-2xl border border-base-200 p-5 md:p-6 flex-1">
                <h3 class="font-bold text-base-content mb-4 border-b border-base-200 pb-2">Informasi Detail Publikasi</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                    <!-- Penulis -->
                    <div class="flex flex-col">
                        <span class="text-base-content/50 text-xs font-semibold uppercase tracking-wider mb-1">Penulis / Pengarang</span>
                        <span class="font-medium text-base-content">{{ $buku->pengarang }}</span>
                    </div>

                    <!-- Penerbit -->
                    <div class="flex flex-col">
                        <span class="text-base-content/50 text-xs font-semibold uppercase tracking-wider mb-1">Penerbit</span>
                        <span class="font-medium text-base-content">{{ $buku->penerbit }}</span>
                    </div>

                    <!-- Tahun Terbit -->
                    <div class="flex flex-col">
                        <span class="text-base-content/50 text-xs font-semibold uppercase tracking-wider mb-1">Tahun Terbit</span>
                        <span class="font-medium text-base-content">{{ $buku->tahun_terbit }}</span>
                    </div>

                    <!-- ISBN -->
                    <div class="flex flex-col">
                        <span class="text-base-content/50 text-xs font-semibold uppercase tracking-wider mb-1">Nomor ISBN</span>
                        <span class="font-mono font-medium text-base-content">{{ $buku->isbn ?? 'Tidak ada data' }}</span>
                    </div>

                    <!-- Kategori -->
                    <div class="flex flex-col">
                        <span class="text-base-content/50 text-xs font-semibold uppercase tracking-wider mb-1">Klasifikasi / Kategori</span>
                        <span class="font-medium text-base-content">{{ $buku->kategori->nama_kategori ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Box Lokasi Fisik Rak -->
            <div class="mt-6 bg-primary/5 border border-primary/20 rounded-2xl p-5 flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-base-content text-sm">Lokasi Fisik Buku</h4>
                    <p class="text-xs text-base-content/70 mt-1 mb-2">Temukan buku ini secara fisik di perpustakaan pada rak berikut:</p>
                    <span class="inline-block bg-base-100 border border-base-300 font-mono font-bold px-3 py-1.5 rounded-lg text-primary shadow-sm text-sm">
                        {{ $buku->lokasi_rak }}
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection