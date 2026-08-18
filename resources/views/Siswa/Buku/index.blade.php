@extends("Siswa.Layouts.main")

@section("title", "Katalog Buku Digital - E-Perpus SMAN 1 Keritang")

@section("content")
    <div class="space-y-8">

        <!-- Hero Section & Search Container -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 p-6 text-white shadow-xl shadow-emerald-900/15 sm:p-10">

            <!-- Background Ambient Circles -->
            <div class="pointer-events-none absolute -bottom-10 -right-10 h-64 w-64 rounded-full bg-white/10 blur-2xl"></div>
            <div class="pointer-events-none absolute -left-10 -top-10 h-48 w-48 rounded-full bg-emerald-400/20 blur-xl">
            </div>

            <div class="relative z-10 mx-auto max-w-2xl space-y-3 text-center">
                <span
                    class="inline-flex items-center gap-1.5 rounded-full border border-white/20 bg-white/15 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-emerald-100 backdrop-blur-md">
                    <i class="fa-solid fa-sparkles text-amber-300"></i> Jelajahi Koleksi Digital
                </span>
                <h1 class="text-2xl font-black leading-tight tracking-tight sm:text-4xl">
                    Katalog Perpustakaan SMAN 1 Keritang
                </h1>
                <p class="text-xs font-medium text-emerald-100/90 sm:text-sm">
                    Cari buku pelajaran, fiksi, referensi, maupun ensiklopedia dengan cepat. Periksa ketersediaan stok fisik
                    secara real-time.
                </p>

                <!-- Integrated Search Form -->
                <form action="{{ url("/katalog") }}" method="GET"
                    class="mx-auto flex max-w-xl flex-col gap-2.5 pt-4 sm:flex-row">
                    <div class="relative flex-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" name="search" value="{{ request("search") }}"
                            placeholder="Ketik judul buku, pengarang, atau ISBN..."
                            class="input input-sm sm:input-md w-full rounded-2xl border-none bg-white pl-9 text-xs text-slate-800 shadow-md placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400" />
                    </div>

                    <select name="kategori_id"
                        class="select select-sm sm:select-md rounded-2xl border-none bg-white text-xs font-semibold text-slate-700 shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-400 sm:w-44">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ request("kategori_id") == $kat->id ? "selected" : "" }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="btn btn-sm sm:btn-md gap-1.5 rounded-2xl border-none bg-slate-900 px-6 text-xs font-bold text-white shadow-lg shadow-slate-900/30 hover:bg-slate-800">
                        <i class="fa-solid fa-filter text-xs"></i> Cari
                    </button>
                </form>
            </div>
        </div>

        <!-- Active Filter Status Indicator -->
        @if (request("search") || request("kategori_id"))
            <div
                class="flex items-center justify-between rounded-2xl border border-emerald-200/60 bg-emerald-50 p-4 text-xs text-emerald-800">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-emerald-600"></i>
                    <span>Menampilkan hasil pencarian
                        @if (request("search"))
                            untuk "<strong>{{ request("search") }}</strong>"
                        @endif
                    </span>
                </div>
                <a href="{{ url("/katalog") }}" class="flex items-center gap-1 font-bold text-emerald-700 hover:underline">
                    <i class="fa-solid fa-rotate-right text-[10px]"></i> Reset Filter
                </a>
            </div>
        @endif

        <!-- Book Grid Display -->
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 md:gap-5 lg:grid-cols-5 xl:grid-cols-6">
            @forelse ($bukus as $buku)
                <div
                    class="group flex h-full flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:border-emerald-200 hover:shadow-xl">

                    <!-- Image Cover Container -->
                    <a href="{{ url("/katalog/" . $buku->id) }}"
                        class="relative block aspect-[3/4] w-full overflow-hidden bg-slate-100">
                        @if ($buku->cover)
                            <img src="{{ asset("storage/" . $buku->cover) }}" alt="{{ $buku->judul }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset("uploads/buku/" . $buku->cover) }}';" />
                        @else
                            <div
                                class="flex h-full w-full flex-col items-center justify-center gap-2 p-4 text-center text-slate-300">
                                <i class="fa-solid fa-book-open text-3xl"></i>
                                <span class="text-[9px] font-semibold uppercase text-slate-400">Tanpa Sampul</span>
                            </div>
                        @endif

                        <!-- Category Badge -->
                        <div class="absolute left-2.5 top-2.5">
                            <span
                                class="inline-block rounded-lg border border-slate-100 bg-white/90 px-2 py-0.5 text-[9px] font-bold text-emerald-700 shadow-sm backdrop-blur-md">
                                {{ $buku->kategori->nama_kategori ?? "Umum" }}
                            </span>
                        </div>
                    </a>

                    <!-- Content Info -->
                    <div class="flex flex-1 flex-col p-3.5">
                        <a href="{{ url("/katalog/" . $buku->id) }}" class="block">
                            <h3 class="mb-1 line-clamp-2 text-xs font-bold leading-snug text-slate-800 transition-colors group-hover:text-emerald-600"
                                title="{{ $buku->judul }}">
                                {{ $buku->judul }}
                            </h3>
                        </a>
                        <p class="mb-3 truncate text-[10px] font-medium text-slate-400">
                            <i class="fa-regular fa-user mr-1 text-[9px]"></i>{{ $buku->pengarang }}
                        </p>

                        <!-- Rak Location & Stock Status Footer -->
                        <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-2 text-[10px]">
                            <span
                                class="rounded-md bg-slate-100 px-1.5 py-0.5 font-mono font-bold uppercase text-slate-500">
                                {{ $buku->lokasi_rak }}
                            </span>

                            @if ($buku->stok > 0)
                                <span class="flex items-center gap-1 font-bold text-emerald-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> {{ $buku->stok }} Ada
                                </span>
                            @else
                                <span class="flex items-center gap-1 font-bold text-rose-500">
                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Habis
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div
                    class="col-span-full flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-100 bg-white py-16 text-center shadow-sm">
                    <div
                        class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50 text-2xl text-slate-300">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </div>
                    <h2 class="text-base font-bold text-slate-800">Buku Tidak Ditemukan</h2>
                    <p class="mt-1 max-w-sm text-xs text-slate-400">Maaf, koleksi buku yang Anda cari belum tersedia dalam
                        katalog perpustakaan saat ini.</p>
                    <a href="{{ url("/katalog") }}"
                        class="btn btn-xs mt-4 rounded-xl border-none bg-slate-100 px-4 font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                        Lihat Semua Buku
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination Container -->
        @if ($bukus->hasPages())
            <div class="flex justify-center pt-4">
                {{ $bukus->links() }}
            </div>
        @endif

    </div>
@endsection
