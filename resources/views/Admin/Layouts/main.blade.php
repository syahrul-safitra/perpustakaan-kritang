<!DOCTYPE html>
<html lang="id" data-theme="emerald">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - SMAN 1 Keritang')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200/60 min-h-screen antialiased text-base-content selection:bg-primary selection:text-primary-content">

    <div class="drawer lg:drawer-open">
        <!-- Toggle Control Drawer Mobile -->
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
        
        <!-- Main Content Area -->
        <div class="drawer-content flex flex-col min-h-screen">
            
            <!-- Navbar Floating Header -->
            <div class="p-4 pb-0">
                @include('Admin.Partials.navbar')
            </div>

            <!-- Main Page Content -->
            <main class="flex-1 p-4 md:p-6">

                <!-- Alert Flash Messages dengan style Floating Card -->
                @if (session('success'))
                    <div class="alert alert-success shadow-sm rounded-xl border border-success/20 mb-6 text-sm flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error shadow-sm rounded-xl border border-error/20 mb-6 text-sm flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Dynamic Page Content -->
                @yield('content')

            </main>
        </div> 

        <!-- Floating Drawer Sidebar -->
        <div class="drawer-side z-40">
            <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            @include('Admin.Partials.sidebar')
        </div>
    </div>

    @stack('scripts')
</body>
</html>