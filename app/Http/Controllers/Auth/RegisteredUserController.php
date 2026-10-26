<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input (Username & Phone ditambahkan di sini)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class], // <-- Wajib Unik
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'], // <-- Opsional
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Simpan ke Database
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username, // <-- Simpan Username
            'email' => $request->email,
            'phone' => $request->phone,       // <-- Simpan No HP
            'password' => Hash::make($request->password),
            'membership_type' => 'none',      // <-- Default level member
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect ke dashboard atau home setelah daftar
        return redirect(route('home', absolute: false)); 
    }
}