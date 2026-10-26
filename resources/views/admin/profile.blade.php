@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-2xl mx-auto">

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-zinc-950 p-8 rounded-xl border border-zinc-800 shadow-xl">
        <h3 class="text-xl font-bold mb-6 text-zinc-200 border-b border-zinc-800 pb-4">Edit Profil Admin</h3>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required 
                        class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 focus:border-indigo-500 focus:outline-none text-white transition-colors"
                        style="background-color: #18181b; color: white;"> {{-- FIX CSS --}}
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Email Login</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required 
                        class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 focus:border-indigo-500 focus:outline-none text-white transition-colors"
                        style="background-color: #18181b; color: white;"> {{-- FIX CSS --}}
                </div>
            </div>

            <hr class="border-zinc-800 my-6">

            <div>
                <h4 class="text-zinc-300 font-bold mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Ganti Password (Opsional)
                </h4>
                <p class="text-xs text-zinc-500 mb-4">Biarkan kosong jika tidak ingin mengubah password.</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-400 mb-2">Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter"
                            class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 focus:border-indigo-500 focus:outline-none text-white transition-colors"
                            style="background-color: #18181b; color: white;"> {{-- FIX CSS --}}
                        @error('password') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-400 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                            class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 focus:border-indigo-500 focus:outline-none text-white transition-colors"
                            style="background-color: #18181b; color: white;"> {{-- FIX CSS --}}
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 mt-8 pt-4 border-t border-zinc-800">
                <a href="{{ route('admin.dashboard') }}" class="w-full md:w-auto px-6 py-3 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-bold rounded-lg transition text-center border border-zinc-700">
                    Batal / Kembali
                </a>
                
                <button type="submit" class="w-full md:w-auto flex-1 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-indigo-900/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection