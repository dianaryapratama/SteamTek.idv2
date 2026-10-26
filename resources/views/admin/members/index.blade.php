@extends('layouts.admin')

@section('title', 'Kelola Membership')

@section('content')

@if($pendingTransactions->count() > 0)
<div class="mb-10">
    <h3 class="text-xl font-bold text-yellow-500 mb-4 flex items-center gap-2">
        <span class="animate-pulse">🔔</span> Permintaan Upgrade Baru
    </h3>
    <div class="bg-zinc-900 border border-yellow-600/30 rounded-xl overflow-hidden shadow-lg shadow-yellow-900/10">
        <table class="w-full text-left text-sm text-zinc-400">
            <thead class="bg-yellow-900/20 text-yellow-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Paket</th>
                    <th class="px-6 py-3">Transfer</th>
                    <th class="px-6 py-3">Bukti</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @foreach($pendingTransactions as $trx)
                <tr>
                    <td class="px-6 py-4 font-bold text-white">{{ $trx->user->name }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $trx->type == 'gold' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-zinc-700 text-zinc-300' }}">
                            {{ ucfirst($trx->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ asset('storage/' . $trx->proof_image) }}" target="_blank" class="text-indigo-400 underline hover:text-indigo-300 transition">Lihat Foto</a>
                    </td>
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        <form action="{{ route('admin.transactions.approve', $trx->id) }}" method="POST">
                            @csrf
                            <button class="bg-green-600 hover:bg-green-500 text-white px-3 py-1 rounded-lg text-xs font-bold transition shadow-md">Terima</button>
                        </form>
                        <form action="{{ route('admin.transactions.reject', $trx->id) }}" method="POST">
                            @csrf
                            <button class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-lg text-xs font-bold transition shadow-md">Tolak</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="flex items-center justify-between mb-4">
    <h3 class="text-xl font-bold text-zinc-200">Daftar Member Aktif</h3>
</div>

<div class="bg-zinc-950 border border-zinc-800 rounded-xl overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-zinc-400 whitespace-nowrap">
            <thead class="bg-zinc-900 text-zinc-200 uppercase text-xs tracking-wider border-b border-zinc-800">
                <tr>
                    <th class="px-6 py-4 font-semibold">Nama / Username</th>
                    <th class="px-6 py-4 font-semibold">Level Membership</th>
                    <th class="px-6 py-4 font-semibold">Diskon Dasar</th>
                    <th class="px-6 py-4 font-semibold">Diskon Kejut (%)</th>
                    <th class="px-6 py-4 font-semibold">Status Akun</th>
                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse($members as $member)
                <tr class="hover:bg-zinc-900/50 transition">
                    <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <td class="px-6 py-4 align-middle">
                            <div class="font-bold text-white">{{ $member->name }}</div>
                            <div class="text-xs text-zinc-500">{{ $member->username }}</div>
                        </td>
                        
                        <td class="px-6 py-4 align-middle">
                            <div class="relative">
                                <select name="membership_type" class="appearance-none bg-zinc-900 border border-zinc-700 text-white rounded-lg px-3 py-1.5 text-xs font-bold outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-32 cursor-pointer transition
                                    {{ $member->membership_type == 'gold' ? 'text-yellow-400 border-yellow-500/30' : ($member->membership_type == 'silver' ? 'text-zinc-300 border-zinc-600' : 'text-zinc-500') }}">
                                    <option value="none" {{ $member->membership_type == 'none' ? 'selected' : '' }}>Regular</option>
                                    <option value="silver" {{ $member->membership_type == 'silver' ? 'selected' : '' }}>Silver</option>
                                    <option value="gold" {{ $member->membership_type == 'gold' ? 'selected' : '' }}>Gold</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 align-middle">
                            @if($member->membership_type == 'gold')
                                <span class="bg-yellow-500/10 text-yellow-400 px-2 py-1 rounded text-xs font-bold border border-yellow-500/20">14%</span>
                            @elseif($member->membership_type == 'silver')
                                <span class="bg-zinc-700/30 text-zinc-300 px-2 py-1 rounded text-xs font-bold border border-zinc-600/30">7%</span>
                            @else
                                <span class="text-zinc-600 text-xs font-mono">0%</span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-2 group">
                                <input type="number" name="surprise_discount" value="{{ $member->surprise_discount }}" min="0" max="100"
                                    class="w-16 bg-zinc-900 border border-zinc-700 text-white rounded px-2 py-1 text-center focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-xs font-mono group-hover:border-zinc-600 transition">
                                <span class="text-zinc-500 text-xs font-bold">%</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 align-middle">
                            <div class="relative">
                                <select name="status" class="appearance-none bg-zinc-900 border border-zinc-700 text-white rounded-lg px-3 py-1.5 text-xs outline-none focus:border-indigo-500 w-32 cursor-pointer transition {{ $member->is_frozen ? 'border-red-500 text-red-400' : 'text-green-400' }}">
                                    <option value="active" {{ !$member->is_frozen ? 'selected' : '' }}>🟢 Aktif</option>
                                    <option value="frozen" {{ $member->is_frozen ? 'selected' : '' }}>🔴 Bekukan</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center align-middle">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-lg shadow-indigo-900/20 flex items-center justify-center gap-1 mx-auto w-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan
                            </button>
                        </td>
                    </form>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-zinc-500">
                            <svg class="w-10 h-10 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="text-sm">Belum ada member yang terdaftar.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $members->links() }}
</div>

@endsection