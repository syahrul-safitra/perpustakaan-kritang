<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Pustakawan — E-Perpus SMAN 1 Keritang</title>

        <!-- FontAwesome 6 Free -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Vite Assets -->
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>

    <body
        class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950 p-4 font-sans antialiased">

        <!-- Background Image Sekolah dengan Overlay Blur -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=2000&auto=format&fit=crop"
                alt="School Building Background"
                class="contrast-110 h-full w-full scale-105 object-cover brightness-[0.38] filter transition-transform duration-1000" />
            <div
                class="absolute inset-0 bg-gradient-to-br from-slate-950/90 via-emerald-950/70 to-slate-900/85 backdrop-blur-[3px]">
            </div>
        </div>

        <!-- Ambient Glowing Blobs -->
        <div class="pointer-events-none absolute -left-20 top-1/3 h-80 w-80 rounded-full bg-emerald-600/25 blur-3xl">
        </div>
        <div class="pointer-events-none absolute -right-20 bottom-1/3 h-96 w-96 rounded-full bg-teal-500/20 blur-3xl">
        </div>

        <!-- Main Glass Card Container -->
        <div
            class="relative z-10 w-full max-w-md space-y-6 rounded-3xl border border-white/40 bg-white/95 p-6 shadow-2xl shadow-emerald-950/60 backdrop-blur-2xl sm:p-8">

            <!-- Header Branding (Zen Code & Info Sekolah) -->
            <div class="text-center">
                <a href="{{ url("/katalog") }}" class="group mb-3 inline-flex items-center gap-2.5">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl border border-slate-100/80 bg-white/80 p-1.5 shadow-lg shadow-emerald-950/20 backdrop-blur-md transition-transform group-hover:scale-105">
                        <img src="{{ asset("img/logo.png") }}" alt="Logo SMAN 1 Keritang"
                            class="h-full w-full object-contain" />
                    </div>
                </a>
                <h1 class="text-xl font-black tracking-tight text-slate-800">Login Pustakawan</h1>
                <p class="mt-0.5 text-xs text-slate-400">Sistem Informasi Perpustakaan SMAN 1 Keritang</p>
            </div>

            <!-- Alert Notification -->
            @if (session("success"))
                <div
                    class="flex items-center gap-2.5 rounded-2xl border border-emerald-200/80 bg-emerald-50 p-3.5 text-xs font-semibold text-emerald-700">
                    <i class="fa-solid fa-circle-check text-sm text-emerald-600"></i>
                    <span>{{ session("success") }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="flex items-center gap-2.5 rounded-2xl border border-rose-200/80 bg-rose-50 p-3.5 text-xs font-semibold text-rose-600">
                    <i class="fa-solid fa-triangle-exclamation text-sm text-rose-500"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ url("/admin/login") }}" method="POST" class="space-y-4">
                @csrf

                <!-- Input Email -->
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-bold text-slate-700">Alamat Email</label>
                    <div class="relative">
                        <span
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" name="email" value="{{ old("email") }}"
                            placeholder="pustakawan@sekolah.sch.id"
                            class="input input-sm input-bordered @error("email") border-rose-500 @enderror w-full rounded-xl border-slate-200 bg-slate-50/80 pl-9 text-xs font-medium text-slate-700 transition-all focus:border-emerald-500 focus:bg-white focus:outline-none"
                            required autofocus />
                    </div>
                </div>

                <!-- Input Password -->
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-bold text-slate-700">Password</label>
                    <div class="relative">
                        <span
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" name="password" placeholder="••••••••"
                            class="input input-sm input-bordered @error("password") border-rose-500 @enderror w-full rounded-xl border-slate-200 bg-slate-50/80 pl-9 text-xs font-medium text-slate-700 transition-all focus:border-emerald-500 focus:bg-white focus:outline-none"
                            required />
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="btn btn-sm mt-2 h-10 w-full gap-2 rounded-xl border-none bg-emerald-600 text-xs font-bold text-white shadow-md shadow-emerald-600/30 hover:bg-emerald-700">
                    <i class="fa-solid fa-right-to-bracket text-xs"></i> Masuk ke Dashboard
                </button>

                <!-- Divider -->
                <div class="relative flex items-center py-2">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="mx-3 flex-shrink text-[10px] font-bold uppercase tracking-wider text-slate-400">Atau
                        Masuk Sebagai</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <!-- Link Navigasi Portal Anggota -->
                <a href="{{ url("/anggota/login") }}"
                    class="btn btn-sm btn-ghost h-10 w-full gap-2 rounded-xl border border-slate-200/80 text-xs font-bold text-slate-700 hover:bg-slate-100">
                    <i class="fa-solid fa-id-card text-xs text-emerald-600"></i> Portal Login Anggota (Siswa / Guru)
                </a>
            </form>

            <!-- Footer Back Link -->
            <div class="pt-2 text-center">
                <a href="{{ url("/katalog") }}"
                    class="inline-flex items-center gap-1.5 text-[11px] font-bold text-slate-400 transition-colors hover:text-emerald-600">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Katalog Utama
                </a>
            </div>

        </div>

    </body>

</html>
