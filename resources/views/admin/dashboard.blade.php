@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-zinc-950 p-6 rounded-2xl border border-zinc-800">
        <p class="text-zinc-500 text-sm mb-2">Total Pendapatan</p>
        <h3 class="text-3xl font-bold text-indigo-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>
    
    <div class="bg-zinc-950 p-6 rounded-2xl border border-zinc-800">
        <p class="text-zinc-500 text-sm mb-2">Perlu Diproses</p>
        <h3 class="text-3xl font-bold {{ $pendingOrders > 0 ? 'text-yellow-400' : 'text-zinc-100' }}">{{ $pendingOrders }} Pesanan</h3>
    </div>

    <div class="bg-zinc-950 p-6 rounded-2xl border border-zinc-800">
        <p class="text-zinc-500 text-sm mb-2">Total Produk</p>
        <h3 class="text-3xl font-bold text-zinc-100">{{ $totalProducts }} Game</h3>
    </div>
</div>

<h3 class="text-xl font-bold mb-4">Pesanan Terbaru</h3>
<div class="bg-zinc-950 rounded-xl border border-zinc-800 overflow-hidden">
    <table class="w-full text-left text-sm text-zinc-400">
        <thead class="bg-zinc-900 text-zinc-200 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Invoice</th>
                <th class="px-6 py-3">Pembeli</th>
                <th class="px-6 py-3">Total</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-800">
            @foreach($recentOrders as $order)
            <tr class="hover:bg-zinc-900/50">
                <td class="px-6 py-4 font-mono">{{ $order->invoice_code }}</td>
                <td class="px-6 py-4">{{ $order->customer_name }}</td>
                <td class="px-6 py-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    @if($order->status == 'waiting_validation')
                        <span class="bg-yellow-500/10 text-yellow-400 px-2 py-1 rounded-md text-xs border border-yellow-500/20">Cek Bukti</span>
                    @elseif($order->status == 'completed')
                        <span class="bg-green-500/10 text-green-400 px-2 py-1 rounded-md text-xs border border-green-500/20">Sukses</span>
                    @else
                        <span class="bg-zinc-800 text-zinc-400 px-2 py-1 rounded-md text-xs">Pending</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-400 hover:text-indigo-300">Lihat</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection