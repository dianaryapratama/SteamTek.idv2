<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Lengkap - SteamTek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> [x-cloak] { display: none !important; } </style>
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

                @auth
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
                    <a href="{{ route('login') }}" class="ml-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-lg text-sm font-bold transition shadow-lg shadow-indigo-600/20">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="bg-zinc-900 border-b border-zinc-800 py-12">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 tracking-tight">Katalog Game & Mod</h1>
            <p class="text-zinc-400 mb-8 max-w-2xl mx-auto">Temukan ribuan mod dan game original dengan harga terbaik dan proses instan.</p>
            
            <form action="{{ route('catalog.index') }}" method="GET" class="max-w-xl mx-auto relative group mb-8">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
                <div class="relative flex items-center bg-zinc-950 border border-zinc-700 rounded-full p-1.5 shadow-2xl">
                    <div class="pl-4 pr-2 text-zinc-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-transparent text-white px-2 py-2 focus:outline-none placeholder-zinc-600 text-sm md:text-base" placeholder="Cari berdasarkan nama...">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-full font-bold transition text-sm">Cari</button>
                </div>
            </form>

            <div class="flex justify-center gap-3">
                <a href="{{ route('catalog.index', ['search' => request('search')]) }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold border transition {{ !request('type') ? 'bg-white text-zinc-900 border-white' : 'bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700 hover:text-white' }}">
                   Semua
                </a>
                
                <a href="{{ route('catalog.index', ['type' => 'free', 'search' => request('search')]) }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold border transition {{ request('type') == 'free' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700 hover:text-white' }}">
                   Gratis (Free)
                </a>
                
                <a href="{{ route('catalog.index', ['type' => 'paid', 'search' => request('search')]) }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold border transition {{ request('type') == 'paid' ? 'bg-indigo-500 text-white border-indigo-500' : 'bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700 hover:text-white' }}">
                   Berbayar (Premium)
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-12 flex-grow">
        
        <div class="mb-8 flex items-center gap-2 text-sm">
            @if(request('search') || request('type'))
                <a href="{{ route('catalog.index') }}" class="text-zinc-500 hover:text-white">← Reset Filter</a>
                <span class="text-zinc-700">|</span>
            @endif
            
            <span class="text-zinc-400">Menampilkan: 
                <strong class="text-white">
                    @if(request('type') == 'free') Produk Gratis 
                    @elseif(request('type') == 'paid') Produk Berbayar 
                    @else Semua Produk 
                    @endif
                </strong>
            </span>
            
            @if(request('search'))
                <span class="text-zinc-400">dengan kata kunci <strong class="text-indigo-400">"{{ request('search') }}"</strong></span>
            @endif
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($products as $product)
                <div class="group relative bg-zinc-900 rounded-2xl overflow-hidden border border-zinc-800 hover:border-indigo-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 flex flex-col h-full">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-sm">
                            <a href="{{ route('product.detail', $product->slug) }}" class="bg-white text-zinc-900 px-4 py-2 rounded-full text-sm font-bold hover:bg-indigo-50 hover:text-indigo-700 transition transform scale-90 group-hover:scale-100 shadow-xl">Lihat Detail</a>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="mb-auto">
                            @if($product->price == 0) <span class="inline-block py-0.5 px-2 rounded bg-emerald-500/20 text-[9px] font-bold text-emerald-400 uppercase tracking-wider mb-2 border border-emerald-500/30">Free Item</span>
                            @else <span class="inline-block py-0.5 px-2 rounded bg-zinc-800 text-[9px] font-bold text-indigo-400 uppercase tracking-wider mb-2 border border-zinc-700">Premium</span> @endif
                            <h3 class="font-bold text-sm text-zinc-100 leading-snug group-hover:text-indigo-400 transition-colors mb-2 line-clamp-2">{{ $product->name }}</h3>
                        </div>
                        <div class="pt-3 border-t border-zinc-800 flex items-center justify-between mt-2">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-zinc-500">Harga</span>
                                @if($product->price == 0) <span class="text-emerald-400 font-bold text-sm md:text-base uppercase tracking-wider">GRATIS</span>
                                @else <span class="text-zinc-100 font-bold text-sm md:text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</span> @endif
                            </div>
                            @if($product->price == 0)
                                <a href="{{ route('product.detail', $product->slug) }}" class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all duration-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></a>
                            @else
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">@csrf<button type="submit" class="w-8 h-8 rounded-lg bg-zinc-800 flex items-center justify-center text-zinc-400 hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-500/40 transition-all duration-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></button></form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 text-center">
                    <div class="inline-block p-4 rounded-full bg-zinc-900 text-zinc-600 mb-4"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                    <h3 class="text-xl font-bold text-white">Tidak ditemukan</h3>
                    <p class="text-zinc-500 mt-2">Belum ada produk untuk kategori ini.</p>
                    <a href="{{ route('catalog.index') }}" class="inline-block mt-4 text-indigo-400 hover:text-indigo-300 underline">Lihat Semua Produk</a>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>

    <footer x-data="{ activeModal: null }" 
            @open-membership.window="activeModal = 'membership'"
            class="bg-zinc-950 border-t border-zinc-900 pt-16 pb-8 mt-auto relative">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 mb-6 inline-block">SteamTek</a>
                    <p class="text-zinc-500 text-sm leading-relaxed mb-6">Marketplace digital gaming #1 di Indonesia.</p>
                </div>
                <div><h3 class="text-zinc-100 font-bold mb-4">Navigasi</h3><ul class="space-y-2 text-sm text-zinc-500"><li><a href="{{ route('home') }}" class="hover:text-indigo-400 transition">Beranda</a></li><li><a href="{{ route('cart.index') }}" class="hover:text-indigo-400 transition">Keranjang Belanja</a></li><li><a href="{{ route('contact.index') }}" class="hover:text-indigo-400 transition">Lapor Masalah</a></li></ul></div>
                <div><h3 class="text-zinc-100 font-bold mb-4">Bantuan</h3><ul class="space-y-2 text-sm text-zinc-500 cursor-pointer"><li><a @click.prevent="activeModal = 'caraOrder'" class="hover:text-indigo-400 transition">Cara Order</a></li><li><a @click.prevent="activeModal = 'privacy'" class="hover:text-indigo-400 transition">Kebijakan Privasi</a></li><li><a @click.prevent="activeModal = 'terms'" class="hover:text-indigo-400 transition">Syarat & Ketentuan</a></li></ul></div>
                <div><h3 class="text-zinc-100 font-bold mb-4">Metode Pembayaran</h3><div class="flex flex-wrap gap-2"><div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">BCA</div><div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">QRIS</div><div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">GOPAY</div></div></div>
            </div>
            <div class="border-t border-zinc-900 pt-8 flex flex-col md:flex-row justify-between items-center gap-4"><p class="text-zinc-600 text-xs text-center md:text-left">© {{ date('Y') }} SteamTek. All rights reserved.</p></div>
        </div>

        <div x-show="activeModal" x-transition.opacity class="fixed inset-0 bg-black/80 z-[60] backdrop-blur-sm" @click="activeModal = null" x-cloak></div>
        
        <div x-show="activeModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-4" class="fixed inset-0 z-[70] flex items-center justify-center p-4 pointer-events-none" x-cloak>
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl w-full max-w-2xl max-h-[90vh] flex flex-col shadow-2xl pointer-events-auto" @click.outside="activeModal = null">
                
                <div class="flex justify-between items-center p-6 border-b border-zinc-800">
                    <h3 class="text-xl font-bold text-white" x-text="
                        activeModal === 'caraOrder' ? 'Panduan Cara Order' : 
                        (activeModal === 'privacy' ? 'Kebijakan Privasi' : 
                        (activeModal === 'terms' ? 'Syarat & Ketentuan' : 
                        (activeModal === 'membership' ? 'Benefit Membership' : 'Info')))
                    "></h3>
                    <button @click="activeModal = null" class="text-zinc-500 hover:text-white transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>

                <div class="p-6 overflow-y-auto prose prose-invert prose-sm text-zinc-400 leading-relaxed">
                    
                    <div x-show="activeModal === 'caraOrder'">
                        <ol class="list-decimal pl-5 space-y-2"><li><strong>Pilih Produk:</strong> Cari game/mod.</li><li><strong>Cek Detail:</strong> Baca deskripsi.</li><li><strong>Checkout:</strong> Isi data.</li><li><strong>Pembayaran:</strong> Bayar via QRIS/Bank.</li><li><strong>Selesai:</strong> Terima link download.</li></ol>
                    </div>

                    <div x-show="activeModal === 'membership'">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="bg-zinc-800/50 p-6 rounded-xl border border-zinc-700 relative overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-zinc-500 blur-3xl opacity-20"></div>
                                <h4 class="text-zinc-200 font-bold text-lg mb-1">Silver Member</h4>
                                <p class="text-zinc-500 text-xs mb-4">Untuk pemula yang ingin hemat.</p>
                                <div class="text-2xl font-bold text-white mb-4">Rp 10.000</div>
                                <ul class="space-y-2 text-sm text-zinc-300">
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Diskon 7% All Item</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Prioritas Support</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Potensi Diskon Kejut</li>
                                </ul>
                            </div>

                            <div class="bg-gradient-to-br from-yellow-900/40 to-amber-900/40 p-6 rounded-xl border border-yellow-700/50 relative overflow-hidden">
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500 blur-3xl opacity-20"></div>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-yellow-400 font-bold text-lg mb-1">Gold Member</h4>
                                        <p class="text-yellow-200/60 text-xs mb-4">Paling untung & eksklusif.</p>
                                    </div>
                                    <span class="bg-yellow-500 text-black text-[10px] font-bold px-2 py-1 rounded">POPULAR</span>
                                </div>
                                <div class="text-2xl font-bold text-white mb-4">Rp 20.000</div>
                                <ul class="space-y-2 text-sm text-zinc-200">
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Diskon 14% All Item</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Akses Mod Eksklusif</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Diskon Kejut Prioritas</li>
                                </ul>
                            </div>
                        </div>

                        <div x-data="{ openTerms: false }" class="border-t border-zinc-800 pt-4">
                            <button @click="openTerms = !openTerms" class="flex items-center justify-between w-full text-left text-sm font-bold text-zinc-300 hover:text-white transition bg-zinc-800/50 p-4 rounded-lg">
                                <span>📜 Syarat & Ketentuan Membership</span>
                                <svg class="w-4 h-4 transform transition-transform duration-200" :class="openTerms ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="openTerms" x-transition class="mt-2 p-4 bg-zinc-900/50 rounded-lg text-sm text-zinc-400 border border-zinc-800">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Membership berlaku selamanya (Lifetime) selama akun aktif.</li>
                                    <li>Akun dilarang digunakan beramai-ramai (Shared Account), jika ketahuan akan dibekukan.</li>
                                    <li>Diskon otomatis memotong harga saat checkout.</li>
                                    <li>Admin berhak mencabut status member jika ditemukan pelanggaran berat.</li>
                                    <li>Pembayaran membership dilakukan manual via WhatsApp Admin untuk aktivasi.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeModal === 'privacy'"><p>Kami melindungi data privasi Anda.</p></div>
                    <div x-show="activeModal === 'terms'"><p>Produk digital (non-fisik). No refund.</p></div>
                </div>

                <div class="p-4 border-t border-zinc-800 flex justify-end">
                    <button @click="activeModal = null" class="bg-zinc-800 hover:bg-zinc-700 text-white px-6 py-2 rounded-lg text-sm font-bold transition">Tutup</button>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>