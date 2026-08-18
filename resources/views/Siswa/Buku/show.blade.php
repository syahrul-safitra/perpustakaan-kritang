@extends("Siswa.Layouts.main")

@section("title", $buku->judul . " - Detail Buku E-Perpus")

@section("content")
    <div class="space-y-6">

        <!-- Breadcrumb Navigation -->
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
            <a href="{{ url("/katalog") }}" class="flex items-center gap-1.5 transition-colors hover:text-emerald-600">
                <i class="fa-solid fa-book-open text-emerald-500"></i> Katalog Utama
            </a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
            <span class="max-w-xs truncate font-bold text-slate-700">{{ $buku->judul }}</span>
        </div>

        <!-- Main Detail Card -->
        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8 lg:p-10">

            <div class="grid grid-cols-1 items-start gap-8 md:grid-cols-12 lg:gap-12">

                <!-- Kolom Kiri: Cover Buku & Action Buttons (4 Cols) -->
                <div class="flex flex-col items-center md:col-span-4 lg:col-span-4">

                    <!-- Display Cover dengan Gradient Shadow -->
                    <div
                        class="group relative aspect-[3/4] w-full max-w-[260px] overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 shadow-xl shadow-slate-200/60">
                        @if ($buku->cover)
                            <img src="{{ asset("storage/" . $buku->cover) }}" alt="{{ $buku->judul }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset("uploads/buku/" . $buku->cover) }}';" />
                        @else
                            <div
                                class="flex h-full w-full flex-col items-center justify-center p-6 text-center text-slate-300">
                                <i class="fa-solid fa-book-open mb-3 text-5xl text-slate-200"></i>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Sampul Tidak
                                    Tersedia</span>
                            </div>
                        @endif

                        <!-- Overlay Category Badge -->
                        <div class="absolute left-3 top-3">
                            <span
                                class="inline-block rounded-xl border border-slate-100 bg-white/95 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700 shadow-sm backdrop-blur-md">
                                {{ $buku->kategori->nama_kategori ?? "Umum" }}
                            </span>
                        </div>
                    </div>

                    <!-- Status Ketersediaan & Action Button -->
                    <div class="mt-6 w-full max-w-[260px] space-y-3">
                        @if ($buku->stok > 0)
                            <div
                                class="flex items-center justify-center gap-2 rounded-2xl border border-emerald-200/80 bg-emerald-50 px-4 py-3 text-xs font-bold text-emerald-700 shadow-sm">
                                <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></span>
                                Buku Tersedia ({{ $buku->stok }} Eksemplar)
                            </div>
                        @else
                            <div
                                class="flex items-center justify-center gap-2 rounded-2xl border border-rose-200/80 bg-rose-50 px-4 py-3 text-xs font-bold text-rose-700 shadow-sm">
                                <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                Stok Fisik Habis
                            </div>
                        @endif

                        <a href="{{ url("/katalog") }}"
                            class="btn btn-sm h-10 w-full gap-2 rounded-2xl border-none bg-slate-100 text-xs font-bold text-slate-700 transition-colors hover:bg-slate-200">
                            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Katalog
                        </a>
                    </div>
                </div>

                <!-- Kolom Kanan: Informasi Detail Buku (8 Cols) -->
                <div class="flex flex-col justify-between space-y-6 md:col-span-8 lg:col-span-8">

                    <!-- Judul & Penulis Header -->
                    <div class="space-y-2 border-b border-slate-100 pb-5">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-3 py-1 text-xs font-bold tracking-wider text-emerald-700">
                            <i class="fa-solid fa-bookmark text-[10px]"></i> {{ $buku->kategori->nama_kategori ?? "Umum" }}
                        </span>
                        <h1 class="text-2xl font-black leading-snug tracking-tight text-slate-800 sm:text-3xl">
                            {{ $buku->judul }}
                        </h1>
                        <p class="flex items-center gap-2 pt-1 text-xs font-medium text-slate-500 sm:text-sm">
                            <span>Penulis: <strong class="text-slate-700">{{ $buku->pengarang }}</strong></span>
                        </p>
                    </div>

                    <!-- Informasi Spesifikasi Publikasi -->
                    <div class="space-y-4 rounded-2xl border border-slate-100 bg-slate-50/70 p-5 sm:p-6">
                        <h3
                            class="flex items-center gap-2 border-b border-slate-200/60 pb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                            <i class="fa-solid fa-circle-info text-emerald-600"></i> Informasi Spesifikasi Buku
                        </h3>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-4 text-xs sm:grid-cols-2">
                            <!-- Penerbit -->
                            <div class="flex flex-col gap-1">
                                <span
                                    class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Penerbit</span>
                                <span class="font-bold text-slate-700">{{ $buku->penerbit }}</span>
                            </div>

                            <!-- Tahun Terbit -->
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Tahun
                                    Terbit</span>
                                <span class="font-mono font-bold text-slate-700">{{ $buku->tahun_terbit }}</span>
                            </div>

                            <!-- ISBN -->
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Nomor
                                    ISBN</span>
                                <span
                                    class="font-mono font-bold text-slate-700">{{ $buku->isbn ?? "Tidak ada data" }}</span>
                            </div>

                            <!-- Kategori -->
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Klasifikasi
                                    Kategori</span>
                                <span class="font-bold text-slate-700">{{ $buku->kategori->nama_kategori ?? "-" }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Highlight Box: Lokasi Fisik Rak -->
                    <div
                        class="flex items-start gap-4 rounded-2xl border border-emerald-200/70 bg-emerald-50/60 p-5 shadow-sm">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-lg text-white shadow-md shadow-emerald-600/20">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div class="space-y-1">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">Lokasi Fisik Rak Buku</h4>
                            <p class="text-xs text-slate-500">Temukan buku ini secara langsung di perpustakaan SMAN 1
                                Keritang pada rak berikut:</p>
                            <div class="pt-1.5">
                                <span
                                    class="inline-block rounded-xl border border-emerald-200 bg-white px-3.5 py-1.5 font-mono text-xs font-bold text-emerald-700 shadow-sm">
                                    <i class="fa-solid fa-location-dot mr-1.5 text-emerald-500"></i>
                                    {{ $buku->lokasi_rak }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
