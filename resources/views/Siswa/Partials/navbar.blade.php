<div class="sticky top-0 z-50 backdrop-blur-lg bg-base-100/80 border-b border-base-200/60 shadow-sm">
    <div class="navbar w-full max-w-7xl mx-auto px-4 sm:px-6">
        
        <!-- Navbar Start (Brand Logo Zen Code) -->
        <div class="flex-1 gap-2">
            <div class="avatar placeholder">
                <div class="bg-primary text-primary-content rounded-xl w-10 h-10 shadow-md shadow-primary/20 flex items-center justify-center">
                    <span class="text-lg font-black tracking-wider">ZC</span>
                </div>
            </div>
            <a href="{{ url('/katalog') }}" class="flex flex-col hover:opacity-80 transition-opacity">
                <span class="font-bold text-sm leading-tight tracking-wide text-base-content">E-PERPUS</span>
                <span class="text-[11px] font-medium text-base-content/50">SMAN 1 Keritang</span>
            </a>
        </div>

        <!-- Navbar End (Dynamic Auth State) -->
        <div class="flex-none gap-3">
            
            @if(auth()->check())
                {{-- OPSI 1: JIKA USER ADALAH PUSTAKAWAN / ADMIN --}}
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-sm rounded-xl px-4 text-xs font-semibold shadow-md shadow-primary/25">
                    Dashboard Admin
                </a>

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar border border-base-300">
                        <div class="w-8 rounded-full bg-primary text-primary-content flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                    <ul tabindex="0" class="mt-3 z-50 p-2 shadow-xl menu menu-sm dropdown-content bg-base-100 rounded-2xl w-52 border border-base-200">
                        <li class="menu-title px-3 py-1.5">
                            <span class="text-xs font-bold text-base-content">{{ auth()->user()->nama_lengkap ?? 'Pustakawan' }}</span>
                            <span class="text-[10px] text-base-content/60 font-normal">Pustakawan</span>
                        </li>
                        <div class="divider my-0"></div>
                        <li>
                            <form action="{{ url('/admin/logout') }}" method="POST" class="w-full">
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

            @elseif(auth()->guard('anggota')->check())
                {{-- OPSI 2: JIKA USER ADALAH ANGGOTA (SISWA / GURU) --}}
                <a href="{{ url('/anggota/dashboard') }}" class="btn btn-secondary btn-sm rounded-xl px-4 text-xs font-semibold text-white shadow-md shadow-secondary/25">
                    Dashboard Anggota
                </a>

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar border border-base-300">
                        <div class="w-8 rounded-full bg-secondary text-secondary-content flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(auth()->guard('anggota')->user()->nama_lengkap ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                    <ul tabindex="0" class="mt-3 z-50 p-2 shadow-xl menu menu-sm dropdown-content bg-base-100 rounded-2xl w-52 border border-base-200">
                        <li class="menu-title px-3 py-1.5">
                            <span class="text-xs font-bold text-base-content">{{ auth()->guard('anggota')->user()->nama_lengkap }}</span>
                            <span class="text-[10px] text-base-content/60 font-normal">NO: {{ auth()->guard('anggota')->user()->nomor_induk }}</span>
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

            @else
                {{-- OPSI 3: JIKA BELUM LOGIN (GUEST / TAMU) --}}
                <a href="{{ url('/login') }}" class="btn btn-primary btn-sm rounded-xl px-5 text-xs font-semibold shadow-md shadow-primary/25">
                    Login
                </a>
            @endif

        </div>

    </div>
</div>