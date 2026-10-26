<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-white tracking-tight">Login</h2>
        <p class="text-sm text-zinc-500 mt-1">Masuk ke akun member Anda.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div class="space-y-1.5">
            <label for="login" class="block text-xs font-medium text-zinc-400 uppercase tracking-wider">Email / Username</label>
            <input id="login" 
                   class="w-full bg-zinc-950 text-white border border-zinc-800 rounded-lg px-4 py-2.5 text-sm placeholder-zinc-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors autofill:bg-zinc-950 autofill:text-white" 
                   type="text" 
                   name="login" 
                   value="{{ old('login') }}" 
                   required autofocus autocomplete="username" 
                   placeholder="user@example.com"
                   style="background-color: #09090b; color: white;"> {{-- Paksa style inline untuk menimpa browser agent stylesheet --}}
            <x-input-error :messages="$errors->get('login')" class="mt-1" />
        </div>

        <div class="space-y-1.5">
            <div class="flex justify-between items-center">
                <label for="password" class="block text-xs font-medium text-zinc-400 uppercase tracking-wider">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-400 hover:text-indigo-300 transition" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <input id="password" 
                   class="w-full bg-zinc-950 text-white border border-zinc-800 rounded-lg px-4 py-2.5 text-sm placeholder-zinc-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors"
                   type="password"
                   name="password"
                   required autocomplete="current-password"
                   style="background-color: #09090b; color: white;"> {{-- Paksa style inline --}}
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded bg-zinc-800 border-zinc-700 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-zinc-900" name="remember">
            <label for="remember_me" class="ml-2 block text-sm text-zinc-400 select-none cursor-pointer hover:text-zinc-300 transition">
                {{ __('Ingat saya di perangkat ini') }}
            </label>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2.5 rounded-lg transition-all duration-200 text-sm shadow-lg shadow-indigo-900/20 border border-indigo-500 hover:border-indigo-400">
            {{ __('Masuk') }}
        </button>

        <div class="pt-4 text-center border-t border-zinc-800/50">
            <p class="text-sm text-zinc-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition">
                    Buat Akun Baru
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>