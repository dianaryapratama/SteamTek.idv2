@extends('layouts.admin')

@section('title', 'Tambah Game Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-zinc-400 hover:text-indigo-400 font-bold flex items-center gap-2">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-zinc-950 p-8 rounded-xl border border-zinc-800 shadow-xl">
        <h2 class="text-2xl font-bold text-zinc-100 mb-6">Tambah Produk Baru</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2">Nama Game / Mod</label>
                <input type="text" name="name" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:outline-none placeholder-zinc-600" placeholder="Contoh: GTA V Mod Menu">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Harga (Rupiah)</label>
                    <input type="number" name="price" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:outline-none placeholder-zinc-600" placeholder="0 untuk Gratis">
                    <p class="text-xs text-zinc-500 mt-1">Isi 0 jika produk ini GRATIS.</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-zinc-400 mb-2">Link File Asli (Berbayar)</label>
                    <input type="url" name="file_url" class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:outline-none placeholder-zinc-600" placeholder="https://drive.google.com/...">
                    <p class="text-xs text-zinc-500 mt-1">Wajib diisi jika produk BERBAYAR.</p>
                </div>
            </div>

            <div class="bg-zinc-900/50 p-4 rounded-lg border border-zinc-800 border-dashed">
                <label class="block text-sm font-medium text-green-400 mb-2">Link Download (Khusus Gratis)</label>
                <input type="url" name="download_link" class="w-full bg-zinc-950 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-green-500 focus:outline-none placeholder-zinc-600" placeholder="Direct Link Download...">
                <p class="text-xs text-zinc-500 mt-1">Isi ini HANYA jika harga produk 0. Pengunjung bisa langsung download tanpa login.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:outline-none placeholder-zinc-600" placeholder="Jelaskan fitur game/mod ini..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-400 mb-2">Cover Image</label>
                <input type="file" name="image" class="w-full text-zinc-400 border border-zinc-700 rounded-lg p-2 bg-zinc-900 file:bg-zinc-800 file:text-white file:border-0 file:mr-4 file:py-2 file:px-4 file:rounded-md cursor-pointer hover:file:bg-zinc-700 transition">
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-cyan-600 hover:from-indigo-500 hover:to-cyan-500 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-indigo-500/20">
                Simpan Produk
            </button>
        </form>
    </div>
</div>
@endsection