<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - SteamTek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-zinc-100 font-sans antialiased">

    <div class="container mx-auto px-6 py-12 max-w-lg">
        <div class="flex justify-between mb-8 text-sm">
            <span class="text-zinc-500">1. Info</span>
            <span class="text-indigo-400 font-bold">2. Pembayaran</span>
            <span class="text-zinc-500">3. Selesai</span>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 shadow-2xl">
            <div class="text-center mb-8">
                <p class="text-zinc-400 text-sm mb-2">Total Tagihan</p>
                <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </h1>
                <p class="text-zinc-500 text-xs mt-2">Invoice: #{{ $order->invoice_code }}</p>
            </div>

            <div class="bg-zinc-950/50 rounded-xl p-6 border border-zinc-800/50 mb-8 text-center">
                <p class="text-zinc-400 text-sm mb-4">Silakan transfer ke:</p>
                
                @if($order->paymentMethod->type == 'qris')
                    <img src="{{ asset('storage/' . $order->paymentMethod->qris_image) }}" alt="QRIS" class="w-48 h-48 mx-auto rounded-lg mb-4">
                @else
                    <h2 class="text-2xl font-bold text-zinc-100">{{ $order->paymentMethod->name }}</h2>
                    <div class="my-4 bg-zinc-800 py-3 rounded-lg border border-zinc-700 flex justify-center items-center gap-2 cursor-pointer group relative">
                        <span class="font-mono text-xl tracking-wider select-all">{{ $order->paymentMethod->account_number }}</span>
                    </div>
                    <p class="text-zinc-400">a.n {{ $order->paymentMethod->account_holder }}</p>
                @endif
            </div>

            <form action="{{ route('checkout.upload-proof', $order->invoice_code) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Upload Bukti Transfer</label>
                    <input type="file" name="proof_of_payment" accept="image/*" required 
                        class="w-full text-sm text-zinc-400
                        file:mr-4 file:py-2.5 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-600/10 file:text-indigo-400
                        hover:file:bg-indigo-600/20 cursor-pointer border border-zinc-700 rounded-lg p-2">
                    <p class="text-xs text-zinc-500 mt-2">*Format: JPG/PNG, Max: 2MB</p>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-cyan-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 transition-all">
                    Saya Sudah Transfer
                </button>
            </form>
        </div>
    </div>

</body>
</html>