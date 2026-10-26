@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-zinc-400 font-bold text-xl">Total: {{ $products->total() }} Game</h3>
    <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 shadow-lg shadow-indigo-500/20 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Game
    </a>
</div>

@if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-lg mb-6 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
@endif

<div class="bg-zinc-950 rounded-xl border border-zinc-800 overflow-hidden shadow-xl">
    <table class="w-full text-left text-sm text-zinc-400">
        <thead class="bg-zinc-900 text-zinc-200 uppercase text-xs font-bold">
            <tr>
                <th class="px-6 py-4">Cover</th>
                <th class="px-6 py-4">Nama Game</th>
                <th class="px-6 py-4">Harga</th>
                <th class="px-6 py-4">Tipe</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-800">
            @forelse($products as $product)
            <tr class="hover:bg-zinc-900/50 transition">
                <td class="px-6 py-4">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-16 h-10 rounded object-cover bg-zinc-800 border border-zinc-700">
                </td>
                <td class="px-6 py-4 font-bold text-zinc-200">{{ $product->name }}</td>
                <td class="px-6 py-4">
                    @if($product->price == 0)
                        <span class="bg-green-500/10 text-green-400 border border-green-500/20 px-2 py-1 rounded text-xs font-bold">GRATIS</span>
                    @else
                        <span class="text-indigo-400 font-mono">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-xs">
                    @if($product->price == 0 && $product->download_link)
                        <span class="text-zinc-500">Download Langsung</span>
                    @else
                        <span class="text-zinc-500">Beli (Email Link)</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center flex justify-center gap-3">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-zinc-800 hover:bg-yellow-600 text-yellow-400 hover:text-white px-3 py-1.5 rounded transition text-xs font-bold">Edit</a>
                    
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus game ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-zinc-800 hover:bg-red-600 text-red-400 hover:text-white px-3 py-1.5 rounded transition text-xs font-bold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-zinc-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Belum ada produk game.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection