<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekStatusAnggota
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login via Guard anggota
        if (!Auth::guard('anggota')->check()) {
            return redirect('/anggota/login')->with('error', 'Silakan login dengan Nomor Induk Anda terlebih dahulu.');
        }

        return $next($request);
    }
}