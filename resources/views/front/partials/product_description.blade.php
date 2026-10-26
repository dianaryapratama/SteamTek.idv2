<div x-data="{ expanded: false }" class="relative" x-cloak>
    <h3 class="font-bold text-zinc-200 mb-3 border-l-4 border-indigo-500 pl-3">Deskripsi Produk</h3>
    
    <div class="relative">
        <div class="prose prose-invert prose-sm text-zinc-400 leading-relaxed overflow-hidden transition-all duration-500 ease-in-out"
             :style="expanded ? 'max-height: 10000px' : 'max-height: 150px'">
            
            {!! nl2br(e($product->description)) !!}
            
        </div>

        <div x-show="!expanded" 
             class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-zinc-950 to-transparent pointer-events-none transition-opacity duration-300">
        </div>
    </div>

    <button @click="expanded = !expanded" 
            class="relative z-10 mt-4 text-indigo-400 text-sm font-bold hover:text-indigo-300 flex items-center gap-2 focus:outline-none group transition-all">
        
        <span x-text="expanded ? 'Tutup Deskripsi' : 'Baca Selengkapnya'"></span>
        
        <svg class="w-4 h-4 transition-transform duration-300" 
             :class="expanded ? 'rotate-180' : ''" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
</div>