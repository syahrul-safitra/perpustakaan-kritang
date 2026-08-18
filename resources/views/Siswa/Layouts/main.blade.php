<!DOCTYPE html>
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
</html>