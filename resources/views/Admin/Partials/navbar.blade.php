{{-- <!-- Tambahkan z-50 dan relative/sticky agar Dropdown Logout selalu berada di paling depan -->
<header class="bg-base-100/90 border-base-200/80 sticky top-0 z-50 w-full border-b shadow-sm backdrop-blur-md">
    <div class="navbar px-4 md:px-6">

        <!-- Sisi Kiri: Branding / Toggle Sidebar -->
        <div class="flex-1">
            <span class="text-base-content text-lg font-bold">Sistem Perpustakaan</span>
        </div>

        <!-- Sisi Kanan: Profile & Dropdown Logout -->
        <div class="flex-none gap-2">
            <!-- Dropdown DaisyUI -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar border-base-300 border">
                    <div class="bg-primary/10 text-primary flex w-9 items-center justify-center rounded-full font-bold">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap ?? "A", 0, 1)) }}
                    </div>
                </div>

                <!-- Menu Dropdown Logout (Diberi z-50 tambahan agar aman) -->
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 border-base-200 z-50 mt-3 w-52 rounded-2xl border p-2 shadow-xl">
                    <li class="menu-title px-3 py-2">
                        <span
                            class="text-base-content text-xs font-bold">{{ Auth::user()->nama_lengkap ?? "Pustakawan" }}</span>
                        <span
                            class="text-base-content/60 truncate text-[10px] font-normal">{{ Auth::user()->email ?? "-" }}</span>
                    </li>
                    <div class="divider my-0"></div>
                    <li>
                        <form action="{{ url("/admin/logout") }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                class="text-error flex w-full items-center gap-2 text-left font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar (Logout)
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</header> --}}

{{-- <!-- Navbar Header TailAdmin Style -->
<header class="bg-base-100/90 border-base-200/80 sticky top-0 z-50 w-full rounded-2xl border shadow-sm backdrop-blur-md">
    <div class="navbar px-4 md:px-6">

        <!-- Sisi Kiri: Toggle Drawer Mobile & Branding -->
        <div class="flex-1 items-center gap-2">
            <!-- Hamburger Button (Hanya Muncul di Layar Mobile/Tablet < lg) -->
            <label for="admin-drawer" class="btn btn-square btn-ghost btn-sm text-base-content/70 rounded-xl lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </label>

            <span class="text-base-content text-base font-bold tracking-tight md:text-lg">Panel Administrasi
                Perpustakaan</span>
        </div>

        <!-- Sisi Kanan: Profile & Dropdown Logout -->
        <div class="flex-none gap-2">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button"
                    class="btn btn-ghost btn-circle avatar border-base-300 border transition-colors hover:border-emerald-500">
                    <div
                        class="flex w-9 items-center justify-center rounded-full bg-emerald-500/10 font-bold text-emerald-600">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap ?? "A", 0, 1)) }}
                    </div>
                </div>

                <!-- Menu Dropdown Profile -->
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 border-base-200/80 z-50 mt-3 w-56 rounded-2xl border p-2 shadow-xl">
                    <li class="menu-title px-3 py-2">
                        <span
                            class="text-base-content text-xs font-bold">{{ Auth::user()->nama_lengkap ?? "Pustakawan" }}</span>
                        <span class="text-[10px] font-semibold uppercase tracking-wider text-emerald-600">Administrator
                            / Pustakawan</span>
                        <span
                            class="text-base-content/50 mt-0.5 truncate text-[10px] font-normal">{{ Auth::user()->email ?? "-" }}</span>
                    </li>
                    <div class="divider my-0"></div>
                    <li>
                        <form action="{{ url("/admin/logout") }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                class="text-error flex w-full items-center gap-2 rounded-xl py-2 text-left font-semibold hover:bg-rose-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar (Logout)
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</header> --}}

<div class="navbar sticky top-0 z-30 border-b border-slate-100 bg-white/80 px-4 backdrop-blur-md lg:px-8">
    <div class="flex-none lg:hidden">
        <label for="admin-drawer" class="btn btn-square btn-ghost drawer-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block h-5 w-5 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </label>
    </div>

    <div class="flex-1">
        <h2 class="ml-2 text-lg font-bold text-slate-800 lg:ml-0">@yield("page_heading", "Dashboard Overview")</h2>
    </div>

    <div class="flex-none gap-2">
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500 text-sm font-black text-white shadow-lg shadow-emerald-500/30">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? "A", 0, 1)) }}
                </div>
            </div>
            <ul tabindex="0"
                class="menu menu-sm dropdown-content z-[1] mt-3 w-56 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl">
                <li class="mb-1 border-b border-slate-100 px-4 py-2">
                    <p class="text-xs font-bold leading-tight text-slate-800">
                        {{ Auth::user()->nama_lengkap ?? "Pustakawan" }}</p>
                    <p class="truncate text-[10px] font-medium text-slate-400">
                        {{ Auth::user()->email ?? "pustakawan@sekolah.sch.id" }}</p>
                </li>

                <form action="{{ url("/admin/logout") }}" method="POST">
                    @csrf
                    <li>
                        <button type="submit"
                            class="flex items-center gap-2 rounded-xl font-bold text-rose-500 hover:bg-rose-50">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </li>
                </form>
            </ul>
        </div>
    </div>
</div>
