@extends('Admin.Layouts.main')

@section('title', 'Dashboard Utama - Admin Perpustakaan')
@section('breadcrumb_active', 'Dashboard')

@section('content')

<!-- Welcome Banner / Greeting Card -->
<div class="card bg-gradient-to-r from-primary to-emerald-600 text-primary-content shadow-xl shadow-primary/20 rounded-3xl p-6 md:p-8 mb-8 relative overflow-hidden">
    <!-- Dekorasi Background Tipis -->
    <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
    </div>

    <div class="relative z-10">
        <span class="inline-block px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold uppercase tracking-wider mb-3">
            Sistem Informasi Perpustakaan SMAN 1 Keritang
        </span>
        <h1 class="text-2xl md:text-3xl font-black tracking-tight mb-2">Selamat Datang, Pustakawan! 👋</h1>
        <p class="text-xs md:text-sm text-primary-content/90 max-w-xl">
            Kelola data buku, sirkulasi peminjaman, serta rekapitulasi anggota dengan cepat, mudah, dan terintegrasi dalam satu platform modern.
        </p>
    </div>
</div>

<!-- Statistik Cards (Grid 4 Kolom) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    
    <!-- Card 1: Total Judul Buku -->
    <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-5">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Judul Buku</span>
                <span class="text-2xl md:text-3xl font-black text-base-content mt-1">{{ number_format($totalKoleksi) }}</span>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Koleksi Terdaftar
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Eksemplar Stok -->
    <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-5">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Total Eksemplar</span>
                <span class="text-2xl md:text-3xl font-black text-base-content mt-1">{{ number_format($totalBuku) }}</span>
                <span class="text-[11px] text-base-content/50 mt-1">Jumlah fisik buku</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Anggota Aktif -->
    <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-5">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Anggota Aktif</span>
                <span class="text-2xl md:text-3xl font-black text-base-content mt-1">{{ number_format($totalAnggota) }}</span>
                <span class="text-[11px] text-base-content/50 mt-1">Siswa & Guru</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-accent/10 text-accent flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
        </div>
    </div>

    <!-- Card 4: Sedang Dipinjam -->
    <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl p-5">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Sedang Dipinjam</span>
                <span class="text-2xl md:text-3xl font-black text-warning mt-1">{{ number_format($totalDipinjam) }}</span>
                <span class="text-[11px] text-base-content/50 mt-1">Transaksi aktif</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-warning/10 text-warning flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
            </div>
        </div>
    </div>

</div>

<!-- Bagian Bawah: Tabel Peminjaman Terbaru & Kategori -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Tabel Peminjaman Aktif Terbaru (8 Cols) -->
    <div class="lg:col-span-8 card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl overflow-hidden">
        <div class="card-body p-5 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-base text-base-content">Peminjaman Aktif Terbaru</h2>
                <a href="{{ url('/admin/peminjaman') }}" class="text-xs font-semibold text-primary hover:underline">Lihat Semua →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full text-left">
                    <thead>
                        <tr class="bg-base-200/50 text-base-content/70 text-xs font-semibold uppercase tracking-wider border-b border-base-200">
                            <th class="rounded-l-xl py-3">Kode TRX & Anggota</th>
                            <th>Buku Dipinjam</th>
                            <th class="rounded-r-xl text-center">Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-base-200/60 text-sm">
                        @forelse ($peminjamanTerbaru as $trx)
                            <tr class="hover:bg-base-200/30 transition-colors">
                                <td class="py-3">
                                    <span class="font-mono text-xs font-bold text-primary">{{ $trx->kode_transaksi }}</span>
                                    <div class="font-semibold text-base-content mt-0.5">{{ $trx->anggota->nama_lengkap }}</div>
                                </td>
                                <td>
                                    <ul class="list-disc list-inside text-xs text-base-content/70">
                                        @foreach($trx->detailPeminjaman as $detail)
                                            <li class="truncate max-w-[200px]">{{ $detail->buku->judul }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <span class="text-xs font-medium {{ \Carbon\Carbon::parse($trx->tanggal_harus_kembali)->isPast() ? 'text-error font-bold' : 'text-base-content/70' }}">
                                        {{ \Carbon\Carbon::parse($trx->tanggal_harus_kembali)->format('d M Y') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-8 text-xs text-base-content/50">Belum ada peminjaman aktif saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistik Kategori Buku (4 Cols) -->
    <div class="lg:col-span-4 card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl overflow-hidden">
        <div class="card-body p-5 md:p-6">
            <h2 class="font-bold text-base text-base-content mb-4">Koleksi per Kategori</h2>
            
            <div class="space-y-3">
                @forelse ($kategoris as $kat)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-base-200/40 border border-base-200/60">
                        <div class="flex flex-col">
                            <span class="font-semibold text-xs text-base-content">{{ $kat->nama_kategori }}</span>
                            <span class="font-mono text-[10px] text-base-content/40">Kode: {{ $kat->kode_kategori }}</span>
                        </div>
                        <span class="badge badge-primary badge-sm font-bold font-mono">{{ $kat->bukus_count }} Buku</span>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-base-content/50">Belum ada kategori terdaftar.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection