@extends('layouts.admin')

@section('title', 'Laporan Masalah & Komplain')

@section('content')
<div class="bg-zinc-950 rounded-xl border border-zinc-800 overflow-hidden">
    <table class="w-full text-left text-sm text-zinc-400">
        <thead class="bg-zinc-900 text-zinc-200 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Tanggal</th>
                <th class="px-6 py-3">Pengirim</th>
                <th class="px-6 py-3 w-1/2">Pesan</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-800">
            @forelse($complaints as $complaint)
            <tr class="hover:bg-zinc-900/50">
                <td class="px-6 py-4 whitespace-nowrap">{{ $complaint->created_at->format('d M Y H:i') }}</td>
                <td class="px-6 py-4">
                    <span class="block font-bold text-zinc-200">{{ $complaint->name }}</span>
                    <span class="text-xs">{{ $complaint->email }}</span>
                </td>
                <td class="px-6 py-4">
                    <p class="bg-zinc-900 p-3 rounded border border-zinc-800 italic">"{{ $complaint->message }}"</p>
                </td>
                <td class="px-6 py-4">
                    @if($complaint->is_resolved)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                            Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20 animate-pulse">
                            Perlu Tindakan
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        @if(!$complaint->is_resolved)
                        <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button title="Tandai Selesai" class="bg-green-600 hover:bg-green-500 text-white p-2 rounded-lg transition">
                                ✅
                            </button>
                        </form>
                        @endif
                        
                        <form action="{{ route('admin.complaints.destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?');">
                            @csrf @method('DELETE')
                            <button title="Hapus" class="bg-zinc-800 hover:bg-red-900/50 text-red-400 p-2 rounded-lg transition border border-zinc-700">
                                🗑️
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-zinc-500">
                    Tidak ada laporan masuk. Aman terkendali! 🛡️
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $complaints->links() }}
</div>
@endsection