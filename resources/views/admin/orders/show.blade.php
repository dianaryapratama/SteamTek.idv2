@extends('layouts.admin')

@section('title', 'Detail Pesanan: ' . $order->invoice_code)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-zinc-950 p-6 rounded-xl border border-zinc-800">
            <h3 class="text-lg font-bold mb-4">Barang yang Dibeli</h3>
            @foreach($order->items as $item)
                <div class="flex gap-4 mb-4 pb-4 border-b border-zinc-900 last:border-0">
                    <img src="{{ $item->product->image }}" class="w-16 h-16 rounded object-cover">
                    <div>
                        <p class="font-bold text-zinc-200">{{ $item->product->name }}</p>
                        <p class="text-indigo-400">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
            <div class="mt-4 pt-4 border-t border-zinc-800 flex justify-between font-bold text-lg">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="bg-zinc-950 p-6 rounded-xl border border-zinc-800">
            <h3 class="text-lg font-bold mb-4">Data Pembeli</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <label class="text-zinc-500 block">Nama</label>
                    <span class="text-zinc-200">{{ $order->customer_name }}</span>
                </div>
                <div>
                    <label class="text-zinc-500 block">WhatsApp</label>
                    <a href="https://wa.me/{{ $order->customer_whatsapp }}" target="_blank" class="text-green-400 hover:underline">{{ $order->customer_whatsapp }}</a>
                </div>
                <div class="col-span-2">
                    <label class="text-zinc-500 block">Email</label>
                    <span class="text-zinc-200">{{ $order->customer_email }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-zinc-950 p-6 rounded-xl border border-zinc-800 sticky top-24">
            <h3 class="text-lg font-bold mb-4">Bukti Transfer</h3>
            
            @if($order->proof_of_payment)
                <div class="mb-6">
                    <a href="{{ asset('storage/' . $order->proof_of_payment) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->proof_of_payment) }}" class="w-full rounded-lg border border-zinc-700 hover:opacity-75 transition cursor-zoom-in">
                    </a>
                    <p class="text-xs text-zinc-500 mt-2 text-center">Klik gambar untuk memperbesar</p>
                </div>

                @if($order->status == 'waiting_validation')
                    <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-bold py-3 rounded-lg mb-3 shadow-lg shadow-green-900/20">
                            ✅ Terima Pembayaran
                        </button>
                    </form>
                    <button class="w-full bg-red-900/30 text-red-400 border border-red-900/50 py-3 rounded-lg hover:bg-red-900/50">
                        ❌ Tolak (Data Salah)
                    </button>
                @elseif($order->status == 'completed')
                    <div class="bg-green-500/10 border border-green-500/20 p-4 rounded-lg text-center text-green-400 font-bold mb-4">
                        Pesanan Selesai
                    </div>
                    <div class="text-xs text-zinc-500 break-all">
                        Token: {{ $order->download_token }}
                    </div>
                @endif

            @else
                <div class="text-center py-10 bg-zinc-900 rounded border border-zinc-800 border-dashed text-zinc-500">
                    Belum ada bukti pembayaran
                </div>
            @endif
        </div>
    </div>

</div>
@endsection