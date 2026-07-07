<nav class="bg-slate-900 text-white min-h-screen w-64 fixed left-0 top-0 p-4 shadow-xl z-[100]">
    <div class="mb-8 mt-4 px-4 font-black text-2xl text-red-500 tracking-tight">InvenTsel</div>
    <a href="{{ route('notifications.index') }}" class="relative p-2 text-slate-500 hover:text-red-600 transition">
    <i data-lucide="bell" class="w-5 h-5"></i>
    
    @if(\App\Models\Product::where('stok', '<=', 5)->count() > 0)
        <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full animate-ping"></span>
        <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
    @endif
    </a>
    
<div class="space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
        </a>

        @if(in_array(auth()->user()->role, ['admin', 'staff']))
            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('categories.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="grid" class="w-5 h-5"></i> Kategori
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('products.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="package" class="w-5 h-5"></i> Data Barang
            </a>
            <a href="{{ route('borrowings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('borrowings.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i> Peminjaman
            </a>
        @endif

        @if(in_array(auth()->user()->role, ['admin', 'manager']))
            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('reports.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="bar-chart-3" class="w-5 h-5"></i> Laporan
            </a>
        @endif
    </div>

    <div class="absolute bottom-4 left-0 w-full px-4 space-y-2">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white transition rounded-xl {{ request()->routeIs('profile.*') ? 'bg-slate-800' : '' }}">
            <i data-lucide="user" class="w-5 h-5"></i> Profil
        </a>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-gray-400 hover:text-white transition">
                <i data-lucide="log-out" class="w-5 h-5"></i> Log Out
            </button>
        </form>
    </div>
</nav>