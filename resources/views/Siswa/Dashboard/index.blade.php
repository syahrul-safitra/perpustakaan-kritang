<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Anggota — Perpustakaan SMAN 1 Keritang</title>

        <!-- FontAwesome 6 Free -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Vite Assets -->
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>

    <body
        class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

        <!-- Navbar Topbar Glassmorphism -->
        <header
            class="sticky top-0 z-50 w-full border-b border-slate-100/80 bg-white/80 shadow-sm backdrop-blur-xl transition-all">
            <div class="navbar mx-auto flex max-w-7xl items-center justify-between px-4 md:px-6">

                <!-- Brand Logo ZC -->
                <!-- Brand Logo (E-Perpus SMAN 1 Keritang) -->
                <div class="mb-10 mt-2 flex items-center gap-3 px-4">
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl border border-slate-100 bg-white p-1.5 shadow-md shadow-emerald-600/10">
                        <img src="{{ asset("img/logo.png") }}" alt="Logo SMAN 1 Keritang"
                            class="h-full w-full object-contain" />
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-lg font-black leading-tight tracking-tight text-slate-800">E-PERPUS</h1>
                        <p class="text-[9px] font-bold uppercase tracking-wider text-emerald-600">SMAN 1 Keritang</p>
                    </div>
                </div>

                <!-- Navbar Actions & Profile Dropdown -->
                <div class="flex-none items-center gap-3">
                    <a href="{{ url("/katalog") }}"
                        class="btn btn-sm gap-1.5 rounded-xl border-none bg-slate-100 px-3.5 text-xs font-bold text-slate-700 transition-all hover:bg-emerald-50 hover:text-emerald-700">
                        <i class="fa-solid fa-book-open text-xs"></i>
                        <span class="hidden sm:inline">Katalog Buku</span>
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button"
                            class="btn btn-ghost btn-circle avatar border border-slate-200/80 transition-colors hover:border-emerald-500">
                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-800 shadow-inner">
                                {{ strtoupper(substr(Auth::guard("anggota")->user()->nama_lengkap ?? "A", 0, 1)) }}
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="menu menu-sm dropdown-content z-50 mt-3 w-60 space-y-1 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl">
                            <li class="menu-title border-b border-slate-100 px-3 py-2">
                                <span
                                    class="truncate text-xs font-bold text-slate-800">{{ Auth::guard("anggota")->user()->nama_lengkap }}</span>
                                <span class="mt-0.5 block font-mono text-[10px] text-slate-400">NIS/NIP:
                                    {{ Auth::guard("anggota")->user()->nomor_induk }}</span>
                            </li>
                            <li>
                                <form action="{{ url("/anggota/logout") }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center gap-2 rounded-xl py-2 text-left font-bold text-rose-600 hover:bg-rose-50">
                                        <i class="fa-solid fa-right-from-bracket w-4 text-xs"></i> Keluar (Logout)
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="mx-auto w-full max-w-7xl flex-1 space-y-6 p-4 md:p-6">

            <!-- Welcome Banner Light Emerald Style -->
            <div
                class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 p-6 text-white shadow-xl shadow-emerald-900/15 md:p-8">
                <div
                    class="pointer-events-none absolute -bottom-10 -right-10 h-64 w-64 rounded-full bg-white/10 blur-2xl">
                </div>
                <div
                    class="pointer-events-none absolute -left-10 -top-10 h-48 w-48 rounded-full bg-emerald-400/20 blur-xl">
                </div>

                <div class="relative z-10 flex flex-col justify-between gap-4 md:flex-row md:items-center">
                    <div class="max-w-xl space-y-1.5">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full border border-white/20 bg-white/15 px-3 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-100 backdrop-blur-md">
                            <i class="fa-solid fa-circle-check text-emerald-300"></i> Akun Anggota Aktif
                        </span>
                        <h1 class="text-xl font-black tracking-tight md:text-2xl">
                            Selamat Datang, {{ Auth::guard("anggota")->user()->nama_lengkap }}! 👋
                        </h1>
                        <p class="text-xs font-medium leading-relaxed text-emerald-100/90 md:text-sm">
                            Pantau riwayat peminjaman, batas pengembalian buku, serta catatan denda kamu secara
                            real-time di portal perpustakaan.
                        </p>
                    </div>

                    <a href="{{ url("/katalog") }}"
                        class="btn btn-sm shrink-0 gap-2 self-start rounded-2xl border-none bg-white px-5 text-xs font-bold text-emerald-800 shadow-lg shadow-black/10 hover:bg-emerald-50 md:self-auto">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i> Cari Buku Baru
                    </a>
                </div>
            </div>

            <!-- Metric Cards Grid -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                <!-- Card 1: Sedang Dipinjam -->
                <div
                    class="flex items-center justify-between rounded-3xl border border-slate-100 bg-white p-5 shadow-sm transition-all hover:border-emerald-200">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Sedang
                            Dipinjam</span>
                        <div class="text-2xl font-black text-slate-800">
                            {{ $totalSedangDipinjam }} <span class="text-xs font-semibold text-slate-400">Buku</span>
                        </div>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-xl text-amber-600 shadow-sm">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </div>
                </div>

                <!-- Card 2: Peminjaman Selesai -->
                <div
                    class="flex items-center justify-between rounded-3xl border border-slate-100 bg-white p-5 shadow-sm transition-all hover:border-emerald-200">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Transaksi
                            Selesai</span>
                        <div class="text-2xl font-black text-slate-800">
                            {{ $totalSelesai }} <span class="text-xs font-semibold text-slate-400">Peminjaman</span>
                        </div>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-xl text-emerald-600 shadow-sm">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>

                <!-- Card 3: Total Denda -->
                <div
                    class="flex items-center justify-between rounded-3xl border border-slate-100 bg-white p-5 shadow-sm transition-all hover:border-emerald-200">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Denda
                            Dibayar</span>
                        <div class="font-mono text-2xl font-black text-slate-800">
                            Rp {{ number_format($totalDenda, 0, ",", ".") }}
                        </div>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-xl text-rose-600 shadow-sm">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

            </div>

            <!-- Table Riwayat Peminjaman -->
            <div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 p-5">
                    <h2 class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                        <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Riwayat & Status Peminjaman
                    </h2>
                    <span class="text-xs font-semibold text-slate-500">
                        Total: <strong class="font-mono text-emerald-600">{{ count($peminjamans) }}</strong> Transaksi
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left text-xs">
                        <thead>
                            <tr
                                class="border-b border-slate-100 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="px-4 py-3.5">Kode TRX</th>
                                <th class="px-4 py-3.5">Buku Dipinjam</th>
                                <th class="px-4 py-3.5 text-center">Tgl Pinjam / Batas Kembali</th>
                                <th class="px-4 py-3.5 text-center">Status / Denda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse ($peminjamans as $trx)
                                <tr class="transition-colors hover:bg-slate-50/80">
                                    <td class="px-4 py-3.5 font-mono font-bold text-emerald-600">
                                        {{ $trx->kode_transaksi }}
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <ul class="space-y-1">
                                            @foreach ($trx->detailPeminjaman as $detail)
                                                <li
                                                    class="flex max-w-xs items-center gap-1.5 truncate font-semibold text-slate-800">
                                                    <i class="fa-solid fa-book-open text-[10px] text-emerald-500"></i>
                                                    <span>{{ $detail->buku->judul ?? "-" }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-4 py-3.5 text-center font-mono">
                                        <div class="text-slate-600">
                                            <i class="fa-regular fa-calendar-check mr-1 text-slate-400"></i>
                                            {{ date("d/m/Y", strtotime($trx->tanggal_pinjam)) }}
                                        </div>
                                        <div class="mt-0.5 font-bold text-rose-600">
                                            <i class="fa-regular fa-calendar-xmark mr-1 text-rose-400"></i> s/d
                                            {{ date("d/m/Y", strtotime($trx->tanggal_harus_kembali)) }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        @if ($trx->status == "dipinjam")
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full border border-amber-200/60 bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Sedang
                                                Dipinjam
                                            </span>
                                        @elseif($trx->status == "dikembalikan")
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full border border-emerald-200/60 bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Sudah
                                                Kembali
                                            </span>
                                            @if ($trx->total_denda > 0)
                                                <div class="mt-1 font-mono text-[10px] font-bold text-rose-600">
                                                    Denda: Rp {{ number_format($trx->total_denda, 0, ",", ".") }}
                                                </div>
                                            @endif
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
                                    <td colspan="4" class="py-12 text-center italic text-slate-400">
                                        Kamu belum pernah meminjam buku di perpustakaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($peminjamans->hasPages())
                    <div class="border-t border-slate-100 p-4">
                        {{ $peminjamans->links() }}
                    </div>
                @endif
            </div>

        </main>

        <!-- Simple Footer -->
        <footer class="mt-auto border-t border-slate-100 bg-white py-4 text-center text-xs text-slate-400">
            <p>Hak Cipta © {{ date("Y") }} — Perpustakaan SMA Negeri 1 Keritang</p>
        </footer>

    </body>

</html>
