<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        // 1. Validasi Input (Ubah 'email' jadi 'login' agar fleksibel)
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Cek apakah yang diinput itu Email atau Username?
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) 
            ? 'email' 
            : 'username';

        // 3. Coba Login Manual
        if (! \Illuminate\Support\Facades\Auth::attempt([
            $loginType => $request->input('login'), 
            'password' => $request->input('password')
        ], $request->boolean('remember'))) {
            
            // Jika Gagal Login
            throw \Illuminate\Validation\ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        // 4. CEK STATUS BEKU (FROZEN)
        $user = \Illuminate\Support\Facades\Auth::user();
        
        if ($user->is_frozen) {
            \Illuminate\Support\Facades\Auth::logout(); // Tendang keluar
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'login' => 'Akun Anda telah DIBEKUKAN oleh Admin karena pelanggaran.',
            ]);
        }

        // 5. Jika Lolos, Regenerate Session & Masuk
        $request->session()->regenerate();

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

       return redirect()->intended(route('admin.dashboard', absolute: false));
    }
}
