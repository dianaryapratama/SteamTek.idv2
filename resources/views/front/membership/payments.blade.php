<x-guest-layout>
    <div class="mb-6">
        <a href="{{ route('membership.index') }}" class="text-zinc-500 hover:text-white text-sm">&larr; Kembali</a>
    </div>

    <div class="text-center mb-8">
        <h2 class="text-xl font-bold text-white">Pembayaran {{ ucfirst($type) }}</h2>
        <div class="text-3xl font-bold text-indigo-400 mt-2">Rp {{ number_format($price, 0, ',', '.') }}</div>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-xl mb-6 text-sm text-zinc-300">
        <p class="mb-2 font-bold text-white">Transfer ke:</p>
        <div class="flex justify-between items-center border-b border-zinc-800 pb-2 mb-2">
            <span>BCA</span>
            <span class="font-mono text-white">123-456-7890</span>
        </div>
        <div class="flex justify-between items-center">
            <span>DANA</span>
            <span class="font-mono text-white">0812-3456-7890</span>
        </div>
        <p class="mt-4 text-xs text-zinc-500">Atas nama: <strong>SteamTek Official</strong></p>
    </div>

    <form action="{{ route('membership.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">

        <div>
            <label class="block text-xs font-medium text-zinc-400 uppercase mb-2">Upload Bukti Transfer</label>
            <input type="file" name="proof_image" required class="block w-full text-sm text-zinc-400
              file:mr-4 file:py-2 file:px-4
              file:rounded-full file:border-0
              file:text-xs file:font-semibold
              file:bg-indigo-600 file:text-white
              hover:file:bg-indigo-500
              cursor-pointer bg-zinc-900 border border-zinc-700 rounded-lg">
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition shadow-lg">
            Kirim Bukti Pembayaran
        </button>
    </form>
</x-guest-layout>