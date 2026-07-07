@props(['recentBorrowings'])

<div class="rounded-[24px] border border-white/50 bg-white/60 backdrop-blur-2xl shadow-xl p-6">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-red-500 to-pink-500 shadow-lg shadow-pink-500/20">
                <i data-lucide="history" class="h-5 w-5 text-white"></i>
            </div>
            <div>
<h3
                        class="text-xl font-semibold text-slate-800">

                        Riwayat Terkini

                    </h3>
                                        <p
                        class="text-sm text-slate-500">

                        Terakhir dipinjam
                    </p>
            </div>
        </div>
        <a href="{{ route('peminjaman.index') }}" class="text-[12px] font-bold text-pink-600 hover:text-pink-700 uppercase tracking-wider transition underline decoration-2 underline-offset-4">
            Lihat Semua
        </a>
    </div>

    <div class="space-y-3">
        @forelse($recentBorrowings->take(3) as $borrowing)
            @php
                $statusColor = match ($borrowing->status) {
                    'Dipinjam' => 'text-red-500',
                    'Dikembalikan' => 'text-emerald-500',
                    default => 'text-amber-500',
                };
            @endphp

            <a href="{{ route('peminjaman.show', $borrowing->id) }}" 
               class="group flex items-center justify-between rounded-xl bg-white/50 p-3 transition-all hover:bg-white hover:shadow-md border border-transparent hover:border-pink-100">
                
                <div class="flex items-center gap-1">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-pink-50 text-pink-500 group-hover:bg-pink-500 group-hover:text-white transition-colors">
                        <i data-lucide="package" class="h-4 w-4"></i>
                    </div>
                    <div>
                        <h3 class="text-m font-bold text-slate-800 leading-tight">
                            {{ $borrowing->details->first()->product->nama_barang ?? 'Barang Terhapus' }}
                        </h3>
                        <p class="text-[10px] font-medium text-slate-400 mt-0.5">
                            {{ $borrowing->user->name ?? 'User' }} • {{ $borrowing->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-[12px] font-black tracking-tight {{ $statusColor }}">
                        {{ $borrowing->status }}
                    </p>
                </div>
            </a>
        @empty
            <div class="py-6 text-center text-[11px] text-slate-400 italic">
                Belum ada riwayat peminjaman.
            </div>
        @endforelse
    </div>
</div>