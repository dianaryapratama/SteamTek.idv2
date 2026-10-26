<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SteamTek - Toko Game & Mod</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .hide-scroll-bar::-webkit-scrollbar { display: none; }
        .hide-scroll-bar { -ms-overflow-style: none; scrollbar-width: none; }
        /* Custom scrollbar for webkit */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #18181b; }
        ::-webkit-scrollbar-thumb { background: #3f3f46; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #52525b; }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-100 font-sans antialiased flex flex-col min-h-screen">

    <!-- Navigation - Lebih compact -->
    <nav class="bg-zinc-900/90 backdrop-blur-md border-b border-zinc-800/50 sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl sm:text-3xl font-bold tracking-tight text-white hover:text-indigo-400 transition duration-300">
                SteamTek<span class="text-indigo-500">.</span>
            </a>
            
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('cart.index') }}" class="relative text-zinc-400 hover:text-white transition-colors duration-200 flex items-center gap-2 group">
                    <div class="relative">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border border-zinc-900">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </div>
                    <span class="hidden md:inline text-sm font-medium">Keranjang</span>
                </a>
                
                <div class="h-5 w-px bg-zinc-800 hidden md:block"></div>

                <a href="{{ route('contact.index') }}" class="text-zinc-400 hover:text-indigo-400 transition-colors text-sm hidden md:block font-medium">
                    Lapor Bug
                </a>

                @auth
                    <div x-data="{ open: false }" class="relative ml-2 sm:ml-4">
                        <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 sm:gap-3 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <div class="text-sm font-bold text-zinc-200 group-hover:text-white transition">
                                    {{ Auth::user()->username ?? Auth::user()->name }}
                                </div>
                                <div class="text-[10px] text-zinc-500 uppercase tracking-wider group-hover:text-indigo-400 transition">
                                    {{ ucfirst(Auth::user()->membership_type) }} Member
                                </div>
                            </div>
                            
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden border-2 border-zinc-700 group-hover:border-indigo-500 transition">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-zinc-800 flex items-center justify-center text-zinc-500 font-bold text-sm sm:text-base">
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
                            
                            <a href="{{ route('front.library') }}" class="block px-4 py-2 text-sm text-zinc-400 hover:bg-zinc-800 hover:text-white transition">
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
                @else
                    <a href="{{ route('login') }}" class="ml-2 bg-indigo-600 hover:bg-indigo-500 text-white px-4 sm:px-5 py-2 rounded-lg text-sm font-bold transition shadow-lg shadow-indigo-600/20">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section - Tinggi lebih proporsional -->
    <div x-data="{ activeSlide: 0, slides: {{ isset($banners) && $banners->count() > 0 ? $banners->count() : 1 }}, autoPlay() { if(this.slides > 1) { setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides; }, 5000); } } }" 
         x-init="autoPlay()" 
         class="relative w-full h-[350px] sm:h-[400px] md:h-[500px] bg-zinc-900 border-b border-zinc-800 group z-0">
        <div class="absolute inset-0 w-full h-full z-0">
        @if(isset($banners) && $banners->count() > 0)
            @foreach($banners as $index => $banner)
                <div x-show="activeSlide === {{ $index }}" 
                     x-transition:enter="transition ease-out duration-1000" 
                     x-transition:enter-start="opacity-0 scale-105" 
                     x-transition:enter-end="opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-1000 absolute inset-0" 
                     x-transition:leave-start="opacity-100 scale-100" 
                     x-transition:leave-end="opacity-0 scale-95" 
                     class="absolute inset-0 w-full h-full">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $banner->image) }}')"></div>
                    <div class="absolute inset-0 bg-black/40"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-zinc-950/90 via-transparent to-transparent"></div>
                    <div class="relative container mx-auto px-4 sm:px-6 h-full flex flex-col justify-center pb-16 sm:pb-20 md:pb-24">
                        <div class="max-w-xl sm:max-w-2xl">
                            <div class="inline-flex items-center gap-2 mb-3 sm:mb-4 px-3 py-1 bg-indigo-600/90 backdrop-blur-sm text-white rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider shadow-lg shadow-indigo-500/20 border border-indigo-400/30">
                                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>Featured Promo
                            </div>
                            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold mb-3 sm:mb-4 text-white drop-shadow-2xl leading-tight tracking-tight">{{ $banner->title }}</h1>
                            <p class="text-zinc-200 text-sm sm:text-lg md:text-xl mb-6 sm:mb-8 drop-shadow-md line-clamp-2 leading-relaxed opacity-90">{{ $banner->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="absolute inset-0 w-full h-full flex items-center justify-center bg-zinc-900">
                 <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-20"></div>
                 <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-transparent to-transparent"></div>
                 <div class="relative z-10 text-center px-4 pb-16">
                     <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold mb-3 sm:mb-4 bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-cyan-400 to-indigo-400 animate-gradient-x">SteamTek</h1>
                     <p class="text-zinc-400 text-base sm:text-lg md:text-xl font-light">Platform Top Up & Mod Terpercaya</p>
                 </div>
            </div>
        @endif
        </div>
        
        <!-- Search Form - Posisi lebih proporsional -->
        <div class="absolute bottom-6 sm:bottom-8 md:bottom-10 left-0 right-0 px-4 sm:px-6 z-30">
            <div class="container mx-auto">
                <form action="{{ route('catalog.index') }}" method="GET" class="max-w-xl sm:max-w-2xl mx-auto relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-xl sm:rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
                    <div class="relative flex items-center bg-zinc-900/90 backdrop-blur-xl border border-zinc-700/50 rounded-xl sm:rounded-2xl p-1 sm:p-1.5 shadow-2xl transition-transform transform group-hover:-translate-y-0.5">
                        <div class="pl-3 sm:pl-4 pr-2 text-zinc-500">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full bg-transparent text-white px-2 py-2.5 sm:py-3 focus:outline-none placeholder-zinc-500 text-sm sm:text-base font-medium" 
                               placeholder="Cari game favoritmu...">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-3 sm:px-6 py-2 sm:py-2.5 rounded-lg sm:rounded-xl font-bold transition-all shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 whitespace-nowrap text-sm sm:text-base">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        @if(isset($banners) && $banners->count() > 1)
        <div class="absolute bottom-2 sm:bottom-4 left-0 right-0 flex justify-center gap-2 z-30">
            @foreach($banners as $index => $banner) 
                <button @click="activeSlide = {{ $index }}" 
                        :class="activeSlide === {{ $index }} ? 'bg-indigo-500 w-6 sm:w-8' : 'bg-zinc-600/50 w-2 hover:bg-zinc-400'" 
                        class="h-1.5 rounded-full transition-all duration-300"></button> 
            @endforeach
        </div>
        @endif
    </div>

    <!-- Promo Section - Padding lebih seimbang -->
    <div class="bg-zinc-900/50 border-b border-zinc-800 py-8 sm:py-10 md:py-12" x-data>
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex items-center gap-3 mb-6 sm:mb-8">
                <div class="w-1 h-6 sm:w-1.5 sm:h-8 bg-gradient-to-b from-yellow-500 to-orange-500 rounded-full shadow-[0_0_10px_rgba(234,179,8,0.5)]"></div>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-zinc-100 tracking-tight">Promo Spesial</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Card 1 -->
                <div class="relative overflow-hidden rounded-xl sm:rounded-2xl bg-gradient-to-r from-indigo-900 to-purple-900 p-6 sm:p-8 flex items-center justify-between border border-white/10 group hover:border-white/20 transition-all">
                    <div class="relative z-10 max-w-[65%] sm:max-w-[60%]">
                        <span class="inline-block px-2 sm:px-3 py-1 rounded-full bg-white/10 text-white text-[10px] sm:text-xs font-bold mb-2 sm:mb-3 border border-white/20">LIMITED TIME</span>
                        <h3 class="text-lg sm:text-2xl font-bold text-white mb-1 sm:mb-2 leading-tight">Diskon 50% Mod Bus!</h3>
                        <p class="text-indigo-200 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">Dapatkan mod premium dengan setengah harga minggu ini.</p>
                        <a href="#products" class="inline-block bg-white text-indigo-900 px-4 sm:px-5 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-bold hover:bg-indigo-50 transition">Cek Sekarang</a>
                    </div>
                    <div class="absolute right-0 top-0 bottom-0 w-1/2 bg-[url('https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=2071&auto=format&fit=crop')] bg-cover bg-center opacity-30 group-hover:scale-110 transition-transform duration-700"></div>
                </div>

                <!-- Card 2 -->
                <div class="relative overflow-hidden rounded-xl sm:rounded-2xl bg-gradient-to-r from-yellow-900 to-amber-900 p-6 sm:p-8 flex items-center justify-between border border-white/10 group hover:border-white/20 transition-all cursor-pointer">
                    <div class="relative z-10 max-w-[65%] sm:max-w-[60%]">
                        <span class="inline-block px-2 sm:px-3 py-1 rounded-full bg-white/10 text-white text-[10px] sm:text-xs font-bold mb-2 sm:mb-3 border border-white/20">EXCLUSIVE</span>
                        <h3 class="text-lg sm:text-2xl font-bold text-white mb-1 sm:mb-2 leading-tight">Membership Silver & Gold</h3>
                        <p class="text-amber-200 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">Dapatkan harga spesial dan diskon kejut setiap pembelian.</p>
                        <button @click="$dispatch('open-membership')" class="inline-block bg-white text-amber-900 px-4 sm:px-5 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-bold hover:bg-amber-50 transition shadow-lg">Info Member</button>
                    </div>
                    <div class="absolute right-0 top-0 bottom-0 w-1/2 bg-[url('https://images.unsplash.com/photo-1614680376593-902f74cf0d41?q=80&w=2074&auto=format&fit=crop')] bg-cover bg-center opacity-30 group-hover:scale-110 transition-transform duration-700"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Best Sellers Section - Grid lebih proporsional -->
    <div class="container mx-auto px-4 sm:px-6 py-8 sm:py-10 md:py-12 border-b border-zinc-800">
        <div class="flex items-center gap-3 mb-6 sm:mb-8">
            <div class="w-1 h-6 sm:w-1.5 sm:h-8 bg-gradient-to-b from-red-500 to-pink-500 rounded-full shadow-[0_0_10px_rgba(239,68,68,0.5)]"></div>
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-zinc-100 tracking-tight">Paling Laris 🔥</h2>
        </div>

        @if(isset($bestSellers) && $bestSellers->count() > 0)
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                @foreach($bestSellers as $product)
                    <div class="group relative bg-zinc-900 rounded-xl overflow-hidden border border-zinc-800 hover:border-red-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-red-900/10">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            
                            <div class="absolute top-2 left-2 bg-gradient-to-r from-red-600 to-orange-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-lg">
                                #{{ $loop->iteration }} TOP
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <h3 class="font-bold text-zinc-100 text-xs sm:text-sm mb-2 truncate">{{ $product->name }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-red-400 font-bold text-sm sm:text-base">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-600/20 text-red-400 p-1.5 rounded-lg hover:bg-red-600 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <p class="text-[10px] text-zinc-500 mt-2 text-right">{{ $product->order_items_count ?? 0 }} Terjual</p>
                            <a href="{{ route('product.detail', $product->slug) }}" class="absolute inset-0"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 sm:py-12 bg-zinc-900/30 rounded-xl border border-zinc-800 border-dashed">
                <p class="text-zinc-500 text-sm">Belum ada data penjualan produk berbayar.</p>
            </div>
        @endif
    </div>

    <!-- Latest Catalog Section - Layout lebih proporsional -->
    <div class="flex-grow container mx-auto px-4 sm:px-6 py-8 sm:py-10 md:py-12" id="products">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-6 sm:mb-8">
            <div class="flex items-center gap-3">
                <div class="w-1 h-6 sm:w-1.5 sm:h-8 bg-gradient-to-b from-indigo-500 to-cyan-500 rounded-full shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-zinc-100 tracking-tight">
                    Katalog Terbaru
                </h2>
            </div>
            <a href="{{ route('catalog.index') }}" class="group flex items-center gap-2 text-indigo-400 hover:text-white font-bold text-sm transition">
                Lihat Semua Produk
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        
        <!-- Grid untuk desktop, scroll untuk mobile -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 md:gap-5">
            @forelse($products as $product)
                <div class="group relative bg-zinc-900 rounded-xl sm:rounded-2xl overflow-hidden border border-zinc-800 hover:border-indigo-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 flex flex-col h-full">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-sm">
                            <a href="{{ route('product.detail', $product->slug) }}" class="bg-white text-zinc-900 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-bold hover:bg-indigo-50 hover:text-indigo-700 transition transform scale-90 group-hover:scale-100 shadow-xl">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4 flex flex-col flex-grow">
                        <div class="mb-auto">
                            @if($product->price == 0) 
                                <span class="inline-block py-0.5 px-2 rounded bg-emerald-500/20 text-[9px] sm:text-[10px] font-bold text-emerald-400 uppercase tracking-wider mb-2 border border-emerald-500/30">Free Item</span>
                            @else 
                                <span class="inline-block py-0.5 px-2 rounded bg-zinc-800 text-[9px] sm:text-[10px] font-bold text-indigo-400 uppercase tracking-wider mb-2 border border-zinc-700">Premium</span> 
                            @endif
                            <h3 class="font-bold text-xs sm:text-sm text-zinc-100 leading-snug group-hover:text-indigo-400 transition-colors mb-2 line-clamp-2">{{ $product->name }}</h3>
                        </div>
                        <div class="pt-2 sm:pt-3 border-t border-zinc-800 flex items-center justify-between mt-2">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-zinc-500">Harga</span>
                                @if($product->price == 0) 
                                    <span class="text-emerald-400 font-bold text-sm sm:text-base uppercase tracking-wider">GRATIS</span>
                                @else 
                                    <span class="text-zinc-100 font-bold text-sm sm:text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</span> 
                                @endif
                            </div>
                            @if($product->price == 0)
                                <a href="{{ route('product.detail', $product->slug) }}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all duration-300" title="Download Gratis">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                            @else
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-zinc-800 flex items-center justify-center text-zinc-400 hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-500/40 transition-all duration-300" title="Tambah ke Keranjang">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 sm:py-24 text-center border border-zinc-800 border-dashed rounded-2xl sm:rounded-3xl bg-zinc-900/30">
                    <h3 class="text-xl sm:text-2xl font-bold text-zinc-200">Oops, Produk Kosong</h3>
                    <p class="text-zinc-500 mt-2 max-w-md mx-auto text-sm sm:text-base">Kami tidak dapat menemukan produk.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 sm:mt-12 text-center">
            <a href="{{ route('catalog.index') }}" class="inline-block px-6 sm:px-8 py-2.5 sm:py-3 bg-zinc-900 hover:bg-zinc-800 text-white font-bold rounded-full border border-zinc-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-sm sm:text-base">
                Tampilkan Semua Produk ({{ \App\Models\Product::where('is_active', true)->count() }}+)
            </a>
        </div>
    </div>

    <!-- Footer - Layout lebih rapi -->
    <footer x-data="{ activeModal: null }" 
            @open-membership.window="activeModal = 'membership'"
            class="bg-zinc-950 border-t border-zinc-900 pt-12 sm:pt-16 pb-6 sm:pb-8 mt-auto relative">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 md:gap-12 mb-8 sm:mb-12">
                <div class="col-span-2 md:col-span-1">
                    <a href="{{ route('home') }}" class="text-xl sm:text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 mb-4 sm:mb-6 inline-block">SteamTek</a>
                    <p class="text-zinc-500 text-xs sm:text-sm leading-relaxed mb-4 sm:mb-6">Marketplace digital gaming #1 di Indonesia.</p>
                </div>
                <div>
                    <h3 class="text-zinc-100 font-bold mb-3 sm:mb-4 text-sm sm:text-base">Navigasi</h3>
                    <ul class="space-y-2 text-xs sm:text-sm text-zinc-500">
                        <li><a href="{{ route('home') }}" class="hover:text-indigo-400 transition">Beranda</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-indigo-400 transition">Keranjang Belanja</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-indigo-400 transition">Lapor Masalah</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-zinc-100 font-bold mb-3 sm:mb-4 text-sm sm:text-base">Bantuan</h3>
                    <ul class="space-y-2 text-xs sm:text-sm text-zinc-500 cursor-pointer">
                        <li><a @click.prevent="activeModal = 'caraOrder'" class="hover:text-indigo-400 transition">Cara Order</a></li>
                        <li><a @click.prevent="activeModal = 'privacy'" class="hover:text-indigo-400 transition">Kebijakan Privasi</a></li>
                        <li><a @click.prevent="activeModal = 'terms'" class="hover:text-indigo-400 transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-zinc-100 font-bold mb-3 sm:mb-4 text-sm sm:text-base">Metode Pembayaran</h3>
                    <div class="flex flex-wrap gap-2">
                        <div class="px-2 sm:px-3 py-1.5 sm:py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] sm:text-xs text-zinc-400 font-bold">BCA</div>
                        <div class="px-2 sm:px-3 py-1.5 sm:py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] sm:text-xs text-zinc-400 font-bold">QRIS</div>
                        <div class="px-2 sm:px-3 py-1.5 sm:py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] sm:text-xs text-zinc-400 font-bold">GOPAY</div>
                    </div>
                </div>
            </div>
            <div class="border-t border-zinc-900 pt-6 sm:pt-8 flex flex-col md:flex-row justify-between items-center gap-3 sm:gap-4">
                <p class="text-zinc-600 text-xs text-center md:text-left">© {{ date('Y') }} SteamTek. All rights reserved.</p>
            </div>
        </div>

        <!-- Modal Overlay -->
        <div x-show="activeModal" x-transition.opacity class="fixed inset-0 bg-black/80 z-[60] backdrop-blur-sm" @click="activeModal = null" x-cloak></div>
        
        <!-- Modal Content -->
        <div x-show="activeModal" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 scale-90 translate-y-4" 
             x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
             x-transition:leave-end="opacity-0 scale-90 translate-y-4" 
             class="fixed inset-0 z-[70] flex items-center justify-center p-3 sm:p-4 pointer-events-none" 
             x-cloak>
            <div class="bg-zinc-900 border border-zinc-800 rounded-xl sm:rounded-2xl w-full max-w-2xl max-h-[85vh] sm:max-h-[90vh] flex flex-col shadow-2xl pointer-events-auto" @click.outside="activeModal = null">
                
                <div class="flex justify-between items-center p-4 sm:p-6 border-b border-zinc-800">
                    <h3 class="text-lg sm:text-xl font-bold text-white" x-text="
                        activeModal === 'caraOrder' ? 'Panduan Cara Order' : 
                        (activeModal === 'privacy' ? 'Kebijakan Privasi' : 
                        (activeModal === 'terms' ? 'Syarat & Ketentuan' : 
                        (activeModal === 'membership' ? 'Benefit Membership' : 'Info')))
                    "></h3>
                    <button @click="activeModal = null" class="text-zinc-500 hover:text-white transition p-1">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-4 sm:p-6 overflow-y-auto prose prose-invert prose-sm text-zinc-400 leading-relaxed">
                    
                    <div x-show="activeModal === 'caraOrder'">
                        <ol class="list-decimal pl-4 sm:pl-5 space-y-2 text-sm">
                            <li><strong>Pilih Produk:</strong> Cari game/mod.</li>
                            <li><strong>Cek Detail:</strong> Baca deskripsi.</li>
                            <li><strong>Checkout:</strong> Isi data.</li>
                            <li><strong>Pembayaran:</strong> Bayar via QRIS/Bank.</li>
                            <li><strong>Selesai:</strong> Terima link download.</li>
                        </ol>
                    </div>

                    <div x-show="activeModal === 'membership'">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
                            <div class="bg-zinc-800/50 p-4 sm:p-6 rounded-xl border border-zinc-700 relative overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-zinc-500 blur-3xl opacity-20"></div>
                                <h4 class="text-zinc-200 font-bold text-base sm:text-lg mb-1">Silver Member</h4>
                                <p class="text-zinc-500 text-xs sm:text-xs mb-3 sm:mb-4">Untuk pemula yang ingin hemat.</p>
                                <div class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4">Rp 10.000</div>
                                <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm text-zinc-300">
                                    <li class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg> Diskon 7% All Item
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg> Prioritas Support
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg> Potensi Diskon Kejut
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-gradient-to-br from-yellow-900/40 to-amber-900/40 p-4 sm:p-6 rounded-xl border border-yellow-700/50 relative overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500 blur-3xl opacity-20"></div>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-yellow-400 font-bold text-base sm:text-lg mb-1">Gold Member</h4>
                                        <p class="text-yellow-200/60 text-xs sm:text-xs mb-3 sm:mb-4">Paling untung & eksklusif.</p>
                                    </div>
                                    <span class="bg-yellow-500 text-black text-[9px] sm:text-[10px] font-bold px-2 py-1 rounded">POPULAR</span>
                                </div>
                                <div class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4">Rp 20.000</div>
                                <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm text-zinc-200">
                                    <li class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg> Diskon 14% All Item
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg> Akses Mod Eksklusif
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg> Diskon Kejut Prioritas
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div x-data="{ openTerms: false }" class="border-t border-zinc-800 pt-4">
                            <button @click="openTerms = !openTerms" class="flex items-center justify-between w-full text-left text-xs sm:text-sm font-bold text-zinc-300 hover:text-white transition bg-zinc-800/50 p-3 sm:p-4 rounded-lg">
                                <span>📜 Syarat & Ketentuan Membership</span>
                                <svg class="w-4 h-4 transform transition-transform duration-200" :class="openTerms ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openTerms" x-transition class="mt-2 p-3 sm:p-4 bg-zinc-900/50 rounded-lg text-xs sm:text-sm text-zinc-400 border border-zinc-800">
                                <ul class="list-disc pl-4 sm:pl-5 space-y-1">
                                    <li>Membership berlaku selamanya (Lifetime) selama akun aktif.</li>
                                    <li>Akun dilarang digunakan beramai-ramai (Shared Account), jika ketahuan akan dibekukan.</li>
                                    <li>Diskon otomatis memotong harga saat checkout.</li>
                                    <li>Admin berhak mencabut status member jika ditemukan pelanggaran berat.</li>
                                    <li>Pembayaran membership dilakukan manual via WhatsApp Admin untuk aktivasi.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeModal === 'privacy'">
                        <p class="text-sm">Kami melindungi data privasi Anda.</p>
                    </div>
                    <div x-show="activeModal === 'terms'">
                        <p class="text-sm">Produk digital (non-fisik). No refund.</p>
                    </div>
                </div>

                <div class="p-3 sm:p-4 border-t border-zinc-800 flex justify-end">
                    <button @click="activeModal = null" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 sm:px-6 py-2 rounded-lg text-xs sm:text-sm font-bold transition">Tutup</button>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>