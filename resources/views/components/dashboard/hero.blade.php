<div class="relative overflow-hidden rounded-[24px] 
    bg-gradient-to-r from-[#8E001B] via-[#E11D48] to-[#fd4e63] 
    p-6 lg:p-8 shadow-[0_15px_40px_rgba(220,38,38,.20)]">

    {{-- Glow --}}
    <div class="absolute -top-12 right-0 h-56 w-56 rounded-full bg-white/15 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 h-32 w-32 rounded-full bg-red-900/20 blur-3xl"></div>

    <div class="relative z-10 flex items-center justify-between gap-8">
        {{-- Left --}}
        <div>
            <h1 class="text-2xl lg:text-3xl font-black text-white">
                Selamat Datang Kembali, {{ Auth::user()->name }}!
            </h1>
            <p class="mt-2 max-w-lg text-sm text-red-50 leading-6 opacity-90">
                Kelola inventaris dan pantau seluruh peminjaman aset 
                perusahaan secara real-time melalui dashboard ini.
            </p>
        </div>

        {{-- Right Decoration (Avatar/Decoration lebih kecil) --}}
        <div class="hidden lg:block shrink-0">
            <div class="h-28 w-28 rounded-full border border-white/20 bg-white/10 backdrop-blur-xl flex items-center justify-center">
                {{-- Bisa tambahkan ikon atau inisial user di sini --}}
                <i data-lucide="user" class="h-10 w-10 text-white/70"></i>
            </div>
        </div>
    </div>
</div>