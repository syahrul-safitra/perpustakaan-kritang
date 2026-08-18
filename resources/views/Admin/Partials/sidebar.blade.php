<aside class="w-72 h-[calc(100vh-2rem)] my-4 ml-4 bg-base-100/90 backdrop-blur-md flex flex-col justify-between rounded-2xl border border-base-200/60 shadow-xl shadow-base-300/30">
    <div class="p-4 flex flex-col h-full">
        <!-- Brand Header -->
        <div class="flex items-center gap-3 px-3 py-3 border-b border-base-200/80 mb-4">
            <div class="avatar placeholder">
                <div class="bg-primary text-primary-content rounded-xl w-10 h-10 shadow-md shadow-primary/20 flex items-center justify-center">
                    <span class="text-lg font-black tracking-wider">ZC</span>
                </div>
            </div>
            <div class="flex flex-col">
                <h1 class="font-bold text-sm leading-tight tracking-wide text-base-content">SIPERPUS</h1>
                <p class="text-[11px] font-medium text-base-content/50">SMAN 1 Keritang</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="overflow-y-auto flex-1 pr-1 custom-scrollbar">
            <ul class="menu menu-sm gap-1 p-0">
                <!-- Dashboard -->
                <li>
                    <a href="{{ url('admin/dashboard') }}" 
                       class="py-2.5 px-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-primary-content font-semibold shadow-md shadow-primary/25' : 'hover:bg-base-200/60 text-base-content/70 hover:text-base-content' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Dashboard
                    </a>
                </li>

                <!-- Group: Master Data -->
                <li class="menu-title mt-4 text-[10px] font-bold uppercase tracking-wider text-base-content/40 px-3">Master Data</li>
                <li>
                    <a href="{{ url('admin/kategori') }}" 
                       class="py-2.5 px-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-primary text-primary-content font-semibold shadow-md shadow-primary/25' : 'hover:bg-base-200/60 text-base-content/70 hover:text-base-content' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10M7 17h10" /></svg>
                        Data Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/buku') }}" 
                       class="py-2.5 px-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.buku.*') ? 'bg-primary text-primary-content font-semibold shadow-md shadow-primary/25' : 'hover:bg-base-200/60 text-base-content/70 hover:text-base-content' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        Data Koleksi Buku
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/anggota') }}" 
                       class="py-2.5 px-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.anggota.*') ? 'bg-primary text-primary-content font-semibold shadow-md shadow-primary/25' : 'hover:bg-base-200/60 text-base-content/70 hover:text-base-content' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Data Anggota
                    </a>
                </li>

                <!-- Group: Sirkulasi -->
                <li class="menu-title mt-4 text-[10px] font-bold uppercase tracking-wider text-base-content/40 px-3">Sirkulasi</li>
                <li>
                    <a href="{{ url('admin/peminjaman') }}" 
                       class="py-2.5 px-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.peminjaman.*') ? 'bg-primary text-primary-content font-semibold shadow-md shadow-primary/25' : 'hover:bg-base-200/60 text-base-content/70 hover:text-base-content' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        Peminjaman Buku
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/pengembalian') }}" 
                       class="py-2.5 px-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.pengembalian.*') ? 'bg-primary text-primary-content font-semibold shadow-md shadow-primary/25' : 'hover:bg-base-200/60 text-base-content/70 hover:text-base-content' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Pengembalian & Denda
                    </a>
                </li>

                <!-- Group: Laporan -->
                <li class="menu-title mt-4 text-[10px] font-bold uppercase tracking-wider text-base-content/40 px-3">Laporan</li>
                <li>
                    <a href="{{ url('admin/laporan') }}" 
                       class="py-2.5 px-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-primary text-primary-content font-semibold shadow-md shadow-primary/25' : 'hover:bg-base-200/60 text-base-content/70 hover:text-base-content' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Laporan Rekapitulasi
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Footer Card -->
        <div class="mt-4 p-3 rounded-xl bg-base-200/50 border border-base-200/80 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[11px] font-semibold text-base-content/70">Sistem Online</span>
            </div>
            <span class="text-[10px] font-mono text-base-content/40">v1.0</span>
        </div>
    </div>
</aside>