<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white">Upgrade Membership</h2>
        <p class="text-zinc-400 text-sm">Pilih paket dan nikmati diskon seumur hidup.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-900/50 border border-green-800 text-green-400 rounded-xl text-center text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($pendingTx)
        <div class="bg-yellow-900/20 border border-yellow-800 p-6 rounded-xl text-center">
            <h3 class="text-yellow-500 font-bold mb-2">Menunggu Konfirmasi Admin</h3>
            <p class="text-zinc-400 text-sm">Anda telah mengajukan upgrade ke <strong>{{ ucfirst($pendingTx->type) }}</strong>.</p>
            <p class="text-zinc-500 text-xs mt-2">Mohon tunggu 1x24 jam.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-xl hover:border-zinc-600 transition group">
                <h3 class="text-xl font-bold text-zinc-300 mb-2">Silver</h3>
                <div class="text-2xl font-bold text-white mb-4">Rp 10.000</div>
                <ul class="text-sm text-zinc-400 space-y-2 mb-6">
                    <li>✅ Diskon 7% All Item</li>
                    <li>✅ Masa Aktif Selamanya</li>
                </ul>
                <a href="{{ route('membership.payment', ['type' => 'silver']) }}" class="block w-full text-center bg-zinc-800 hover:bg-zinc-700 text-white py-2 rounded-lg font-bold transition">
                    Pilih Silver
                </a>
            </div>

            <div class="bg-gradient-to-br from-yellow-900/20 to-amber-900/20 border border-yellow-700/30 p-6 rounded-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-yellow-600 text-black text-[10px] font-bold px-2 py-1 rounded-bl-lg">POPULAR</div>
                <h3 class="text-xl font-bold text-yellow-500 mb-2">Gold</h3>
                <div class="text-2xl font-bold text-white mb-4">Rp 20.000</div>
                <ul class="text-sm text-yellow-200/80 space-y-2 mb-6">
                    <li>✅ Diskon 14% All Item</li>
                    <li>✅ Diskon Kejut Prioritas</li>
                    <li>✅ Masa Aktif Selamanya</li>
                </ul>
                <a href="{{ route('membership.payment', ['type' => 'gold']) }}" class="block w-full text-center bg-yellow-600 hover:bg-yellow-500 text-black py-2 rounded-lg font-bold transition shadow-lg shadow-yellow-600/20">
                    Pilih Gold
                </a>
            </div>
        </div>
    @endif
</x-guest-layout>