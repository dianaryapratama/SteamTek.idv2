<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-white tracking-tight">Buat Akun</h2>
        <p class="text-sm text-zinc-500 mt-1">Bergabung menjadi member SteamTek.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label for="name" class="block text-xs font-medium text-zinc-400 uppercase tracking-wider">Nama Lengkap</label>
                <input id="name" 
                       class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-sm text-white placeholder-zinc-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors" 
                       type="text" 
                       name="name" 
                       :value="old('name')" 
                       required autofocus autocomplete="name"
                       style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div class="space-y-1.5">
                <label for="username" class="block text-xs font-medium text-zinc-400 uppercase tracking-wider">Username</label>
                <input id="username" 
                       class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-sm text-white placeholder-zinc-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors" 
                       type="text" 
                       name="username" 
                       :value="old('username')" 
                       required autocomplete="username"
                       style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
                <x-input-error :messages="$errors->get('username')" class="mt-1" />
            </div>
        </div>

        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-medium text-zinc-400 uppercase tracking-wider">Email</label>
            <input id="email" 
                   class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-sm text-white placeholder-zinc-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors" 
                   type="email" 
                   name="email" 
                   :value="old('email')" 
                   required autocomplete="email"
                   style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="space-y-1.5">
            <div class="flex justify-between">
                <label for="phone" class="block text-xs font-medium text-zinc-400 uppercase tracking-wider">WhatsApp</label>
                <span class="text-[10px] text-zinc-600 italic">Opsional</span>
            </div>
            <input id="phone" 
                   class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-sm text-white placeholder-zinc-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors" 
                   type="text" 
                   name="phone" 
                   :value="old('phone')" 
                   autocomplete="tel" 
                   placeholder="08..."
                   style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
            <x-input-error :messages="$errors->get('phone')" class="mt-1" />
        </div>

        <div class="space-y-1.5">
            <label for="password" class="block text-xs font-medium text-zinc-400 uppercase tracking-wider">Password</label>
            <input id="password" 
                   class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-sm text-white placeholder-zinc-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors"
                   type="password" 
                   name="password" 
                   required autocomplete="new-password"
                   style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="space-y-1.5">
            <label for="password_confirmation" class="block text-xs font-medium text-zinc-400 uppercase tracking-wider">Konfirmasi Password</label>
            <input id="password_confirmation" 
                   class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2.5 text-sm text-white placeholder-zinc-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none transition-colors"
                   type="password" 
                   name="password_confirmation" 
                   required autocomplete="new-password"
                   style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2.5 rounded-lg transition-all duration-200 text-sm shadow-lg shadow-indigo-900/20 border border-indigo-500 hover:border-indigo-400">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <div class="pt-2 text-center border-t border-zinc-800/50">
            <p class="text-sm text-zinc-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition">
                    Login di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>