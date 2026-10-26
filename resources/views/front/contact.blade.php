<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Masalah - SteamTek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js untuk interaktivitas (Loading state, char counter, dismiss alert) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        /* Custom Animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-100 font-sans antialiased selection:bg-indigo-500 selection:text-white">

    <nav class="bg-zinc-900/80 backdrop-blur-md border-b border-zinc-800/50 sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 hover:opacity-80 transition">SteamTek</a>
            <a href="{{ route('home') }}" class="group flex items-center gap-2 text-sm text-zinc-400 hover:text-white transition-colors">
                <div class="bg-zinc-800 p-1.5 rounded-full group-hover:bg-zinc-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </div>
                <span class="hidden md:inline">Kembali ke Home</span>
            </a>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12 max-w-2xl min-h-[85vh] flex flex-col justify-center animate-fade-in-up">
        
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-500/10 mb-6 ring-1 ring-indigo-500/30">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-3 tracking-tight">Pusat Bantuan</h1>
            <p class="text-zinc-400 text-sm md:text-base leading-relaxed max-w-lg mx-auto">
                Menemukan bug pada Mod? Link download error? Atau ada kendala pembayaran? Ceritakan pada kami, kami siap membantu.
            </p>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="relative bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl mb-8 flex items-start gap-4 shadow-lg shadow-emerald-900/10">
                <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex-1">
                    <h3 class="font-bold text-sm">Laporan Terkirim!</h3>
                    <p class="text-xs mt-1 text-emerald-400/80">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-white transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif

        <div class="bg-zinc-900/50 backdrop-blur-xl p-6 md:p-8 rounded-2xl border border-zinc-800 shadow-2xl relative overflow-hidden group">
            
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition duration-1000"></div>

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6 relative z-10" x-data="{ loading: false, message: '' }" @submit="loading = true">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider ml-1">Nama Kamu</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" name="name" required class="w-full bg-zinc-950/50 border border-zinc-700 rounded-xl pl-10 pr-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:bg-zinc-950 focus:outline-none transition-all placeholder-zinc-600 shadow-inner" placeholder="Contoh: Ucok Subekti">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider ml-1">Email Balasan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="email" name="email" required class="w-full bg-zinc-950/50 border border-zinc-700 rounded-xl pl-10 pr-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:bg-zinc-950 focus:outline-none transition-all placeholder-zinc-600 shadow-inner" placeholder="email@contoh.com">
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-end ml-1">
                        <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider">Detail Masalah</label>
                        <span class="text-[10px] text-zinc-500" x-text="message.length + ' / 500'"></span>
                    </div>
                    <div class="relative">
                        <textarea name="message" x-model="message" maxlength="500" rows="5" required class="w-full bg-zinc-950/50 border border-zinc-700 rounded-xl px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:bg-zinc-950 focus:outline-none transition-all placeholder-zinc-600 shadow-inner resize-none" placeholder="Jelaskan masalah Anda sedetail mungkin. Contoh: Saya sudah melakukan pembayaran via QRIS dengan invoice #STM-123 tapi status masih pending..."></textarea>
                        <div class="absolute bottom-3 right-3 text-zinc-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" :disabled="loading" :class="loading ? 'opacity-75 cursor-not-allowed' : 'hover:scale-[1.01] hover:shadow-indigo-500/30'" class="w-full bg-gradient-to-r from-indigo-600 to-cyan-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-500/20 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    
                    <span x-text="loading ? 'Mengirim Laporan...' : 'Kirim Laporan'"></span>
                    
                    <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>

        <div class="mt-12 text-center border-t border-zinc-800/50 pt-8">
            <p class="text-zinc-500 text-sm mb-4">Butuh respon yang lebih cepat?</p>
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-3 bg-zinc-900 border border-zinc-800 hover:border-green-500/50 px-6 py-3 rounded-full text-zinc-300 hover:text-green-400 font-bold transition-all duration-300 group shadow-lg hover:shadow-green-900/10">
                <span class="w-8 h-8 bg-green-500/10 rounded-full flex items-center justify-center group-hover:bg-green-500/20 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                </span>
                Chat Customer Service
            </a>
        </div>
    </div>

</body>
</html>