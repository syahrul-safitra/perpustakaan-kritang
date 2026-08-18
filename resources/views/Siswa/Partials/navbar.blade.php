<div class="sticky top-0 z-50 border-b border-slate-100 bg-white/90 shadow-sm backdrop-blur-md">
    <div class="navbar mx-auto w-full max-w-7xl px-4 sm:px-6">

        <!-- Navbar Start (Brand Logo Zen Code) -->
        <div class="flex-1 gap-3">
            <a href="{{ url("/katalog") }}" class="group flex items-center gap-2.5">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-600 text-sm font-black tracking-wider text-white shadow-md shadow-emerald-600/20 transition-transform group-hover:scale-105">
                    ZC
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-sm font-bold leading-tight tracking-wide text-slate-800 transition-colors group-hover:text-emerald-600">E-PERPUS</span>
                    <span class="text-[10px] font-semibold text-slate-400">SMAN 1 Keritang</span>
                </div>
            </a>
        </div>

        <!-- Navbar End (Dynamic Auth State) -->
        <div class="flex-none gap-3">

            @if (auth()->check())
                {{-- OPSI 1: JIKA USER ADALAH PUSTAKAWAN / ADMIN --}}
                <a href="{{ url("/admin/dashboard") }}"
                    class="btn btn-sm gap-2 rounded-xl border-none bg-emerald-600 px-4 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700">
                    <i class="fa-solid fa-gauge text-xs"></i>
                    <span class="hidden sm:inline">Dashboard Admin</span>
                </a>

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button"
                        class="btn btn-ghost btn-circle avatar border border-slate-200 hover:border-emerald-500">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap ?? "A", 0, 1)) }}
                        </div>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content z-50 mt-3 w-56 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl">
                        <li class="menu-title mb-1 border-b border-slate-100 px-3 py-2">
                            <span
                                class="text-xs font-bold text-slate-800">{{ auth()->user()->nama_lengkap ?? "Pustakawan" }}</span>
                            <span class="text-[10px] font-medium text-slate-400">Petugas Pustakawan</span>
                        </li>
                        <li>
                            <form action="{{ url("/admin/logout") }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-2 rounded-xl py-2 text-left font-bold text-rose-600 hover:bg-rose-50">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                    Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @elseif(auth()->guard("anggota")->check())
                {{-- OPSI 2: JIKA USER ADALAH ANGGOTA (SISWA / GURU) --}}
                <a href="{{ url("/anggota/dashboard") }}"
                    class="btn btn-sm gap-2 rounded-xl border-none bg-emerald-600 px-4 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700">
                    <i class="fa-solid fa-user text-xs"></i>
                    <span class="hidden sm:inline">Dashboard Anggota</span>
                </a>

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button"
                        class="btn btn-ghost btn-circle avatar border border-slate-200 hover:border-emerald-500">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700">
                            {{ strtoupper(substr(auth()->guard("anggota")->user()->nama_lengkap ?? "U", 0, 1)) }}
                        </div>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content z-50 mt-3 w-56 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl">
                        <li class="menu-title mb-1 border-b border-slate-100 px-3 py-2">
                            <span
                                class="text-xs font-bold text-slate-800">{{ auth()->guard("anggota")->user()->nama_lengkap }}</span>
                            <span class="text-[10px] font-medium text-slate-400">NO:
                                {{ auth()->guard("anggota")->user()->nomor_induk }}</span>
                        </li>
                        <li>
                            <form action="{{ url("/anggota/logout") }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-2 rounded-xl py-2 text-left font-bold text-rose-600 hover:bg-rose-50">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                    Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                {{-- OPSI 3: JIKA BELUM LOGIN (GUEST / TAMU) --}}
                <a href="{{ url("/login") }}"
                    class="btn btn-sm gap-1.5 rounded-xl border-none bg-emerald-600 px-5 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700">
                    <i class="fa-solid fa-right-to-bracket text-xs"></i> Login
                </a>
            @endif

        </div>

    </div>
</div>
