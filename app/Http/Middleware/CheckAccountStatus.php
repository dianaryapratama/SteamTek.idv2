<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user sedang login
        if (Auth::check()) {
            // Cek jika kolom is_frozen bernilai true (1)
            if (Auth::user()->is_frozen) {

                // 1. Logout paksa
                Auth::guard('web')->logout();

                // 2. Hancurkan session
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // 3. Lempar ke halaman login dengan pesan error
                return redirect()->route('login')->withErrors([
                    'login' => 'AKUN DIBEKUKAN: Akun Anda telah dinonaktifkan sementara oleh Admin.',
                ]);
            }
        }

        return $next($request);
    }
}