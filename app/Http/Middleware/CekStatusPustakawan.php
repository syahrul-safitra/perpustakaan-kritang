<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekStatusPustakawan
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login sebagai Pustakawan (Guard default/web)
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Silakan login sebagai Pustakawan terlebih dahulu.');
        }

        return $next($request);
    }
}