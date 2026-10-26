<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login?
        if (Auth::check()) {

            // 2. Cek apakah usertype-nya 'admin'?
            if (Auth::user()->usertype === 'admin') {
                return $next($request); // Silakan masuk
            }

            // 3. Jika bukan admin, tendang ke halaman home
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses admin.');
        }

        // Jika belum login, tendang ke halaman login
        return redirect()->route('login');
    }
}