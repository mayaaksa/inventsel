<aside id="sidebar" class="sticky transition-transform rounded-[32px] w-64 bg-gradient-to-b from-[#8E001B] via-[#551224] to-[#23273B] border border-white/15 shadow-[0_20px_60px_rgba(190,24,93,.28)] lg:rounded-3xl">

    <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-red-500/25 blur-[110px]"></div>
    <div class="absolute bottom-0 right-0 w-56 h-56 rounded-full bg-pink-500/20 blur-[120px]"></div>

    <div class="relative h-full flex flex-col">
        <div class="pt-10 pb-8 text-center">
            <h1 class="text-[34px] font-bold tracking-tight text-white">Inven<span class="text-red-400">Tsel</span></h1>
            <p class="mt-2 text-xs tracking-[0.18em] uppercase text-red-100/60">Inventory Management</p>
        </div>

        <nav class="flex-1 px-5">
            <p class="mb-3 px-3 text-[11px] uppercase tracking-[0.22em] text-white/40">Main Menu</p>
            <div class="space-y-1.5">

                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-[#FF4B61] to-[#FF6D6D] text-white shadow-[0_10px_30px_rgba(255,60,90,.35)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10"><i data-lucide="layout-dashboard" class="w-5 h-5"></i></div>
                    <span class="font-medium">Dashboard</span>
                </a>

                @if(in_array(auth()->user()->role, ['admin', 'staff']))
                {{-- Barang --}}
                <a href="{{ route('products.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 transition-all duration-300 {{ request()->routeIs('products.*') ? 'bg-gradient-to-r from-[#FF4B61] to-[#FF6D6D] text-white shadow-[0_10px_30px_rgba(255,60,90,.35)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10"><i data-lucide="package" class="w-5 h-5"></i></div>
                    <span class="font-medium">Barang</span>
                </a>

                <a href="{{ route('categories.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 transition-all duration-300 {{ request()->routeIs('categories.*') ? 'bg-gradient-to-r from-[#FF4B61] to-[#FF6D6D] text-white shadow-[0_10px_30px_rgba(255,60,90,.35)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10"><i data-lucide="layout-grid" class="w-5 h-5"></i></div>
                    <span class="font-medium">Kategori</span>
                </a>

                <a href="{{ route('borrowings.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 transition-all duration-300 {{ request()->routeIs('borrowings.*') ? 'bg-gradient-to-r from-[#FF4B61] to-[#FF6D6D] text-white shadow-[0_10px_30px_rgba(255,60,90,.35)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10"><i data-lucide="archive" class="w-5 h-5"></i></div>
                    <span class="font-medium">Peminjaman</span>
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['admin', 'manager']))
                {{-- Report --}}
                <a href="{{ route('reports.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 transition-all duration-300 {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-[#FF4B61] to-[#FF6D6D] text-white shadow-[0_10px_30px_rgba(255,60,90,.35)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10"><i data-lucide="bar-chart-3" class="w-5 h-5"></i></div>
                    <span class="font-medium">Laporan</span>
                </a>
                @endif
                
            </div>

            <div class="mt-7">
                <p class="mb-3 px-3 text-[11px] uppercase tracking-[0.22em] text-white/40">Account</p>
                <div class="space-y-1.5">
                    {{-- Profil --}}
                    <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3.5 transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-gradient-to-r from-[#FF4B61] to-[#FF6D6D] text-white shadow-[0_10px_30px_rgba(255,60,90,.35)]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10"><i data-lucide="user-round" class="w-5 h-5"></i></div>
                        <span class="font-medium">Profil</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group flex w-full items-center gap-3 rounded-2xl px-4 py-3.5 text-white/70 transition hover:bg-red-500/20 hover:text-white">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10"><i data-lucide="log-out" class="w-5 h-5"></i></div>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="px-6 pb-6 pt-4">
            <div class="border-t border-white/10 pt-4 text-center">
                <p class="mt-1 text-[11px] text-red-200/50">InvenTsel v1.0.0</p>
            </div>
        </div>
    </div>
</aside>
