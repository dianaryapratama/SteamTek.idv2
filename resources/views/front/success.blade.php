<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - SteamTek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-zinc-100 font-sans antialiased">

    <div class="container mx-auto px-6 py-12 flex flex-col items-center justify-center min-h-screen">
        
        <div class="w-full max-w-2xl bg-zinc-900 rounded-2xl border border-zinc-800 p-8 shadow-2xl">
            
            @if($order->status == 'completed')
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-green-500/20">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white">Sukses!</h1>
                    <p class="text-zinc-400 mt-2">Silakan download game Anda di bawah ini.</p>
                </div>
            @else
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-yellow-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-yellow-500/20 animate-pulse">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white">Menunggu Verifikasi</h1>
                    <p class="text-zinc-400 mt-2">Admin sedang mengecek pembayaran Anda.</p>
                </div>
            @endif

            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center bg-zinc-950 p-4 rounded-lg border border-zinc-800">
                        <div>
                            <div class="font-bold text-white text-lg">{{ $item->product->name ?? 'Item Produk' }}</div>
                            <div class="text-sm text-zinc-500">
                                {{ $item->price <= 0 ? 'Gratis' : 'Rp ' . number_format($item->price) }}
                            </div>
                        </div>

                        @if($item->price <= 0 || $order->status == 'completed')
                            
                            @php
                                // LOGIKA PEMILIHAN LINK SESUAI REQUEST ANDA
                                if($item->price <= 0) {
                                    // Jika GRATIS, pakai 'download_link'
                                    $linkDownload = $item->product->download_link;
                                } else {
                                    // Jika BERBAYAR, pakai 'file_url'
                                    $linkDownload = $item->product->file_url;
                                }

                                // Fallback jika link kosong (jaga-jaga)
                                if(empty($linkDownload)) {
                                    $linkDownload = '#';
                                }
                            @endphp
                            
                            <a href="{{ $linkDownload }}" target="_blank" class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-lg font-bold text-sm transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download
                            </a>

                        @else
                            <span class="text-xs text-yellow-500 bg-yellow-900/20 px-3 py-1 rounded border border-yellow-900/30">
                                Belum Lunas
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="text-zinc-400 hover:text-white text-sm underline">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>