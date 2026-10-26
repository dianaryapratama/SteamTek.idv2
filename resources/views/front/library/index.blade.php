<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Library - SteamTek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .hide-scroll-bar::-webkit-scrollbar { display: none; }
        .hide-scroll-bar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-100 font-sans antialiased flex flex-col min-h-screen">

    <nav class="bg-zinc-900/90 backdrop-blur-md border-b border-zinc-800/50 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-3xl font-bold tracking-tight text-white hover:text-indigo-400 transition duration-300">
                SteamTek<span class="text-indigo-500">.</span>
                </a>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}" class="relative text-zinc-400 hover:text-white transition-colors duration-200 flex items-center gap-2 group">
                    <div class="relative">
                        <svg class="w-6 h-6 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border border-zinc-900">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </div>
                    <span class="hidden md:inline text-sm font-medium">Keranjang</span>
                </a>
                
                <div class="h-6 w-px bg-zinc-800 hidden md:block"></div>

                <a href="{{ route('contact.index') }}" class="text-zinc-400 hover:text-indigo-400 transition-colors text-sm hidden md:block font-medium">
                    Lapor Bug
                </a>

                <div x-data="{ open: false }" class="relative ml-4">
                    <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-3 focus:outline-none group">
                        <div class="text-right hidden md:block">
                            <div class="text-sm font-bold text-zinc-200 group-hover:text-white transition">
                                {{ Auth::user()->username ?? Auth::user()->name }}
                            </div>
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider group-hover:text-indigo-400 transition">
                                {{ ucfirst(Auth::user()->membership_type) }} Member
                            </div>
                        </div>
                        
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-zinc-700 group-hover:border-indigo-500 transition">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-zinc-800 flex items-center justify-center text-zinc-500 font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-zinc-900 border border-zinc-800 rounded-xl shadow-xl py-2 z-50"
                         x-cloak>
                        
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-zinc-400 hover:bg-zinc-800 hover:text-white transition">
                            👤 Profile Saya
                        </a>
                        
                        <a href="{{ route('front.library') }}" class="block px-4 py-2 text-sm text-white bg-indigo-600/10 font-bold border-l-2 border-indigo-500 transition">
                            🎮 My Library
                        </a>
                        
                        <div class="border-t border-zinc-800 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-zinc-800 hover:text-red-300 transition">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12 flex-grow">
        
        <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-8 gap-4 border-b border-zinc-800 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-10 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Koleksi Game Saya</h1>
                    <p class="text-zinc-500 text-sm mt-1">Kelola dan download game yang sudah Anda beli.</p>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <form action="{{ route('front.library') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-zinc-500 group-focus-within:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari di library..." class="bg-zinc-900 text-sm text-white rounded-xl pl-10 pr-4 py-2.5 border border-zinc-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-full md:w-64 placeholder-zinc-600 transition shadow-lg">
                </form>
            </div>
        </div>

        @if($myGames->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6">
                @foreach($myGames as $item)
                    
                    @php
                        // Logika Link Download
                        if($item->price <= 0) {
                            $linkDownload = $item->product->download_link;
                        } else {
                            $linkDownload = $item->product->file_url;
                        }
                        if(empty($linkDownload)) { $linkDownload = '#'; }
                    @endphp

                    <div class="group relative bg-zinc-900 rounded-xl overflow-hidden border border-zinc-800 hover:border-indigo-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 flex flex-col h-full">
                        <div class="relative aspect-[3/4] overflow-hidden bg-zinc-800">
                            <img src="{{ Storage::url($item->product->image ?? '') }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100">
                            
                            <a href="{{ $linkDownload }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center backdrop-blur-[2px]">
                                <div class="bg-indigo-600 text-white p-3 rounded-full shadow-xl transform scale-75 group-hover:scale-100 transition duration-300 hover:bg-indigo-500 ring-4 ring-indigo-900/50">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 16l-5-5h3V4h4v7h3l-5 5zm0 2H4v2h16v-2h-8z"/></svg>
                                </div>
                            </a>
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="font-bold text-sm text-zinc-200 truncate group-hover:text-indigo-400 transition mb-1">
                                {{ $item->product->name }}
                            </h3>
                            <p class="text-[10px] text-zinc-500 mb-3">Dibeli: {{ $item->created_at->format('d M Y') }}</p>
                            
                            <div class="mt-auto">
                                <a href="{{ $linkDownload }}" target="_blank" class="block w-full text-center bg-zinc-800 hover:bg-indigo-600 hover:text-white text-zinc-400 text-xs font-bold py-2 rounded-lg transition-all border border-zinc-700 hover:border-indigo-500">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 bg-zinc-900/30 rounded-2xl border border-zinc-800 border-dashed">
                <div class="w-20 h-20 bg-zinc-800 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-zinc-300">Library Masih Kosong</h3>
                <p class="text-zinc-500 mt-2 mb-8 text-center max-w-sm">Anda belum membeli game apapun. Yuk cek katalog kami!</p>
                <a href="{{ route('home') }}" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition shadow-lg shadow-indigo-900/20 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Jelajahi Store
                </a>
            </div>
        @endif
    </div>

    <footer x-data="{ activeModal: null }" class="bg-zinc-950 border-t border-zinc-900 pt-16 pb-8 mt-auto relative">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 mb-6 inline-block">SteamTek</a>
                    <p class="text-zinc-500 text-sm leading-relaxed mb-6">Marketplace digital gaming #1 di Indonesia.</p>
                </div>
                <div><h3 class="text-zinc-100 font-bold mb-4">Navigasi</h3><ul class="space-y-2 text-sm text-zinc-500"><li><a href="{{ route('home') }}" class="hover:text-indigo-400 transition">Beranda</a></li><li><a href="{{ route('cart.index') }}" class="hover:text-indigo-400 transition">Keranjang Belanja</a></li><li><a href="{{ route('contact.index') }}" class="hover:text-indigo-400 transition">Lapor Masalah</a></li></ul></div>
                <div><h3 class="text-zinc-100 font-bold mb-4">Bantuan</h3><ul class="space-y-2 text-sm text-zinc-500"><li><a href="#" class="hover:text-indigo-400 transition">Cara Order</a></li><li><a href="#" class="hover:text-indigo-400 transition">Kebijakan Privasi</a></li><li><a href="#" class="hover:text-indigo-400 transition">Syarat & Ketentuan</a></li></ul></div>
                <div><h3 class="text-zinc-100 font-bold mb-4">Metode Pembayaran</h3><div class="flex flex-wrap gap-2"><div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">BCA</div><div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">QRIS</div><div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">GOPAY</div></div></div>
            </div>
            <div class="border-t border-zinc-900 pt-8 flex flex-col md:flex-row justify-between items-center gap-4"><p class="text-zinc-600 text-xs text-center md:text-left">© 2024 SteamTek. All rights reserved.</p></div>
        </div>
    </footer>

</body>
</html>