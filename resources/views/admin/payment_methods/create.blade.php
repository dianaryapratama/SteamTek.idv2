@extends('layouts.admin')
@section('title', 'Tambah Metode Pembayaran')
@section('content')
<div class="max-w-xl mx-auto bg-zinc-950 p-8 rounded-xl border border-zinc-800">
    <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
            <label class="block text-zinc-400 mb-2">Nama Bank / E-Wallet</label>
            <input type="text" name="name" placeholder="Contoh: Bank BCA atau GoPay" required class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 focus:border-indigo-500 focus:outline-none">
        </div>

        <div x-data="{ type: 'transfer' }">
            <label class="block text-zinc-400 mb-2">Tipe Pembayaran</label>
            <select name="type" x-model="type" class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 focus:border-indigo-500 focus:outline-none mb-4">
                <option value="transfer">Transfer Bank</option>
                <option value="ewallet">E-Wallet (No. HP)</option>
                <option value="qris">QRIS (Upload Gambar)</option>
            </select>

            <div x-show="type !== 'qris'" class="space-y-4">
                <div>
                    <label class="block text-zinc-400 mb-2">Nomor Rekening / HP</label>
                    <input type="text" name="account_number" class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 focus:border-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-zinc-400 mb-2">Atas Nama</label>
                    <input type="text" name="account_holder" class="w-full bg-zinc-900 border border-zinc-700 rounded p-3 focus:border-indigo-500 focus:outline-none">
                </div>
            </div>

            <div x-show="type === 'qris'" class="space-y-4 bg-zinc-900 p-4 rounded border border-zinc-800">
                <label class="block text-zinc-400 mb-2">Upload Gambar QRIS</label>
                <input type="file" name="qris_image" class="text-zinc-400">
                <p class="text-xs text-zinc-500 mt-2">Format: JPG/PNG, Max 2MB.</p>
            </div>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded">Simpan</button>
    </form>
</div>
@endsection