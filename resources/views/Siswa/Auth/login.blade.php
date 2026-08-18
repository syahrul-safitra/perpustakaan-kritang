<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Anggota - Perpustakaan SMAN 1 Keritang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">

    <div class="card w-full max-w-md bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-2xl rounded-3xl p-6 md:p-8">
        
        <!-- Header Branding -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-secondary/10 text-secondary mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h1 class="text-2xl font-black text-base-content tracking-tight">Portal Anggota</h1>
            <p class="text-xs text-base-content/60 mt-1">Masuk dengan Nomor Induk (NISN/NIP) Anda</p>
        </div>

        <!-- Alert Notification -->
        @if(session('success'))
            <div class="alert alert-success text-xs text-white rounded-xl mb-4 p-3">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error text-xs text-white rounded-xl mb-4 p-3">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ url('/anggota/login') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-xs font-semibold text-base-content/70">Nomor Induk (NISN / NIP)</span>
                </label>
                <input type="text" name="nomor_induk" value="{{ old('nomor_induk') }}" placeholder="Contoh: 0054829102" class="input input-bordered input-md w-full rounded-xl text-xs focus:outline-none focus:border-secondary @error('nomor_induk') input-error @enderror" required autofocus />
            </div>

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-xs font-semibold text-base-content/70">Password</span>
                </label>
                <input type="password" name="password" placeholder="••••••••" class="input input-bordered input-md w-full rounded-xl text-xs focus:outline-none focus:border-secondary @error('password') input-error @enderror" required />
            </div>

            <div class="flex items-center justify-between text-xs py-1">
                {{-- <label class="cursor-pointer flex items-center gap-2">
                    <input type="checkbox" name="remember" class="checkbox checkbox-xs checkbox-secondary rounded" />
                    <span class="label-text text-xs">Ingat Saya</span>
                </label> --}}
                <a href="{{ url('/katalog') }}" class="text-secondary hover:underline font-medium">Cari Buku (Katalog)</a>
            </div>

            <button type="submit" class="btn btn-secondary btn-md w-full rounded-xl text-xs font-bold tracking-wide mt-2 text-white">
                Masuk ke Portal
            </button>
        </form>

    </div>

</body>
</html>