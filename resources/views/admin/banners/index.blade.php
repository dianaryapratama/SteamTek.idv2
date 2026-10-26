@extends('layouts.admin')
@section('title', 'Kelola Banner')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-zinc-400 font-bold text-xl">Daftar Banner Promo</h3>
    <a href="{{ route('admin.banners.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg font-bold">
        + Upload Banner
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($banners as $banner)
    <div class="group relative bg-zinc-900 rounded-xl overflow-hidden border border-zinc-800 hover:border-indigo-500 transition">
        <div class="h-40 overflow-hidden">
            <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
        </div>
        
        <div class="p-4">
            <h4 class="font-bold text-zinc-200">{{ $banner->title }}</h4>
            <p class="text-xs text-zinc-500 mt-1 truncate">{{ $banner->description }}</p>
            
            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="mt-4 text-right" onsubmit="return confirm('Hapus banner ini?');">
                @csrf @method('DELETE')
                <button class="text-red-400 text-xs hover:text-red-300 hover:underline">Hapus Banner</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12 text-zinc-500 border border-zinc-800 border-dashed rounded-xl">
        Belum ada banner aktif.
    </div>
    @endforelse
</div>
@endsection