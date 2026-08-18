@extends('Siswa.Layouts.main')

@section('title', 'Katalog Buku - SMAN 1 Keritang')

@section('content')

<!-- Hero Section & Search Bar -->
<div class="flex flex-col items-center justify-center text-center space-y-4 mb-10 mt-4 md:mt-8">
    <div class="inline-block px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold tracking-wider mb-2 border border-emerald-200">
        JELAJAHI KOLEKSI KAMI
    </div>
    <h1 class="text-3xl md:text-4xl font-black text-base-content tracking-tight">Katalog Perpustakaan Digital</h1>
    <p class="text-sm text-base-content/60 max-w-xl">Cari buku pelajaran, fiksi, maupun ensiklopedia dengan mudah. Cek ketersediaan stok sebelum mengunjungi perpustakaan.</p>

    <!-- Search Form -->
    <form action="{{ url('/katalog') }}" method="GET" class="w-full max-w-2xl mt-6 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-base-content/40">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik judul buku, pengarang, atau penerbit..." class="input input-bordered input-md rounded-2xl pl-11 w-full bg-base-100 shadow-sm focus:ring-2 focus:ring-primary/20 transition-all text-sm" />
        </div>
        
        <select name="kategori_id" class="select select-bordered select-md rounded-2xl bg-base-100 shadow-sm text-sm sm:w-48">
            <option value="">Semua Kategori</option>
            @foreach($kategoriList as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
        
        <button type="submit" class="btn btn-primary btn-md rounded-2xl px-6 shadow-lg shadow-primary/30">Cari</button>
    </form>
</div>

<!-- Book Grid Display -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 md:gap-6">
    @forelse ($bukus as $buku)
        <div class="card bg-base-100 border border-base-200/80 shadow-md hover:shadow-xl transition-all duration-300 rounded-2xl overflow-hidden group flex flex-col h-full">

            <!-- Image Cover Container (Dibungkus Link) -->
            <a href="{{ url('/katalog/' . $buku->id) }}" class="relative aspect-[3/4] bg-base-200 overflow-hidden w-full block">
                <!-- (Isi cover tetap sama) -->
                @if ($buku->cover)
                    <img src="{{ asset("uploads/buku/" . $buku->cover) }}" alt="{{ $buku->judul }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" />
                @else
                    <div class="flex items-center justify-center w-full h-full text-base-content/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                @endif
                
                <div class="absolute top-2 left-2">
                    <span class="badge bg-base-100/90 backdrop-blur-sm border-0 shadow-sm text-[10px] font-bold text-primary">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                </div>
            </a>

            <div class="p-4 flex flex-col flex-1">
                <!-- Judul (Dibungkus Link) -->
                <a href="{{ url('/katalog/' . $buku->id) }}">
                    <h3 class="font-bold text-sm text-base-content leading-tight line-clamp-2 mb-1 group-hover:text-primary transition-colors" title="{{ $buku->judul }}">
                        {{ $buku->judul }}
                    </h3>
                </a>
                <p class="text-[11px] text-base-content/60 mb-3">{{ $buku->pengarang }}</p>
                
                <div class="mt-auto space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono text-base-content/50 bg-base-200 px-1.5 py-0.5 rounded">{{ $buku->lokasi_rak }}</span>
                        
                        @if($buku->stok > 0)
                            <span class="text-[11px] font-bold text-emerald-600">Tersedia ({{ $buku->stok }})</span>
                        @else
                            <span class="text-[11px] font-bold text-error">Habis</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-base-100 rounded-3xl border border-base-200 border-dashed">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <h2 class="text-lg font-bold text-base-content">Buku Tidak Ditemukan</h2>
            <p class="text-sm text-base-content/50 mt-1 max-w-sm">Maaf, buku yang Anda cari belum tersedia di koleksi perpustakaan kami.</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if ($bukus->hasPages())
    <div class="mt-10 flex justify-center">
        {{ $bukus->links() }}
    </div>
@endif

@endsection