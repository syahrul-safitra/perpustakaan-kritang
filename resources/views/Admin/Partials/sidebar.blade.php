<div class="drawer-side z-40">
    <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
    <aside
        class="menu flex min-h-full w-72 flex-col justify-between border-r border-slate-100 bg-white p-6 text-slate-600">
        <div>
            <!-- Brand Logo (Zen Code / E-Perpus Light) -->
            <div class="mb-10 mt-2 flex items-center gap-3 px-4">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500 text-lg font-black tracking-wider text-white shadow-lg shadow-emerald-500/30">
                    ZC
                </div>
                <div>
                    <h1 class="text-xl font-black tracking-tight text-slate-800">E-PERPUS</h1>
                    <p class="text-[10px] font-bold uppercase leading-none tracking-[0.2em] text-emerald-600">SMAN 1
                        Keritang</p>
                </div>
            </div>

            <!-- Main Menu Section -->
            <p class="mb-3 px-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Main Menu</p>
            <ul class="space-y-1.5 p-0">
                <!-- Dashboard -->
                <li>
                    <a href="{{ url("admin/dashboard") }}"
                        class="{{ Request::is("admin/dashboard") || Request::is("admin") ? "bg-emerald-600 text-white shadow-lg shadow-emerald-600/20" : "text-slate-600 hover:bg-slate-50 hover:text-slate-900" }} flex items-center rounded-2xl p-3.5 font-bold transition-all">
                        <i
                            class="fa-solid fa-gauge {{ Request::is("admin/dashboard") || Request::is("admin") ? "text-white" : "text-slate-400" }} w-6"></i>
                        Dashboard
                    </a>
                </li>

                <!-- Master Data -->
                <li class="px-4 pt-4 text-[10px] font-black uppercase italic tracking-widest text-slate-400">Master Data
                </li>
                <li>
                    <a href="{{ url("admin/kategori") }}"
                        class="{{ Request::is("admin/kategori*") ? "bg-emerald-600 text-white shadow-lg shadow-emerald-600/20" : "text-slate-600 hover:bg-slate-50 hover:text-slate-900" }} flex items-center rounded-2xl p-3.5 font-bold transition-all">
                        <i
                            class="fa-solid fa-layer-group {{ Request::is("admin/kategori*") ? "text-white" : "text-slate-400" }} w-6"></i>
                        Data Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ url("admin/buku") }}"
                        class="{{ Request::is("admin/buku*") ? "bg-emerald-600 text-white shadow-lg shadow-emerald-600/20" : "text-slate-600 hover:bg-slate-50 hover:text-slate-900" }} flex items-center rounded-2xl p-3.5 font-bold transition-all">
                        <i
                            class="fa-solid fa-book {{ Request::is("admin/buku*") ? "text-white" : "text-slate-400" }} w-6"></i>
                        Koleksi Buku
                    </a>
                </li>
                <li>
                    <a href="{{ url("admin/anggota") }}"
                        class="{{ Request::is("admin/anggota*") ? "bg-emerald-600 text-white shadow-lg shadow-emerald-600/20" : "text-slate-600 hover:bg-slate-50 hover:text-slate-900" }} flex items-center rounded-2xl p-3.5 font-bold transition-all">
                        <i
                            class="fa-solid fa-users {{ Request::is("admin/anggota*") ? "text-white" : "text-slate-400" }} w-6"></i>
                        Data Anggota
                    </a>
                </li>

                <!-- Sirkulasi & Transaksi -->
                <li class="px-4 pt-4 text-[10px] font-black uppercase italic tracking-widest text-emerald-600">Sirkulasi
                    Buku</li>
                <li>
                    <a href="{{ url("admin/peminjaman") }}"
                        class="{{ Request::is("admin/peminjaman*") ? "bg-emerald-600 text-white shadow-lg shadow-emerald-600/20" : "text-slate-600 hover:bg-slate-50 hover:text-slate-900" }} flex items-center rounded-2xl p-3.5 font-bold transition-all">
                        <i
                            class="fa-solid fa-book-bookmark {{ Request::is("admin/peminjaman*") ? "text-white" : "text-emerald-500" }} w-6"></i>
                        <span>Peminjaman Buku</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("admin/pengembalian") }}"
                        class="{{ Request::is("admin/pengembalian*") ? "bg-emerald-600 text-white shadow-lg shadow-emerald-600/20" : "text-slate-600 hover:bg-slate-50 hover:text-slate-900" }} flex items-center rounded-2xl p-3.5 font-bold transition-all">
                        <i
                            class="fa-solid fa-clock-rotate-left {{ Request::is("admin/pengembalian*") ? "text-white" : "text-emerald-500" }} w-6"></i>
                        Pengembalian & Denda
                    </a>
                </li>

                <!-- Laporan Rekapitulasi -->
                <li class="px-4 pt-4 text-[10px] font-black uppercase italic tracking-widest text-slate-400">Laporan
                </li>
                <li>
                    <a href="{{ url("admin/laporan") }}"
                        class="{{ Request::is("admin/laporan*") ? "bg-emerald-600 text-white shadow-lg shadow-emerald-600/20" : "text-slate-600 hover:bg-slate-50 hover:text-slate-900" }} flex items-center rounded-2xl p-3.5 font-bold transition-all">
                        <i
                            class="fa-solid fa-file-pdf {{ Request::is("admin/laporan*") ? "text-white" : "text-slate-400" }} w-6"></i>
                        Laporan Rekapitulasi
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Info Bottom Card (Light Version) -->
        <div class="mt-8 border-t border-slate-100 pt-4">
            <div class="flex items-center gap-3 rounded-3xl border border-slate-200/60 bg-slate-50 p-4">
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-xs font-bold text-emerald-700">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? "A", 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="mb-1 text-[10px] font-medium leading-none text-slate-400">Login sebagai:</p>
                    <p class="truncate text-xs font-bold uppercase tracking-wider text-slate-800">
                        {{ Auth::user()->nama_lengkap ?? "Pustakawan" }}
                    </p>
                </div>
            </div>
        </div>
    </aside>
</div>
