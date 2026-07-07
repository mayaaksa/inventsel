<nav class="flex items-center justify-between px-2 py-6">
    <button
    id="menuButton"
    class="lg:hidden p-2 rounded-xl hover:bg-gray-100">

    <i data-lucide="menu"></i>

</button>

    {{-- Left: Judul Dinamis --}}
    <div>
        <h1 class="text-[34px] font-bold text-[#8E001B]">
            @if(request()->routeIs('dashboard')) Dashboard
            @elseif(request()->routeIs('categories.*')) Kategori
            @elseif(request()->routeIs('products.*')) Barang
            @elseif(request()->routeIs('borrowings.*')) Peminjaman
            @elseif(request()->routeIs('reports.*')) Laporan
            @elseif(request()->routeIs('notifications.*'))  
            @elseif(request()->routeIs('profile.edit')) Pengaturan Profil
            @else InvenTsel @endif
        </h1>
    </div>

    {{-- Right --}}
    <div class="flex items-center gap-4">
        {{-- Search Form --}}
        <form action="{{ url()->current() }}" method="GET" class="relative group">
            <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400"></i>
            
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari..."
                class="w-[340px] rounded-full border border-white/60 bg-white/70 backdrop-blur-xl py-3 pl-14 pr-12 text-sm shadow-lg outline-none transition focus:border-red-300 focus:ring-4 focus:ring-red-100">

            {{-- Tombol Hapus (X) - Hanya muncul jika ada teks --}}
            @if(request()->filled('search'))
            <a href="{{ url()->current() }}" 
               class="absolute right-4 top-1/2 -translate-y-1/2 flex h-6 w-6 items-center justify-center rounded-full bg-slate-200 text-slate-600 hover:bg-red-500 hover:text-white transition">
                <i data-lucide="x" class="h-3 w-3"></i>
            </a>
            @endif
        </form>

        {{-- Notification --}}
<a href="{{ route('notifications.index') }}" 
   class="group relative flex h-12 w-12 items-center justify-center rounded-full border border-white/60 bg-white/70 backdrop-blur-xl shadow-lg transition-all hover:scale-105 hover:bg-white active:scale-95">
    
    <i data-lucide="bell" class="h-5 w-5 text-slate-700 transition group-hover:text-red-600"></i>
    
    @if(\App\Models\Product::where('stok', '<=', 5)->count() > 0)
        <span class="absolute right-3 top-3 h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white animate-pulse"></span>
    @endif
</a>

        {{-- Profile --}}
        <div class="flex items-center gap-3 rounded-full border border-white/60 bg-white/70 py-2 pl-2 pr-5 backdrop-blur-xl shadow-lg">
<img
    src="https://api.dicebear.com/9.x/adventurer/svg?seed={{ urlencode(Auth::user()->name) }}"
    alt="Avatar"
    class="h-11 w-11 rounded-full border border-white bg-white"
    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

<div
    style="display:none;"
    class="h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-[#FF596A] to-[#D81B3A] text-white font-semibold">
    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
</div>
            <div class="leading-tight">
                <h3 class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</h3>
                <p class="text-xs text-slate-500">{{ Auth::user()->getRoleNames()->first() }}</p>
            </div>
        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex h-12 w-12 items-center justify-center rounded-full border border-red-100 bg-white/70 backdrop-blur-xl shadow-lg transition hover:bg-red-500 hover:text-white">
                <i data-lucide="log-out" class="h-5 w-5"></i>
            </button>
        </form>
    </div>
</nav>