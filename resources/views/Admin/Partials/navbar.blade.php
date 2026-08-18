<!-- Tambahkan z-50 dan relative/sticky agar Dropdown Logout selalu berada di paling depan -->
<header class="sticky top-0 z-50 w-full bg-base-100/90 backdrop-blur-md border-b border-base-200/80 shadow-sm">
    <div class="navbar px-4 md:px-6">
        
        <!-- Sisi Kiri: Branding / Toggle Sidebar -->
        <div class="flex-1">
            <span class="font-bold text-lg text-base-content">Sistem Perpustakaan</span>
        </div>

        <!-- Sisi Kanan: Profile & Dropdown Logout -->
        <div class="flex-none gap-2">
            <!-- Dropdown DaisyUI -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar border border-base-300">
                    <div class="w-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)) }}
                    </div>
                </div>
                
                <!-- Menu Dropdown Logout (Diberi z-50 tambahan agar aman) -->
                <ul tabindex="0" class="mt-3 z-50 p-2 shadow-xl menu menu-sm dropdown-content bg-base-100 rounded-2xl w-52 border border-base-200">
                    <li class="menu-title px-3 py-2">
                        <span class="text-xs font-bold text-base-content">{{ Auth::user()->nama_lengkap ?? 'Pustakawan' }}</span>
                        <span class="text-[10px] text-base-content/60 font-normal truncate">{{ Auth::user()->email ?? '-' }}</span>
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
        </div>

    </div>
</header>