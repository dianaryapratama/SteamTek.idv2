@extends('layouts.admin')

@section('title', 'Manajemen Voucher')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-zinc-400">Total: {{ $coupons->total() }} Voucher</h3>
    <a href="{{ route('admin.coupons.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2">
        + Buat Voucher Baru
    </a>
</div>

@if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-zinc-950 rounded-xl border border-zinc-800 overflow-hidden">
    <table class="w-full text-left text-sm text-zinc-400">
        <thead class="bg-zinc-900 text-zinc-200 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Kode</th>
                <th class="px-6 py-3">Tipe</th>
                <th class="px-6 py-3">Nilai</th>
                <th class="px-6 py-3">Expired</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-800">
            @forelse($coupons as $coupon)
            <tr class="hover:bg-zinc-900/50">
                <td class="px-6 py-4 font-mono font-bold text-indigo-400">{{ $coupon->code }}</td>
                <td class="px-6 py-4">
                    @if($coupon->type == 'percent') <span class="bg-blue-500/10 text-blue-400 px-2 py-1 rounded text-xs">Persen (%)</span>
                    @else <span class="bg-green-500/10 text-green-400 px-2 py-1 rounded text-xs">Potongan Harga (Rp)</span>
                    @endif
                </td>
                <td class="px-6 py-4 font-bold text-white">
                    {{ $coupon->type == 'percent' ? $coupon->value . '%' : 'Rp ' . number_format($coupon->value, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4">
                    {{ $coupon->expires_at ? $coupon->expires_at : 'Selamanya' }}
                </td>
                <td class="px-6 py-4 text-center">
                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Hapus voucher ini?');">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-300">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-zinc-500">Belum ada kupon aktif.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection