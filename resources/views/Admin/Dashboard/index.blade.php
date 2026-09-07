@extends("Admin.Layouts.main")

@section("title", "Dashboard Admin - E-Perpus SMAN 1 Keritang")
@section("page_heading", "Dashboard Overview")

@section("content")
    <div class="space-y-6">

        <!-- Welcome Hero Card -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-700 p-6 text-white shadow-lg shadow-emerald-900/10 md:p-8">
            <div class="relative z-10 max-w-2xl space-y-2">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold text-emerald-100 backdrop-blur-md">
                    <i class="fa-solid fa-leaf text-xs"></i> E-Perpus SMAN 1 Keritang
                </div>
                <h1 class="text-2xl font-black tracking-tight md:text-3xl">
                    Selamat Datang, {{ Auth::user()->nama_lengkap ?? "Pustakawan" }}! 👋
                </h1>
                <p class="text-xs leading-relaxed opacity-90 md:text-sm">
                    Kelola koleksi buku, data anggota, dan sirkulasi peminjaman perpustakaan sekolah secara efisien dan
                    terstruktur dalam satu panel integrasi.
                </p>
            </div>
            <!-- Lingkaran Ornamen Latar Belakang -->
            <div class="pointer-events-none absolute -bottom-10 -right-10 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
        </div>

        <!-- 4 Grid Stat Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 lg:grid-cols-4">

            <!-- Stat 1: Total Koleksi Buku -->
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Koleksi Buku</p>
                        <h3 class="mt-1 text-2xl font-black text-slate-800">{{ $totalBuku ?? 0 }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 shadow-sm">
                        <i class="fa-solid fa-book text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Siap dipinjam & diakses</span>
                </div>
            </div>

            <!-- Stat 2: Total Anggota -->
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Anggota</p>
                        <h3 class="mt-1 text-2xl font-black text-slate-800">{{ $totalAnggota ?? 0 }}</h3>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 shadow-sm">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-xs font-medium text-slate-500">
                    <i class="fa-solid fa-user-graduate"></i>
                    <span>Siswa & Guru terdaftar</span>
                </div>
            </div>

            <!-- Stat 3: Peminjaman Aktif -->
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Sedang Dipinjam</p>
                        <h3 class="mt-1 text-2xl font-black text-slate-800">{{ $totalDipinjam ?? 0 }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 shadow-sm">
                        <i class="fa-solid fa-book-bookmark text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                    <i class="fa-solid fa-clock"></i>
                    <span>Transaksi belum kembali</span>
                </div>
            </div>

            <!-- Stat 4: Total Selesai -->
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Pengembalian Selesai</p>
                        <h3 class="mt-1 text-2xl font-black text-slate-800">{{ $totalPengembalian ?? 0 }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-50 text-purple-600 shadow-sm">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-xs font-medium text-slate-500">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Riwayat transaksi</span>
                </div>
            </div>

        </div>

        <!-- Grid 2 Column Section -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- Kolom Kiri (2 Cols): Transaksi Peminjaman Terbaru -->
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Transaksi Peminjaman Terbaru</h3>
                        <p class="text-xs text-slate-400">Daftar aktivitas sirkulasi buku terakhir yang dicatat</p>
                    </div>
                    <a href="{{ url("admin/peminjaman") }}"
                        class="btn btn-xs rounded-xl border-none bg-emerald-50 px-3 font-bold text-emerald-600 hover:bg-emerald-100">
                        Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left text-xs">
                        <thead>
                            <tr
                                class="border-b border-slate-100 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="px-2 pb-3">Kode TRX</th>
                                <th class="px-2 pb-3">Peminjam</th>
                                <th class="px-2 pb-3">Tgl Pinjam</th>
                                <th class="px-2 pb-3">Batas Kembali</th>
                                <th class="px-2 pb-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($peminjamanTerbaru ?? [] as $trx)
                                <tr class="transition-colors hover:bg-slate-50/70">
                                    <td class="px-2 py-3 font-mono font-bold text-emerald-600">
                                        {{ $trx->kode_transaksi }}
                                    </td>
                                    <td class="px-2 py-3">
                                        <div class="font-bold text-slate-800">{{ $trx->anggota->nama_lengkap ?? "-" }}</div>
                                        <div class="font-mono text-[10px] text-slate-400">
                                            {{ $trx->anggota->nomor_induk ?? "-" }}</div>
                                    </td>
                                    <td class="px-2 py-3">
                                        {{ date("d/m/Y", strtotime($trx->tanggal_pinjam)) }}
                                    </td>
                                    <td class="px-2 py-3 font-semibold text-rose-500">
                                        {{ date("d/m/Y", strtotime($trx->tanggal_harus_kembali)) }}
                                    </td>
                                    <td class="px-2 py-3 text-center">
                                        @if ($trx->status == "dipinjam")
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full border border-amber-200/60 bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Dipinjam
                                            </span>
                                        @elseif($trx->status == "dikembalikan")
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full border border-emerald-200/60 bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Kembali
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full border border-rose-200/60 bg-rose-50 px-2.5 py-1 text-[10px] font-bold text-rose-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Terlambat
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center italic text-slate-400">
                                        Belum ada transaksi peminjaman terbaru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kolom Kanan (1 Col): Aksi Pintas & Info Sistem -->
            <div class="space-y-6">

                <!-- Card Pintasan Aksi Cepat -->
                <div class="space-y-4 rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="text-base font-bold text-slate-800">Aksi Pintas Pustakawan</h3>

                    <div class="grid grid-cols-1 gap-2.5">
                        <a href="{{ url("admin/peminjaman/create") }}"
                            class="group flex items-center gap-3 rounded-2xl border border-slate-100 p-3 transition-all hover:border-emerald-200 hover:bg-emerald-50">
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500 font-bold text-white transition-transform group-hover:scale-105">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800 group-hover:text-emerald-700">Catat Peminjaman
                                </p>
                                <p class="text-[10px] text-slate-400">Buat transaksi sirkulasi baru</p>
                            </div>
                        </a>

                        <a href="{{ url("admin/buku") }}"
                            class="group flex items-center gap-3 rounded-2xl border border-slate-100 p-3 transition-all hover:border-emerald-200 hover:bg-emerald-50">
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-500 font-bold text-white transition-transform group-hover:scale-105">
                                <i class="fa-solid fa-book-medical text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800 group-hover:text-emerald-700">Kelola Koleksi Buku
                                </p>
                                <p class="text-[10px] text-slate-400">Tambah / ubah stok katalog</p>
                            </div>
                        </a>

                        <a href="{{ url("admin/laporan") }}"
                            class="group flex items-center gap-3 rounded-2xl border border-slate-100 p-3 transition-all hover:border-emerald-200 hover:bg-emerald-50">
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-500 font-bold text-white transition-transform group-hover:scale-105">
                                <i class="fa-solid fa-file-pdf text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800 group-hover:text-emerald-700">Cetak Laporan PDF
                                </p>
                                <p class="text-[10px] text-slate-400">Rekapitulasi bulanan & denda</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Card Info Sistem -->
                <div class="space-y-3 rounded-3xl border border-slate-100 bg-slate-50/60 p-6">
                    <div class="flex items-center gap-2 text-xs font-bold text-emerald-600">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Status Sistem E-Perpus</span>
                    </div>
                    <p class="text-xs leading-relaxed text-slate-500">
                        Sistem berjalan normal dengan keamanan Multi-Auth Guard (`web` & `anggota`).
                    </p>
                    <div
                        class="flex items-center justify-between border-t border-slate-200/60 pt-2 text-[11px] font-medium text-slate-400">
                        <span>SMAN 1 Keritang</span>
                        <span class="font-mono font-bold text-emerald-600">Zen Code v1.0</span>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
