<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota - Perpustakaan SMAN 1 Keritang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200 min-h-screen flex flex-col">

    <!-- Navbar Topbar -->
    <header class="sticky top-0 z-50 w-full bg-base-100/90 backdrop-blur-md border-b border-base-200/80 shadow-sm">
        <div class="max-w-7xl mx-auto navbar px-4 md:px-6">
            <div class="flex-1">
                <a href="{{ url('/anggota/dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center font-bold">
                        📚
                    </div>
                    <span class="font-black text-base md:text-lg tracking-tight text-base-content">Portal Anggota</span>
                </a>
            </div>
            
            <div class="flex-none gap-3">
                <a href="{{ url('/katalog') }}" class="btn btn-ghost btn-sm text-xs font-semibold rounded-xl">
                    Katalog Buku
                </a>
                
                <!-- Profile / Logout Dropdown -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar border border-base-300">
                        <div class="w-8 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(Auth::guard('anggota')->user()->nama_lengkap ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                    <ul tabindex="0" class="mt-3 z-50 p-2 shadow-xl menu menu-sm dropdown-content bg-base-100 rounded-2xl w-56 border border-base-200">
                        <li class="menu-title px-3 py-2">
                            <span class="text-xs font-bold text-base-content">{{ Auth::guard('anggota')->user()->nama_lengkap }}</span>
                            <span class="text-[10px] text-base-content/60 font-normal truncate">NO: {{ Auth::guard('anggota')->user()->nomor_induk }}</span>
                        </li>
                        <div class="divider my-0"></div>
                        <li>
                            <form action="{{ url('/anggota/logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="text-error font-semibold flex items-center gap-2 w-full text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6 space-y-6">

        <!-- Welcome Banner -->
        <div class="card bg-gradient-to-r from-secondary/90 to-primary/90 text-white shadow-xl rounded-3xl overflow-hidden">
            <div class="card-body p-6 md:p-8">
                <h1 class="text-xl md:text-2xl font-black">Halo, {{ Auth::guard('anggota')->user()->nama_lengkap }}! 👋</h1>
                <p class="text-xs md:text-sm opacity-90">
                    Selamat datang di Portal Perpustakaan. Pantau status peminjaman buku kamu secara real-time di sini.
                </p>
            </div>
        </div>

        <!-- Metric Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Card 1: Sedang Dipinjam -->
            <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-md rounded-2xl p-5 flex flex-row items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-warning/10 text-warning flex items-center justify-center font-bold text-xl">
                    📖
                </div>
                <div>
                    <div class="text-xs text-base-content/60 font-semibold uppercase">Sedang Dipinjam</div>
                    <div class="text-2xl font-black text-base-content mt-0.5">{{ $totalSedangDipinjam }} <span class="text-xs font-normal text-base-content/50">Buku</span></div>
                </div>
            </div>

            <!-- Card 2: Peminjaman Selesai -->
            <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-md rounded-2xl p-5 flex flex-row items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-success/10 text-success flex items-center justify-center font-bold text-xl">
                    ✅
                </div>
                <div>
                    <div class="text-xs text-base-content/60 font-semibold uppercase">Total Selesai</div>
                    <div class="text-2xl font-black text-base-content mt-0.5">{{ $totalSelesai }} <span class="text-xs font-normal text-base-content/50">Transaksi</span></div>
                </div>
            </div>

            <!-- Card 3: Total Denda -->
            <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-md rounded-2xl p-5 flex flex-row items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-error/10 text-error flex items-center justify-center font-bold text-xl">
                    💰
                </div>
                <div>
                    <div class="text-xs text-base-content/60 font-semibold uppercase">Total Denda Dibayar</div>
                    <div class="text-2xl font-black text-base-content mt-0.5">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                </div>
            </div>

        </div>

        <!-- Table Riwayat Peminjaman -->
        <div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl rounded-2xl overflow-hidden">
            <div class="card-body p-5 md:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-base text-base-content">Riwayat & Status Peminjaman Buku</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full text-left">
                        <thead>
                            <tr class="bg-base-200/50 text-base-content/70 text-xs font-semibold uppercase border-b border-base-200">
                                <th class="py-3">Kode TRX</th>
                                <th>Buku Dipinjam</th>
                                <th class="text-center">Tgl Pinjam / Batas Kembali</th>
                                <th class="text-center">Status / Denda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-base-200/60 text-sm">
                            @forelse ($peminjamans as $trx)
                                <tr class="hover:bg-base-200/30 transition-colors">
                                    <td class="font-mono text-xs font-bold text-secondary">
                                        {{ $trx->kode_transaksi }}
                                    </td>
                                    <td>
                                        <ul class="list-disc list-inside text-xs text-base-content/80">
                                            @foreach($trx->detailPeminjaman as $detail)
                                                <li class="font-medium">{{ $detail->buku->judul ?? '-' }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="text-center text-xs">
                                        <div>{{ date('d/m/Y', strtotime($trx->tanggal_pinjam)) }}</div>
                                        <div class="text-error font-semibold mt-0.5">s/d {{ date('d/m/Y', strtotime($trx->tanggal_harus_kembali)) }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($trx->status == 'dipinjam')
                                            <span class="badge badge-warning badge-sm font-bold">SEDANG DIPINJAM</span>
                                        @elseif($trx->status == 'dikembalikan')
                                            <span class="badge badge-success badge-sm font-bold text-white">SUDAH KEMBALI</span>
                                            @if($trx->total_denda > 0)
                                                <div class="text-[10px] text-error font-bold mt-1">Denda: Rp {{ number_format($trx->total_denda, 0, ',', '.') }}</div>
                                            @endif
                                        @else
                                            <span class="badge badge-error badge-sm font-bold text-white">TERLAMBAT</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-xs text-base-content/50">
                                        Kamu belum pernah meminjam buku di perpustakaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $peminjamans->links() }}
                </div>
            </div>
        </div>

    </main>

</body>
</html>