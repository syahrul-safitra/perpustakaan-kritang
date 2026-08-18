<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pustakawan - Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">

    <div class="card w-full max-w-md bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-2xl rounded-3xl p-6 md:p-8">
        
        <!-- Header Branding -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-primary/10 text-primary mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h1 class="text-2xl font-black text-base-content tracking-tight">Login Pustakawan</h1>
            <p class="text-xs text-base-content/60 mt-1">Sistem Informasi Perpustakaan SMAN 1 Keritang</p>
        </div>

        <!-- Alert Error / Success -->
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
        <form action="{{ url('/admin/login') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-xs font-semibold text-base-content/70">Alamat Email</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="pustakawan@sekolah.sch.id" class="input input-bordered input-md w-full rounded-xl text-xs focus:outline-none focus:border-primary @error('email') input-error @enderror" required autofocus />
            </div>

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text text-xs font-semibold text-base-content/70">Password</span>
                </label>
                <input type="password" name="password" placeholder="••••••••" class="input input-bordered input-md w-full rounded-xl text-xs focus:outline-none focus:border-primary @error('password') input-error @enderror" required />
            </div>

            <button type="submit" class="btn btn-primary btn-md w-full rounded-xl text-xs font-bold tracking-wide mt-2">
                Masuk ke Dashboard
            </button>

            <!-- Pembatas Navigasi Portal -->
            <div class="divider text-[10px] text-base-content/40 uppercase my-3">Atau Masuk Sebagai</div>

            <!-- Link Navigasi ke Portal Anggota -->
            <div class="text-center space-y-2">
                <a href="{{ url('/anggota/login') }}" class="btn btn-outline btn-secondary btn-sm w-full rounded-xl text-xs font-semibold gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Portal Login Anggota (Siswa / Guru)
                </a>
            </div>
        </form>

    </div>

</body>
</html>