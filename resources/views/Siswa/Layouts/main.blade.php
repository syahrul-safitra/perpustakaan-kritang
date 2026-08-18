{{-- <!DOCTYPE html>
<html lang="id" data-theme="emerald">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Katalog Perpustakaan - SMAN 1 Keritang')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200/50 min-h-screen antialiased text-base-content selection:bg-primary selection:text-primary-content flex flex-col">

    <!-- Header / Navbar -->
    @include('Siswa.Partials.navbar')

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto p-4 md:p-6 lg:p-8">
        @yield('content')
    </main>

    <!-- Simple Footer -->
    <footer class="footer footer-center p-4 bg-base-100 text-base-content/60 border-t border-base-200 mt-auto text-xs">
        <aside>
            <p>Hak Cipta © {{ date('Y') }} - Perpustakaan SMA Negeri 1 Keritang. Dirancang dengan teknologi modern.</p>
        </aside>
    </footer>

    @stack('scripts')
</body>
</html> --}}

<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield("title", "Katalog Perpustakaan - SMAN 1 Keritang")</title>

        <!-- FontAwesome 6 Free -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Vite Assets -->
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>

    <body
        class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

        <!-- Header / Navbar -->
        @include("Siswa.Partials.navbar")

        <!-- Main Content -->
        <main class="mx-auto w-full max-w-7xl flex-1 p-4 md:p-6 lg:p-8">
            @yield("content")
        </main>

        <!-- Modern Light Footer -->
        <footer class="mt-auto border-t border-slate-100 bg-white py-6 text-xs text-slate-400">
            <div class="mx-auto max-w-7xl space-y-2 px-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <div
                        class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-600 text-[10px] font-bold text-white shadow-sm">
                        ZC
                    </div>
                    <span class="font-bold text-slate-700">E-Perpus SMAN 1 Keritang</span>
                </div>
                <p class="text-[11px]">Hak Cipta © {{ date("Y") }} — Perpustakaan SMA Negeri 1 Keritang. Dirancang
                    dengan pendekatan modern.</p>
            </div>
        </footer>

        @stack("scripts")
    </body>

</html>
