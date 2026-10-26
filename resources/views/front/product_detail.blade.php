<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - SteamTek</title>
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
            </div>
        </div>
    </nav>

    <div class="flex-grow container mx-auto px-6 py-12">
        <div class="flex items-center gap-2 text-sm text-zinc-500 mb-8">
            <a href="{{ route('home') }}" class="hover:text-indigo-400 transition">Home</a>
            <span class="text-zinc-700">/</span>
            <span class="text-zinc-300 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-7">
                <div class="relative group rounded-2xl overflow-hidden bg-zinc-900 border border-zinc-800 shadow-2xl">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-1000"></div>
                    <div class="relative aspect-video w-full">
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>

                <div class="lg:hidden mt-8">
                    @include('front.partials.product_description')
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="lg:sticky lg:top-28">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4 text-white leading-tight">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex text-yellow-400 text-sm">
                            @for($i=1; $i<=5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($avgRating ?? 0) ? 'fill-current' : 'text-zinc-700' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-zinc-400 text-sm">({{ $product->reviews->count() }} Ulasan)</span>
                    </div>

                    <div class="bg-zinc-900/50 border border-zinc-800 rounded-2xl p-6 mb-8 backdrop-blur-sm">
                        
                        @if($product->price == 0)
                            <p class="text-green-400 text-sm mb-1 font-bold uppercase tracking-wider">✨ Free License</p>
                            <div class="flex items-end gap-3 mb-6">
                                <span class="text-4xl font-bold text-white">GRATIS</span>
                                <span class="text-zinc-500 line-through mb-1 text-sm">Rp 50.000</span>
                            </div>

                            @if($product->download_link)
                                <a href="{{ $product->download_link }}" target="_blank" 
                                   class="w-full group relative flex items-center justify-center gap-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-green-500/20 hover:shadow-green-500/40 hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <span>Download Sekarang</span>
                                </a>
                                <p class="text-xs text-zinc-500 text-center mt-3">Link download eksternal.</p>
                            @else
                                <button disabled class="w-full bg-zinc-800 text-zinc-500 font-bold py-4 px-6 rounded-xl cursor-not-allowed">
                                    Link Belum Tersedia
                                </button>
                            @endif

                        @else
                            <p class="text-zinc-400 text-sm mb-1">Harga Resmi</p>
                            <div class="flex items-end gap-3 mb-6">
                                <span class="text-4xl font-bold text-indigo-400">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full group relative flex items-center justify-center gap-3 bg-gradient-to-r from-indigo-600 to-cyan-600 hover:from-indigo-500 hover:to-cyan-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span>Tambah ke Keranjang</span>
                                </button>
                            </form>
                        @endif

                        <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-zinc-800">
                            <div class="flex items-center gap-3 text-sm text-zinc-300">
                                <div class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-green-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <span>{{ $product->price == 0 ? 'Instant Download' : 'Pengiriman Instan' }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-zinc-300">
                                <div class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-blue-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <span>{{ $product->price == 0 ? 'Tanpa Login' : 'Jaminan Aman' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block">
                        @include('front.partials.product_description')
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 border-t border-zinc-800 pt-12">
            <h2 class="text-2xl font-bold mb-8 text-zinc-100">Ulasan Pengguna</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2 space-y-6">
                    @forelse($product->reviews as $review)
                        <div class="bg-zinc-900/50 p-6 rounded-2xl border border-zinc-800 hover:border-zinc-700 transition">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-white text-sm">
                                        {{ substr($review->reviewer_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-zinc-200">{{ $review->reviewer_name }}</h4>
                                        <span class="text-xs text-zinc-500">{{ $review->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="flex text-yellow-400 text-xs bg-zinc-950 px-2 py-1 rounded-full border border-zinc-800">
                                    @for($i=0; $i < $review->rating; $i++) 
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-zinc-400 text-sm leading-relaxed italic">"{{ $review->comment }}"</p>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-zinc-900/30 rounded-2xl border border-zinc-800 border-dashed">
                            <p class="text-zinc-500 italic">Belum ada ulasan. Jadilah yang pertama mereview!</p>
                        </div>
                    @endforelse
                </div>

                <div class="bg-zinc-900 p-6 rounded-2xl border border-zinc-800 h-fit sticky top-24">
                    <h3 class="font-bold text-zinc-100 mb-2">Bagikan Pengalamanmu</h3>
                    <p class="text-xs text-zinc-500 mb-6">Pastikan kamu sudah memiliki Invoice ID yang valid.</p>

                    <form action="{{ route('review.store', $product->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <input type="text" name="invoice_code" placeholder="Kode Invoice (Cth: STM-17xxxx)" required 
                                class="w-full bg-zinc-950 border border-zinc-700 rounded-xl px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition placeholder-zinc-600">
                        </div>
                        <div>
                            <input type="text" name="name" placeholder="Nama Kamu" required 
                                class="w-full bg-zinc-950 border border-zinc-700 rounded-xl px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition placeholder-zinc-600">
                        </div>
                        <div>
                            <select name="rating" required class="w-full bg-zinc-950 border border-zinc-700 rounded-xl px-4 py-3 text-sm text-zinc-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                <option value="" disabled selected>Pilih Bintang</option>
                                <option value="5">⭐⭐⭐⭐⭐ (Sempurna)</option>
                                <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                <option value="3">⭐⭐⭐ (Biasa)</option>
                                <option value="2">⭐⭐ (Kurang)</option>
                                <option value="1">⭐ (Buruk)</option>
                            </select>
                        </div>
                        <div>
                            <textarea name="comment" rows="3" placeholder="Tulis komentar..." required 
                                class="w-full bg-zinc-950 border border-zinc-700 rounded-xl px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition placeholder-zinc-600"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-zinc-800 hover:bg-zinc-700 text-white font-bold py-3 rounded-xl transition text-sm border border-zinc-700 hover:border-zinc-600">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

 <footer x-data="{ activeModal: null }" class="bg-zinc-950 border-t border-zinc-900 pt-16 pb-8 mt-auto relative">
        
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 mb-6 inline-block">
                        SteamTek
                    </a>
                    <p class="text-zinc-500 text-sm leading-relaxed mb-6">
                        Marketplace digital gaming #1 di Indonesia. Menyediakan Mod, Akun, dan Top Up dengan proses otomatis.
                    </p>
                </div>

                <div>
                    <h3 class="text-zinc-100 font-bold mb-4">Navigasi</h3>
                    <ul class="space-y-2 text-sm text-zinc-500">
                        <li><a href="{{ route('home') }}" class="hover:text-indigo-400 transition">Beranda</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-indigo-400 transition">Keranjang Belanja</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-indigo-400 transition">Lapor Masalah</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-zinc-100 font-bold mb-4">Bantuan</h3>
                    <ul class="space-y-2 text-sm text-zinc-500 cursor-pointer">
                        <li><a @click.prevent="activeModal = 'caraOrder'" class="hover:text-indigo-400 transition">Cara Order</a></li>
                        <li><a @click.prevent="activeModal = 'privacy'" class="hover:text-indigo-400 transition">Kebijakan Privasi</a></li>
                        <li><a @click.prevent="activeModal = 'terms'" class="hover:text-indigo-400 transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-zinc-100 font-bold mb-4">Metode Pembayaran</h3>
                    <div class="flex flex-wrap gap-2">
                         <div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">BCA</div>
                         <div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">QRIS</div>
                         <div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">GOPAY</div>
                         <div class="px-3 py-2 bg-zinc-900 rounded border border-zinc-800 text-[10px] text-zinc-400 font-bold">DANA</div>
                    </div>
                </div>
            </div>

            <div class="border-t border-zinc-900 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-zinc-600 text-xs text-center md:text-left">© 2024 SteamTek. All rights reserved.</p>
                <div class="flex gap-4 opacity-50 hover:opacity-100 transition">
                    <div class="w-5 h-5 bg-zinc-800 rounded-full"></div>
                    <div class="w-5 h-5 bg-zinc-800 rounded-full"></div>
                </div>
            </div>
        </div>

        <div x-show="activeModal" 
             x-transition.opacity 
             class="fixed inset-0 bg-black/80 z-[60] backdrop-blur-sm"
             @click="activeModal = null"
             x-cloak></div>

        <div x-show="activeModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4"
             class="fixed inset-0 z-[70] flex items-center justify-center p-4 pointer-events-none"
             x-cloak>

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl w-full max-w-2xl max-h-[80vh] flex flex-col shadow-2xl pointer-events-auto" @click.outside="activeModal = null">
                
                <div class="flex justify-between items-center p-6 border-b border-zinc-800">
                    <h3 class="text-xl font-bold text-white" x-text="
                        activeModal === 'caraOrder' ? 'Panduan Cara Order' : 
                        (activeModal === 'privacy' ? 'Kebijakan Privasi' : 'Syarat & Ketentuan')
                    "></h3>
                    <button @click="activeModal = null" class="text-zinc-500 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto prose prose-invert prose-sm text-zinc-400 leading-relaxed">
                    
                    <div x-show="activeModal === 'caraOrder'">
                        <ol class="list-decimal pl-5 space-y-2">
                            <li><strong>Pilih Produk:</strong> Cari game atau mod yang Anda inginkan di katalog kami.</li>
                            <li><strong>Cek Detail:</strong> Baca deskripsi produk. Jika gratis, klik tombol <em>Download</em>. Jika berbayar, klik <em>Tambah ke Keranjang</em>.</li>
                            <li><strong>Checkout:</strong> Pergi ke halaman keranjang, lalu isi data diri singkat (Nama & Email).</li>
                            <li><strong>Pembayaran:</strong> Pilih metode pembayaran (QRIS/Transfer/E-Wallet) dan selesaikan pembayaran.</li>
                            <li><strong>Validasi:</strong> Upload bukti transfer. Admin kami akan memvalidasi pesanan Anda dalam 5-10 menit.</li>
                            <li><strong>Selesai:</strong> Link download akan dikirim ke Email Anda dan tersedia di halaman detail pesanan.</li>
                        </ol>
                    </div>

                    <div x-show="activeModal === 'privacy'">
                        <p>Di SteamTek, privasi Anda adalah prioritas kami. Kami berkomitmen untuk melindungi data pribadi yang Anda bagikan.</p>
                        <ul class="list-disc pl-5 space-y-2 mt-2">
                            <li><strong>Data yang Kami Kumpulkan:</strong> Nama, Email, dan Nomor WhatsApp hanya untuk keperluan transaksi.</li>
                            <li><strong>Penggunaan Data:</strong> Kami tidak akan pernah menjual data Anda ke pihak ketiga. Data hanya digunakan untuk mengirim link produk.</li>
                            <li><strong>Keamanan:</strong> Website kami menggunakan enkripsi SSL untuk memastikan keamanan transaksi.</li>
                        </ul>
                    </div>

                    <div x-show="activeModal === 'terms'">
                        <p>Dengan membeli produk di SteamTek, Anda menyetujui hal-hal berikut:</p>
                        <ul class="list-disc pl-5 space-y-2 mt-2">
                            <li><strong>Produk Digital:</strong> Barang yang dijual adalah produk digital (Non-fisik). Tidak ada pengiriman kurir.</li>
                            <li><strong>Garansi:</strong> Kami menjamin link download berfungsi. Jika file rusak, kami akan mengirim ulang.</li>
                            <li><strong>Refund:</strong> Refund hanya berlaku jika produk yang dikirim tidak sesuai dengan deskripsi atau stok habis.</li>
                            <li><strong>Larangan:</strong> Dilarang keras menyebarluaskan (resell) mod/game berbayar yang dibeli dari sini tanpa izin kreator.</li>
                        </ul>
                    </div>

                </div>

                <div class="p-4 border-t border-zinc-800 flex justify-end">
                    <button @click="activeModal = null" class="bg-zinc-800 hover:bg-zinc-700 text-white px-6 py-2 rounded-lg text-sm font-bold transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </footer>

</body>
</html>