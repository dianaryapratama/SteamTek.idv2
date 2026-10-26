@extends('layouts.admin')

@section('title', 'Pesanan Masuk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-zinc-400 font-bold text-xl">Daftar Pesanan Masuk</h3>
</div>

<div class="bg-zinc-950 rounded-xl border border-zinc-800 overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-zinc-400">
            <thead class="bg-zinc-900 text-zinc-200 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Pembeli</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Metode</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse($orders as $order)
                <tr class="hover:bg-zinc-900/50 transition duration-150">
                    <td class="px-6 py-4 font-mono font-medium text-indigo-400">
                        #{{ $order->invoice_code }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-zinc-200 font-bold">{{ $order->customer_name }}</div>
                        <div class="text-xs">{{ $order->customer_email }}</div>
                    </td>
                    <td class="px-6 py-4 font-bold text-zinc-200">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-zinc-800 text-zinc-300 px-2 py-1 rounded text-xs uppercase font-bold">
                            {{ $order->paymentMethod->name ?? 'Unknown' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($order->status == 'pending')
                            <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-3 py-1 rounded-full text-xs font-bold animate-pulse">
                                Menunggu Validasi
                            </span>
                        @elseif($order->status == 'completed')
                            <span class="bg-green-500/10 text-green-500 border border-green-500/20 px-3 py-1 rounded-full text-xs font-bold">
                                Lunas / Selesai
                            </span>
                        @else
                            <span class="bg-red-500/10 text-red-500 border border-red-500/20 px-3 py-1 rounded-full text-xs font-bold">
                                Dibatalkan
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                           class="inline-flex items-center gap-1 bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-lg shadow-indigo-500/20">
                            Detail & Validasi
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-zinc-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Belum ada pesanan masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-zinc-800">
        {{ $orders->links() }}
    </div>
</div>
@endsection