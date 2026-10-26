<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - SteamTek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-zinc-950 text-zinc-100 font-sans antialiased">

    <nav class="bg-zinc-900/80 backdrop-blur-sm border-b border-zinc-800/50 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">SteamTek</a>
            <a href="{{ route('home') }}" class="text-sm text-zinc-400 hover:text-white">Lanjut Belanja &rarr;</a>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold mb-8 flex items-center gap-3">
            🛒 Keranjang Belanja
        </h1>

        @if(session('success'))
            <div class="bg-green-500/10 text-green-400 p-4 rounded-xl mb-6 border border-green-500/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500/10 text-red-400 p-4 rounded-xl mb-6 border border-red-500/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-4">
                    @foreach(session('cart') as $id => $details)
                        <div class="flex gap-4 bg-zinc-900/50 p-4 rounded-xl border border-zinc-800 items-center hover:border-zinc-700 transition">
                            <div class="w-24 h-24 rounded-lg overflow-hidden bg-zinc-800 shrink-0">
                                <img src="{{ $details['image'] }}" class="w-full h-full object-cover">
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-white truncate">{{ $details['name'] }}</h3>
                                <p class="text-zinc-500 text-sm mb-1">Game Key / Mod</p>
                                <div class="text-indigo-400 font-bold">
                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                </div>
                            </div>

                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-zinc-500 hover:text-red-500 p-2 transition bg-zinc-900 rounded-lg hover:bg-zinc-800" title="Hapus Item">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-zinc-900 p-6 rounded-xl border border-zinc-800 sticky top-24 shadow-xl">
                        <h3 class="text-xl font-bold mb-6 text-white border-b border-zinc-800 pb-4">Ringkasan Belanja</h3>
                        
                        <div class="mb-6">
                            @if(session('coupon_code'))
                                <div class="flex justify-between items-center bg-green-900/20 border border-green-500/30 p-3 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                        <span class="text-green-400 font-mono font-bold text-sm">{{ session('coupon_code') }}</span>
                                    </div>
                                    <form action="{{ route('cart.removeCoupon') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-red-400 text-xs hover:text-red-300 font-bold">HAPUS</button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('cart.applyCoupon') }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="text" name="code" placeholder="Kode Voucher" class="w-full bg-zinc-950 border border-zinc-700 rounded-lg px-3 py-2 text-sm uppercase focus:border-indigo-500 outline-none transition">
                                    <button type="submit" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">Pakai</button>
                                </form>
                            @endif
                        </div>

                        <div class="space-y-3 mb-6 text-sm">
                            
                            <div class="flex justify-between text-zinc-400">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            @auth
                                @if(auth()->user()->membership_type != 'none')
                                    <div class="flex justify-between text-green-400 items-center">
                                        <div class="flex items-center gap-2">
                                            <span>Member {{ ucfirst(auth()->user()->membership_type) }}</span>
                                            <span class="text-[10px] bg-green-500/20 border border-green-500/30 px-1.5 py-0.5 rounded font-bold">
                                                -{{ auth()->user()->discount_percentage }}%
                                            </span>
                                        </div>
                                        <span>- Rp {{ number_format($discountAmount ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            @else
                                <div class="bg-indigo-900/20 border border-indigo-500/20 p-2 rounded text-xs text-center text-indigo-300">
                                    <a href="{{ route('login') }}" class="underline font-bold">Login</a> untuk dapat diskon member!
                                </div>
                            @endauth

                            @if(session('coupon_amount'))
                                <div class="flex justify-between text-green-400">
                                    <span>Voucher Diskon</span>
                                    <span>- Rp {{ number_format(session('coupon_amount'), 0, ',', '.') }}</span>
                                </div>
                            @endif

                        </div>
                        
                        <div class="border-t border-zinc-800 pt-4 mb-6">
                            <div class="flex justify-between items-end">
                                <span class="text-zinc-300 font-bold">Total Bayar</span>
                                <div class="text-right">
                                    @if(isset($discountAmount) && $discountAmount > 0)
                                        <span class="block text-xs text-zinc-500 line-through">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    @endif
                                    <span class="text-2xl font-bold text-indigo-400">Rp {{ number_format($grandTotal ?? $subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-gradient-to-r from-indigo-600 to-cyan-600 hover:from-indigo-500 hover:to-cyan-500 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 transform hover:-translate-y-0.5 transition-all duration-200">
                            Checkout Sekarang
                        </a>

                        <p class="text-center text-xs text-zinc-500 mt-4 flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Pembayaran Aman & Otomatis
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-24 bg-zinc-900/30 rounded-2xl border border-zinc-800 border-dashed">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-zinc-900 rounded-full mb-6">
                    <svg class="w-10 h-10 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Keranjang Kosong</h3>
                <p class="text-zinc-500 mb-8 max-w-sm mx-auto">Sepertinya kamu belum menambahkan game apapun. Yuk cari game favoritmu!</p>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition shadow-lg shadow-indigo-500/20">
                    Mulai Belanja &rarr;
                </a>
            </div>
        @endif
    </div>
</body>
</html>