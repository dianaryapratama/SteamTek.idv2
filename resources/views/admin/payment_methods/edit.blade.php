@extends('layouts.admin')
@section('title', 'Edit Metode Pembayaran')
@section('content')
<div class="max-w-xl mx-auto bg-zinc-950 p-8 rounded-xl border border-zinc-800">
    <form action="{{ route('admin.payment-methods.update', $method->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        
        <div class="flex items-center gap-3 mb-6 bg-zinc-900 p-3 rounded border border-zinc-700">
            <input type="checkbox" name="is_active" id="active" {{ $method->is_active ? 'checked' : '' }} class="w-5 h-5 text-indigo-600">
            <label for="active" class="text-zinc-200 cursor-pointer select-none">Aktifkan Metode Ini</label>
        </div>

        <div>
            <label class="block text-zinc-400 mb-2">Nama Bank / E-Wallet</label>
            <input type="text" name="name" value="{{ $method->name }}" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 focus:border-indigo-500 focus:outline-none">
        </div>

        <div x-data="{ type: '{{ $method->type }}' }">
            <label class="block text-zinc-400 mb-2">Tipe Pembayaran</label>
            <select name="type" x-model="type" class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 focus:border-indigo-500 focus:outline-none mb-4">
                <option value="transfer">Transfer Bank</option>
                <option value="ewallet">E-Wallet</option>
                <option value="qris">QRIS</option>
            </select>

            <div x-show="type !== 'qris'" class="space-y-4">
                <div>
                    <label class="block text-zinc-400 mb-2">Nomor Rekening</label>
                    <input type="text" name="account_number" value="{{ $method->account_number }}" class="w-full bg-zinc-900 border border-zinc-700 rounded p-3">
                </div>
                <div>
                    <label class="block text-zinc-400 mb-2">Atas Nama</label>
                    <input type="text" name="account_holder" value="{{ $method->account_holder }}" class="w-full bg-zinc-900 border border-zinc-700 rounded p-3">
                </div>
            </div>

            <div x-show="type === 'qris'" class="space-y-4 bg-zinc-900 p-4 rounded border border-zinc-800">
                @if($method->qris_image)
                    <img src="{{ asset('storage/' . $method->qris_image) }}" class="w-32 rounded mb-2">
                @endif
                <label class="block text-zinc-400 mb-2">Ganti Gambar QRIS</label>
                <input type="file" name="qris_image" class="text-zinc-400">
            </div>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded">Update</button>
    </form>
</div>
@endsection