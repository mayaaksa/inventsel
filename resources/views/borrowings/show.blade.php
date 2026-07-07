<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <h3 class="text-lg font-bold text-slate-800 mb-4">Bukti Peminjaman</h3>
    
    @if($borrowing->image)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $borrowing->image) }}" 
                 alt="Bukti Peminjaman" 
                 class="max-w-md rounded-xl border border-slate-200 shadow-md">
        </div>
    @else
        <div class="p-4 bg-slate-50 rounded-xl text-slate-500 italic">
            Tidak ada foto bukti peminjaman.
        </div>
    @endif
</div>