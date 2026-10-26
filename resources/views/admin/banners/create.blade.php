@extends('layouts.admin')
@section('title', 'Upload Banner Baru')

@section('content')
<div class="max-w-xl mx-auto bg-zinc-950 p-8 rounded-xl border border-zinc-800">
    <h3 class="font-bold text-zinc-200 mb-6">Upload Banner Promo</h3>
    
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label class="block text-zinc-400 text-sm mb-2">Judul Promo</label>
            <input type="text" name="title" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg p-3 text-white focus:outline-none focus:border-indigo-500">
        </div>
        
        <div>
            <label class="block text-zinc-400 text-sm mb-2">Gambar (Landscape, Max 2MB)</label>
            <input type="file" name="image" required class="w-full text-zinc-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
        </div>

        <div>
            <label class="block text-zinc-400 text-sm mb-2">Deskripsi Singkat (Opsional)</label>
            <textarea name="description" rows="2" class="w-full bg-zinc-900 border border-zinc-700 rounded-lg p-3 text-white focus:outline-none focus:border-indigo-500"></textarea>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.banners.index') }}" class="flex-1 bg-zinc-800 text-center py-3 rounded-lg text-zinc-400 hover:text-white">Batal</a>
            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-lg">Upload</button>
        </div>
    </form>
</div>
@endsection