@extends('layouts.admin')

@section('title', 'Metode Pembayaran')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-zinc-400">Kelola Bank & QRIS</h3>
    <a href="{{ route('admin.payment-methods.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2">
        + Tambah Metode
    </a>
</div>

@if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-lg mb-6">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($methods as $method)
    <div class="bg-zinc-950 border {{ $method->is_active ? 'border-zinc-800' : 'border-red-900/50 opacity-75' }} rounded-xl p-6 relative group">
        
        <span class="absolute top-4 right-4 text-xs font-bold px-2 py-1 rounded bg-zinc-800 text-zinc-400 uppercase">
            {{ $method->type }}
        </span>

        <h3 class="font-bold text-lg text-zinc-200 mb-1">{{ $method->name }}</h3>
        
        @if($method->type == 'qris')
            <div class="my-4 h-32 bg-white p-2 rounded flex items-center justify-center w-32">
                <img src="{{ asset('storage/' . $method->qris_image) }}" class="max-h-full max-w-full">
            </div>
            <p class="text-xs text-zinc-500">Scan QRIS</p>
        @else
            <p class="text-indigo-400 font-mono text-xl my-2">{{ $method->account_number }}</p>
            <p class="text-zinc-500 text-sm">a.n {{ $method->account_holder }}</p>
        @endif

        <div class="mt-6 flex gap-2 pt-4 border-t border-zinc-900">
            <a href="{{ route('admin.payment-methods.edit', $method->id) }}" class="flex-1 bg-zinc-800 hover:bg-indigo-600 text-center py-2 rounded text-sm font-bold text-zinc-300 hover:text-white transition">Edit</a>
            
            <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Hapus metode ini?');">
                @csrf @method('DELETE')
                <button class="bg-zinc-800 hover:bg-red-600 px-4 py-2 rounded text-red-400 hover:text-white transition">
                    🗑️
                </button>
            </form>
        </div>
        
        @if(!$method->is_active)
            <div class="absolute inset-0 bg-zinc-950/80 flex items-center justify-center backdrop-blur-sm rounded-xl">
                <span class="text-red-500 font-bold border border-red-500 px-3 py-1 rounded">NON-AKTIF</span>
            </div>
        @endif
    </div>
    @endforeach
</div>
@endsection