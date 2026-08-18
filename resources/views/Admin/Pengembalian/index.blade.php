{{-- @extends('Admin.Layouts.main')

@section("title", "Pengembalian & Denda - Admin")
@section("breadcrumb_active", "Pengembalian Buku")

@section("content")
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content tracking-tight">Pengembalian & Denda</h1>
        <p class="text-xs text-base-content/60 mt-1">Daftar buku yang sedang dipinjam. Sistem akan menghitung denda otomatis jika terlambat.</p>
    </div>
</div>

<!-- Main Card -->
<div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl overflow-hidden">
    <div class="card-body p-5 md:p-6">
        
        <!-- Search Bar -->
        <form method="GET" action="{{ url('/admin/pengembalian') }}" class="mb-6">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-base-content/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode Transaksi / Nama Peminjam..." class="input input-sm input-bordered rounded-xl pl-10 w-full bg-base-200/40 focus:bg-base-100 text-xs transition-all" />
            </div>
        </form>

        <!-- Table Data -->
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-left">
                <thead>
                    <tr class="bg-base-200/50 text-base-content/70 text-xs font-semibold uppercase tracking-wider border-b border-base-200">
                        <th class="rounded-l-xl py-3.5">Transaksi & Anggota</th>
                        <th>Daftar Buku</th>
                        <th>Jatuh Tempo</th>
                        <th class="text-center">Status Denda</th>
                        <th class="rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/60 text-sm">
                    @forelse ($peminjamans as $trx)
                        <tr class="hover:bg-base-200/30 transition-colors">
                            <td class="py-3.5">
                                <div class="font-mono text-xs font-bold text-primary">{{ $trx->kode_transaksi }}</div>
                                <div class="font-semibold text-base-content mt-1">{{ $trx->anggota->nama_lengkap }}</div>
                                <div class="text-[11px] text-base-content/50">{{ $trx->anggota->nomor_induk }}</div>
                            </td>
                            <td>
                                <ul class="list-disc list-inside text-xs text-base-content/80">
                                    @foreach ($trx->detailPeminjaman as $detail)
                                        <li class="truncate max-w-xs">{{ $detail->buku->judul }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <div class="text-xs font-medium">{{ \Carbon\Carbon::parse($trx->tanggal_harus_kembali)->format('d M Y') }}</div>
                                @if ($trx->hari_terlambat > 0)
                                    <div class="text-[10px] text-error font-bold mt-1 tracking-wider bg-error/10 inline-block px-1.5 py-0.5 rounded">TERLEWAT {{ $trx->hari_terlambat }} HARI</div>
                                @else
                                    <div class="text-[10px] text-emerald-600 mt-1">Belum Jatuh Tempo</div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($trx->hari_terlambat > 0)
                                    <span class="font-bold text-error text-sm">Rp {{ number_format($trx->denda_sementara, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-xs text-base-content/50">- Rp 0 -</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button onclick="openReturnModal('{{ $trx->id }}', '{{ $trx->kode_transaksi }}', '{{ $trx->anggota->nama_lengkap }}', {{ $trx->denda_sementara }})" 
                                        class="btn btn-primary btn-sm rounded-xl px-4 text-xs font-semibold shadow-md shadow-primary/25">
                                    Proses Kembali
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-xs text-base-content/50">Tidak ada buku yang sedang dipinjam saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($peminjamans->hasPages())
            <div class="mt-4 pt-4 border-t border-base-200 flex justify-end">{{ $peminjamans->links() }}</div>
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Pengembalian -->
<dialog id="return_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box rounded-2xl border border-base-200 p-6">
        <h3 class="font-bold text-lg text-base-content border-b border-base-200 pb-3 mb-4">Proses Pengembalian Buku</h3>
        
        <p class="text-sm text-base-content/80 mb-2">
            Anda akan memproses pengembalian untuk transaksi <span id="modal_kode_trx" class="font-bold text-primary"></span> atas nama <span id="modal_nama_anggota" class="font-bold"></span>.
        </p>

        <!-- Dynamic Fine Display Container -->
        <div id="denda_container" class="mt-4 p-4 rounded-xl border bg-base-200/50 hidden items-center justify-between">
            <div>
                <span class="block text-xs font-bold text-error uppercase tracking-wider">Keterlambatan Terdeteksi</span>
                <span class="block text-xs text-base-content/70 mt-0.5">Pastikan anggota membayar denda.</span>
            </div>
            <div class="text-right">
                <span id="modal_denda_amount" class="text-lg font-black text-error"></span>
            </div>
        </div>

        <div id="no_denda_container" class="mt-4 p-3 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Tepat waktu. Tidak ada denda keterlambatan.
        </div>
        
        <form id="return_form" method="POST" class="modal-action gap-2 mt-6 pt-4 border-t border-base-200">
            @csrf
            @method('PUT')
            <button type="button" onclick="return_modal.close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
            <button type="submit" class="btn btn-primary btn-sm rounded-xl px-6 text-xs font-semibold">Konfirmasi Pengembalian</button>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

@push("scripts")
<script>
    function openReturnModal(id, kodeTrx, namaAnggota, denda) {
        // Set Action Form
        document.getElementById('return_form').action = `/admin/pengembalian/${id}`;
        
        // Set Data Text
        document.getElementById('modal_kode_trx').innerText = kodeTrx;
        document.getElementById('modal_nama_anggota').innerText = namaAnggota;

        // Atur Tampilan Container Denda
        const dendaContainer = document.getElementById('denda_container');
        const noDendaContainer = document.getElementById('no_denda_container');

        if (denda > 0) {
            dendaContainer.classList.remove('hidden');
            dendaContainer.classList.add('flex');
            noDendaContainer.classList.add('hidden');
            
            // Format nominal uang ke rupiah
            const formattedDenda = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(denda);
            document.getElementById('modal_denda_amount').innerText = formattedDenda;
        } else {
            dendaContainer.classList.add('hidden');
            dendaContainer.classList.remove('flex');
            noDendaContainer.classList.remove('hidden');
        }

        document.getElementById('return_modal').showModal();
    }
</script>
@endpush
@endsection --}}

@extends("Admin.Layouts.main")

@section("title", "Pengembalian & Denda - E-Perpus SMAN 1 Keritang")
@section("page_heading", "Pengembalian & Denda")

@section("content")
    <div class="space-y-6">

        <!-- Header Action & Search Card (Light Emerald Style) -->
        <div class="space-y-4 rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">

            <!-- Baris Atas: Judul Deskripsi -->
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Proses Pengembalian Buku</h2>
                    <p class="text-xs text-slate-400">Daftar transaksi aktif yang perlu diproses kembali. Sistem menghitung
                        denda keterlambatan secara otomatis.</p>
                </div>
            </div>

            <!-- Baris Bawah: Form Pencarian & Filter -->
            <form method="GET" action="{{ url("/admin/pengembalian") }}"
                class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 pt-3 md:flex-row">

                <!-- Input Search Field -->
                <div class="relative w-full md:w-96">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request("search") }}"
                        placeholder="Cari Kode Transaksi / Nama Peminjam..."
                        class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-slate-50 pl-9 text-xs text-slate-700 transition-all focus:border-emerald-500 focus:bg-white focus:outline-none" />
                </div>

                <!-- Action Filter -->
                <div class="flex w-full items-center gap-2 md:w-auto">
                    <button type="submit"
                        class="btn btn-sm gap-1.5 rounded-xl border border-slate-200 bg-slate-100 px-4 text-xs font-bold text-slate-700 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                        <i class="fa-solid fa-filter text-[11px]"></i> Cari
                    </button>

                    @if (request("search"))
                        <a href="{{ url("/admin/pengembalian") }}"
                            class="btn btn-sm btn-ghost rounded-xl px-2 text-xs font-semibold text-rose-500 hover:bg-rose-50"
                            title="Reset Pencarian">
                            <i class="fa-solid fa-rotate-right"></i> Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Table Data Container -->
        <div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Menunggu Pengembalian:
                    {{ $peminjamans->total() ?? count($peminjamans) }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-xs">
                    <thead>
                        <tr
                            class="border-b border-slate-100 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="px-4 py-3.5">Transaksi & Peminjam</th>
                            <th class="px-4 py-3.5">Item Buku Dipinjam</th>
                            <th class="px-4 py-3.5">Jatuh Tempo</th>
                            <th class="px-4 py-3.5 text-center">Nominal Denda</th>
                            <th class="w-36 px-4 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse ($peminjamans as $trx)
                            <tr class="transition-colors hover:bg-slate-50/80">
                                <td class="px-4 py-3.5">
                                    <div class="font-mono font-bold text-emerald-600">{{ $trx->kode_transaksi }}</div>
                                    <div class="mt-0.5 font-bold text-slate-800">{{ $trx->anggota->nama_lengkap ?? "-" }}
                                    </div>
                                    <div class="font-mono text-[10px] text-slate-400">
                                        {{ $trx->anggota->nomor_induk ?? "-" }}</div>
                                </td>
                                <td class="px-4 py-3.5">
                                    <ul class="space-y-1">
                                        @foreach ($trx->detailPeminjaman as $detail)
                                            <li
                                                class="flex max-w-xs items-center gap-1.5 truncate font-medium text-slate-700">
                                                <i class="fa-solid fa-book-bookmark text-[10px] text-emerald-500"></i>
                                                <span>{{ $detail->buku->judul ?? "-" }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="font-semibold text-slate-700">
                                        <i class="fa-regular fa-calendar-xmark mr-1 text-slate-400"></i>
                                        {{ \Carbon\Carbon::parse($trx->tanggal_harus_kembali)->format("d M Y") }}
                                    </div>
                                    @if ($trx->hari_terlambat > 0)
                                        <div class="mt-1">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full border border-rose-200/60 bg-rose-50 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-rose-700">
                                                <i class="fa-solid fa-clock-rotate-left"></i> Terlewat
                                                {{ $trx->hari_terlambat }} Hari
                                            </span>
                                        </div>
                                    @else
                                        <div class="mt-1">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full border border-emerald-200/60 bg-emerald-50 px-2 py-0.5 text-[9px] font-bold text-emerald-700">
                                                <i class="fa-solid fa-circle-check"></i> Tepat Waktu
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    @if ($trx->hari_terlambat > 0)
                                        <span class="font-mono text-sm font-bold text-rose-600">
                                            Rp {{ number_format($trx->denda_sementara, 0, ",", ".") }}
                                        </span>
                                    @else
                                        <span class="font-mono text-xs text-slate-300">- Rp 0 -</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <button
                                        onclick="openReturnModal('{{ $trx->id }}', '{{ $trx->kode_transaksi }}', '{{ addslashes($trx->anggota->nama_lengkap ?? "-") }}', {{ $trx->denda_sementara }})"
                                        class="btn btn-xs gap-1.5 rounded-xl border-none bg-emerald-600 px-3 text-[11px] font-bold text-white shadow-sm shadow-emerald-600/20 hover:bg-emerald-700">
                                        <i class="fa-solid fa-rotate-left"></i> Proses Kembali
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center italic text-slate-400">
                                    Tidak ada buku yang sedang dipinjam saat ini.
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

    </div>

    <!-- Modal Konfirmasi Pengembalian Buku -->
    <dialog id="return_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-11/12 max-w-md rounded-3xl border border-slate-100 bg-white p-6 shadow-2xl">
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="flex items-center gap-2 text-base font-bold text-slate-800">
                    <i class="fa-solid fa-rotate-left text-emerald-600"></i> Konfirmasi Pengembalian
                </h3>
                <button onclick="return_modal.close()" class="btn btn-xs btn-circle btn-ghost text-slate-400">✕</button>
            </div>

            <p class="text-xs leading-relaxed text-slate-600">
                Anda akan memproses pengembalian buku untuk kode transaksi <span id="modal_kode_trx"
                    class="font-mono font-bold text-emerald-600"></span> atas nama <span id="modal_nama_anggota"
                    class="font-bold text-slate-800"></span>.
            </p>

            <!-- Container Jika Terkena Denda -->
            <div id="denda_container"
                class="mt-4 hidden items-center justify-between rounded-2xl border border-rose-200/80 bg-rose-50/60 p-4">
                <div>
                    <span class="block text-[10px] font-bold uppercase tracking-wider text-rose-600">Keterlambatan
                        Terdeteksi</span>
                    <span class="mt-0.5 block text-xs font-medium text-rose-800/80">Harap pastikan denda telah
                        dibayar.</span>
                </div>
                <div class="text-right">
                    <span id="modal_denda_amount" class="font-mono text-base font-black text-rose-600"></span>
                </div>
            </div>

            <!-- Container Jika Tepat Waktu (Tidak Ada Denda) -->
            <div id="no_denda_container"
                class="mt-4 flex items-center gap-2 rounded-2xl border border-emerald-200/60 bg-emerald-50/60 p-3.5 text-xs font-bold text-emerald-800">
                <i class="fa-solid fa-circle-check text-sm text-emerald-600"></i>
                <span>Pengembalian tepat waktu. Tidak dikenakan denda keterlambatan.</span>
            </div>

            <form id="return_form" method="POST" class="modal-action mt-6 gap-2 border-t border-slate-100 pt-4">
                @csrf
                @method("PUT")
                <button type="button" onclick="return_modal.close()"
                    class="btn btn-ghost btn-sm rounded-xl text-xs text-slate-500">Batal</button>
                <button type="submit"
                    class="btn btn-sm rounded-xl border-none bg-emerald-600 px-6 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700">Konfirmasi
                    Pengembalian</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    @push("scripts")
        <script>
            function openReturnModal(id, kodeTrx, namaAnggota, denda) {
                document.getElementById('return_form').action = `/admin/pengembalian/${id}`;

                document.getElementById('modal_kode_trx').innerText = kodeTrx;
                document.getElementById('modal_nama_anggota').innerText = namaAnggota;

                const dendaContainer = document.getElementById('denda_container');
                const noDendaContainer = document.getElementById('no_denda_container');

                if (denda > 0) {
                    dendaContainer.classList.remove('hidden');
                    dendaContainer.classList.add('flex');
                    noDendaContainer.classList.add('hidden');

                    const formattedDenda = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(denda);
                    document.getElementById('modal_denda_amount').innerText = formattedDenda;
                } else {
                    dendaContainer.classList.add('hidden');
                    dendaContainer.classList.remove('flex');
                    noDendaContainer.classList.remove('hidden');
                }

                document.getElementById('return_modal').showModal();
            }
        </script>
    @endpush
@endsection
