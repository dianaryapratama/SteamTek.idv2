<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Edit Profile</h2>
        <p class="text-zinc-400 text-sm">Kelola informasi akun Anda.</p>
    </div>

    @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="mb-4 text-sm text-green-400 text-center bg-green-500/10 p-2 rounded border border-green-500/20">
            Perubahan berhasil disimpan!
        </div>
    @endif

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <div class="flex items-center gap-6">
            <div class="shrink-0">
                @if(Auth::user()->avatar)
                    <img class="h-20 w-20 object-cover rounded-full border-2 border-zinc-700" src="{{ asset('storage/' . Auth::user()->avatar) }}" />
                @else
                    <div class="h-20 w-20 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-500 font-bold text-2xl border-2 border-zinc-700">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <label class="block">
                <span class="sr-only">Choose profile photo</span>
                <input type="file" name="avatar" class="block w-full text-sm text-zinc-400
                  file:mr-4 file:py-2 file:px-4
                  file:rounded-full file:border-0
                  file:text-xs file:font-semibold
                  file:bg-indigo-600 file:text-white
                  hover:file:bg-indigo-500
                  cursor-pointer
                "/>
            </label>
        </div>

        <div>
            <label class="block text-sm font-medium text-zinc-400 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-white focus:border-indigo-500 outline-none transition-colors"
                style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <label class="block text-sm font-medium text-zinc-500 mb-1">Username (Tidak bisa diganti)</label>
            <input type="text" value="{{ $user->username }}" disabled 
                class="w-full bg-zinc-950 border border-zinc-800 rounded-lg px-4 py-2 text-zinc-500 cursor-not-allowed opacity-60"
                style="background-color: #09090b; color: #71717a;"> {{-- FIX CSS Disabled --}}
        </div>

        <div>
            <label class="block text-sm font-medium text-zinc-400 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-white focus:border-indigo-500 outline-none transition-colors"
                style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-lg font-bold text-sm transition shadow-lg shadow-indigo-900/20">
                Simpan Profil
            </button>
        </div>
    </form>

    <div class="mt-10 pt-10 border-t border-zinc-800">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            Ubah Password
        </h3>
        
        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <div>
                <label for="current_password" class="block text-sm font-medium text-zinc-400 mb-1">Password Saat Ini</label>
                <input id="current_password" name="current_password" type="password" autocomplete="current-password" 
                    class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-white focus:border-indigo-500 outline-none transition-colors"
                    style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-zinc-400 mb-1">Password Baru</label>
                <input id="password" name="password" type="password" autocomplete="new-password" 
                    class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-white focus:border-indigo-500 outline-none transition-colors"
                    style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-zinc-400 mb-1">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" 
                    class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-white focus:border-indigo-500 outline-none transition-colors"
                    style="background-color: #09090b; color: white;"> {{-- FIX CSS --}}
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-zinc-800 hover:bg-zinc-700 text-white px-6 py-2 rounded-lg font-bold text-sm border border-zinc-700 transition">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 pt-6 border-t border-zinc-800 text-center">
        <a href="{{ route('home') }}" class="text-zinc-500 hover:text-white text-sm underline transition">
            Kembali ke Beranda
        </a>
    </div>

</x-guest-layout>