<x-app-layout>
    <div class="space-y-6 animate-in fade-in duration-700">
        <div class="bg-gradient-to-r from-[#8E001B] to-[#551224] p-8 rounded-[32px] text-white shadow-xl">
            <h2 class="text-3xl font-black">Laporan Inventaris</h2>
            <p class="text-red-100/70 text-sm mt-1">
                Analisis mendalam mengenai distribusi stok barang dan performa peminjaman terkini di lingkungan perusahaan.
            </p>
        </div>

    <div class="relative inline-block" x-data="{ open: false }">
        <button @click="open = !open" 
                class="px-8 py-3 bg-[#8E001B] text-white rounded-2xl text-xs font-bold shadow-lg hover:bg-[#551224] transition flex items-center gap-2">
            <i data-lucide="download" class="w-4 h-4"></i> EXPORT DATA
        </button>

        <div x-show="open" 
            @click.away="open = false" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="absolute left-0 mt-4 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50">
            
            <div class="px-4 py-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Peminjaman</div>
            <a href="{{ route('reports.pdf') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-red-50 hover:text-[#8E001B]">Export PDF Peminjaman</a>
            <a href="{{ route('reports.excel') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-red-50 hover:text-[#8E001B]">Export Excel Peminjaman</a>
            
            <div class="border-t border-slate-100 my-2"></div>
            
            <div class="px-4 py-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Barang Inventaris</div>
            <a href="{{ route('products.export.pdf') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-red-50 hover:text-[#8E001B]">Export PDF Barang</a>
            <a href="{{ route('products.export.excel') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-red-50 hover:text-[#8E001B]">Export Excel Barang</a>
        </div>
    </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach([['t' => 'Total Barang', 'v' => $totalBarang, 'c' => 'bg-blue-500', 'i' => 'package'], ['t' => 'Dikembalikan', 'v' => $dikembalikan, 'c' => 'bg-emerald-500', 'i' => 'check-circle'], ['t' => 'Dipinjam', 'v' => $dipinjam, 'c' => 'bg-amber-500', 'i' => 'refresh-cw'], ['t' => 'Terlambat', 'v' => $terlambat, 'c' => 'bg-rose-500', 'i' => 'alert-triangle']] as $stat)
            <div class="bg-white/50 backdrop-blur-lg p-6 rounded-[24px] border border-white/50 flex items-center gap-4">
                <div class="{{ $stat['c'] }} p-3 rounded-2xl text-white shadow-lg"><i data-lucide="{{ $stat['i'] }}" class="w-6 h-6"></i></div>
                <div>
                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">{{ $stat['t'] }}</p>
                    <h4 class="text-2xl font-black text-slate-800">{{ $stat['v'] }}</h4>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white/50 backdrop-blur-lg p-8 rounded-[32px] border h-[400px]">
                <h3 class="font-black text-slate-800 mb-6 text-sm">DISTRIBUSI STATUS PEMINJAMAN</h3>
                <div class="h-[300px] flex justify-center"><canvas id="borrowChart"></canvas></div>
            </div>
            <div class="bg-white/50 backdrop-blur-lg p-8 rounded-[32px] border h-[400px]">
                <h3 class="font-black text-slate-800 mb-6 text-sm">STOK BARANG PER KATEGORI</h3>
                <div class="h-[300px] flex justify-center"><canvas id="categoryChart"></canvas></div>
            </div>
        </div>

        <div class="bg-white/50 backdrop-blur-lg p-8 rounded-[32px] border">
            <h3 class="font-black text-slate-800 mb-6 text-sm uppercase tracking-widest">Top 5 Barang Terpopuler</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach($popularItems as $item)
                <div class="p-4 bg-white/60 rounded-2xl border border-white/50 flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full bg-[#8E001B] text-white flex items-center justify-center font-black mb-3">{{ $loop->iteration }}</div>
                    <p class="font-bold text-slate-800 text-xs mb-1">{{ $item->name }}</p>
                    <p class="text-[10px] font-bold text-[#8E001B]">{{ $item->total }} Transaksi</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const chartOpt = { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } };
        new Chart(document.getElementById('borrowChart'), {
            type: 'doughnut',
            data: { labels: {!! json_encode($chartData['labels']) !!}, datasets: [{ data: {!! json_encode($chartData['values']) !!}, backgroundColor: ['#10b981', '#f59e0b', '#f43f5e'] }] },
            options: { ...chartOpt, cutout: '70%' }
        });
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: { labels: {!! json_encode($catLabels) !!}, datasets: [{ data: {!! json_encode($catValues) !!}, backgroundColor: ['#8E001B', '#D81B3A', '#FF596A', '#BC4749', '#6A994E'] }] },
            options: { ...chartOpt, cutout: '70%' }
        });
    </script>
    @endpush
    <footer class="mt-8 border-t border-white/30 pt-6 pb-4">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
            &copy; {{ date('Y') }} InvenTsel System. All rights reserved.
        </p>

        <div class="flex items-center gap-6">
            <a href="#" class="text-[10px] font-bold text-slate-500 hover:text-red-600 uppercase transition">Support</a>
            <a href="#" class="text-[10px] font-bold text-slate-500 hover:text-red-600 uppercase transition">Privacy</a>
            <a href="#" class="text-[10px] font-bold text-slate-500 hover:text-red-600 uppercase transition">Terms</a>
        </div>
        
    </div>
</footer>
</x-app-layout>