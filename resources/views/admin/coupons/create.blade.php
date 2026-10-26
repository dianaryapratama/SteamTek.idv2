@extends('layouts.admin')

@section('title', 'Buat Voucher Baru')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.coupons.index') }}" class="text-zinc-400 hover:text-indigo-400">&larr; Kembali</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-zinc-950 p-8 rounded-xl border border-zinc-800 shadow-xl">
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2">Kode Voucher</label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="Contoh: MERDEKA45" required style="text-transform: uppercase"
                    class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:outline-none font-mono">
                @error('code') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2">Tipe Diskon</label>
                <select name="type" class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:outline-none">
                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Potongan Langsung (Rp)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2">Nilai Diskon</label>
                <input type="number" name="value" value="{{ old('value') }}" placeholder="Contoh: 10 (untuk 10%) atau 50000 (untuk Rp 50rb)" required 
                    class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:outline-none">
                @error('value') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2">Berlaku Sampai (Opsional)</label>
                <input type="date" name="expires_at" value="{{ old('expires_at') }}"
                    class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-lg transition">
                Simpan Voucher
            </button>
        </form>
    </div>
</div>
@endsection