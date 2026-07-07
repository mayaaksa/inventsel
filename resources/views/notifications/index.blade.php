<x-app-layout>
    <div class="max-w-4xl mx-auto px-4">
        <div class="mb-8 flex items-end justify-between">
            <div>
                <h1 class="text-3xl font-black text-[#8E001B]">Pusat Notifikasi</h1>
                <p class="text-slate-500 text-sm mt-1">Cek stok barangmu yang hampir habis!</p>
            </div>
            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">
                {{ $lowStockProducts->count() }} Alert
            </span>
        </div>

        <div class="grid gap-3">
            @forelse($lowStockProducts as $product)
            <div class="group flex items-center justify-between p-5 bg-white/70 backdrop-blur-xl border border-white/50 rounded-3xl shadow-sm transition-all hover:shadow-md hover:border-red-200">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-50 text-red-500 rounded-2xl group-hover:bg-red-500 group-hover:text-white transition-colors">
                        <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-m">{{ $product->nama_barang }}</h3>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Sisa stok: {{ $product->stok }} unit</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-white/40 rounded-[30px] border border-dashed border-slate-300">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="check-circle" class="w-8 h-8 text-slate-400"></i>
                </div>
                <p class="font-bold text-slate-600">Semua stok aman!</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>