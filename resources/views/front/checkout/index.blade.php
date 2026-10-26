<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - SteamTek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-zinc-950 text-zinc-100 font-sans antialiased">

    <nav class="bg-zinc-900/80 backdrop-blur-sm border-b border-zinc-800/50 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">SteamTek</a>
            <a href="{{ route('cart.index') }}" class="text-sm text-zinc-400 hover:text-white">&larr; Kembali ke Keranjang</a>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold mb-8">Checkout Pesanan</h1>

        {{-- Tampilkan Pesan Error/Sukses Voucher --}}
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI (FORM UTAMA) --}}
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                    @csrf
                    
                    {{-- 1. DATA PEMBELI --}}
                    <div class="bg-zinc-900 p-6 rounded-xl border border-zinc-800 mb-6">
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <span class="bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                            Data Pembeli
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-400 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" 
                                       value="{{ Auth::check() ? Auth::user()->name : old('name') }}" 
                                       class="w-full bg-zinc-950 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 outline-none" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-400 mb-1">Email (Untuk kirim file)</label>
                                    <input type="email" name="email" 
                                           value="{{ Auth::check() ? Auth::user()->email : old('email') }}" 
                                           class="w-full bg-zinc-950 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 outline-none" required
                                           {{ Auth::check() ? 'readonly' : '' }}>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-zinc-400 mb-1">No. WhatsApp (Aktif)</label>
                                    <input type="text" name="phone" 
                                           value="{{ Auth::check() ? Auth::user()->phone : old('phone') }}" 
                                           placeholder="08xxxxxxxxxx"
                                           class="w-full bg-zinc-950 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 outline-none" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. METODE PEMBAYARAN (SUDAH DIPERBAIKI) --}}
                    <div class="bg-zinc-900 p-6 rounded-xl border border-zinc-800">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <span class="bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                            Metode Pembayaran
                        </h3>
                        <p class="text-zinc-400 text-sm mb-4">Silakan pilih salah satu metode pembayaran di bawah ini:</p>
                        
                        <div class="space-y-3">
                            {{-- Pilihan 1: BCA --}}
                            <label class="flex items-center justify-between p-4 border border-zinc-700 rounded-lg cursor-pointer hover:bg-zinc-800 transition group has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-500/10">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method_id" value="1" class="w-5 h-5 text-indigo-600 bg-zinc-900 border-zinc-600 focus:ring-indigo-500" required checked>
                                    <div>
                                        <div class="font-bold text-white">Transfer Bank BCA</div>
                                        <div class="text-xs text-zinc-400">Verifikasi Manual (Cek WhatsApp)</div>
                                    </div>
                                </div>
                                <span class="bg-zinc-800 text-xs px-2 py-1 rounded text-zinc-300 font-bold">BCA</span>
                            </label>

                            {{-- Pilihan 2: QRIS --}}
                            <label class="flex items-center justify-between p-4 border border-zinc-700 rounded-lg cursor-pointer hover:bg-zinc-800 transition group has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-500/10">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method_id" value="2" class="w-5 h-5 text-indigo-600 bg-zinc-900 border-zinc-600 focus:ring-indigo-500">
                                    <div>
                                        <div class="font-bold text-white">QRIS (Otomatis)</div>
                                        <div class="text-xs text-zinc-400">Scan pakai Gopay/OVO/Dana/ShopeePay</div>
                                    </div>
                                </div>
                                <span class="bg-zinc-800 text-xs px-2 py-1 rounded text-zinc-300 font-bold">QRIS</span>
                            </label>

                            {{-- Pilihan 3: E-Wallet --}}
                            <label class="flex items-center justify-between p-4 border border-zinc-700 rounded-lg cursor-pointer hover:bg-zinc-800 transition group has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-500/10">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method_id" value="3" class="w-5 h-5 text-indigo-600 bg-zinc-900 border-zinc-600 focus:ring-indigo-500">
                                    <div>
                                        <div class="font-bold text-white">E-Wallet Manual</div>
                                        <div class="text-xs text-zinc-400">Dana / Gopay / OVO</div>
                                    </div>
                                </div>
                                <span class="bg-zinc-800 text-xs px-2 py-1 rounded text-zinc-300 font-bold">E-Wallet</span>
                            </label>
                        </div>
                    </div>
                </form> {{-- Tutup Form Utama di sini --}}
            </div>

            {{-- KOLOM KANAN (RINGKASAN & VOUCHER) --}}
            <div class="lg:col-span-1">
                <div class="bg-zinc-900 p-6 rounded-xl border border-zinc-800 sticky top-24 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-6">Ringkasan Pesanan</h3>

                    <div class="space-y-3 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cart as $details)
                            <div class="flex justify-between items-start text-sm">
                                <div class="text-zinc-300">
                                    {{ $details['name'] }} <span class="text-zinc-500">x{{ $details['quantity'] }}</span>
                                </div>
                                <div class="text-zinc-400">
                                    Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    

                    <div class="border-t border-zinc-800 pt-4 space-y-2 mb-6 text-sm">
                        <div class="flex justify-between text-zinc-400">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        {{-- Tampilkan Diskon jika ada --}}
                        @if(isset($discountAmount) && $discountAmount > 0)
                            <div class="flex justify-between text-green-400 font-bold items-center">
                                <div class="flex items-center gap-1">
                                    <span>Diskon</span>
                                    <span class="bg-green-500/20 text-[10px] px-1.5 py-0.5 rounded border border-green-500/30">
                                        Hemat
                                    </span>
                                </div>
                                <span>- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="border-t border-zinc-800 pt-4 mb-6">
                        <div class="flex justify-between items-end">
                            <span class="text-zinc-300 font-bold">Total Tagihan</span>
                            <div class="text-right">
                                @if(isset($discountAmount) && $discountAmount > 0)
                                    <span class="block text-xs text-zinc-500 line-through">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                @endif
                                <span class="text-2xl font-bold text-indigo-400">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Submit Form Utama (Pakai JavaScript untuk trigger form kiri) --}}
                    <button type="button" onclick="document.getElementById('checkoutForm').submit();" class="w-full bg-gradient-to-r from-indigo-600 to-cyan-600 hover:from-indigo-500 hover:to-cyan-500 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-indigo-500/20">
                        Buat Pesanan & Bayar
                    </button>

                    <p class="text-center text-xs text-zinc-500 mt-4">
                        Dengan mengklik tombol di atas, Anda menyetujui Syarat & Ketentuan SteamTek.
                    </p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>