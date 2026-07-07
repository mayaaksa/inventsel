<x-app-layout>
    @if(session('success') || session('error'))
        <div class="p-6 rounded-[32px] mb-8 shadow-sm border backdrop-blur-md text-white font-bold text-center {{ session('success') ? 'bg-green-500/90 border-green-400' : 'bg-red-500/90 border-red-400' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <div class="space-y-8" x-data="{ 
        editModal: false, createModal: false, deleteModal: false, deleteUrl: '',
        sortOpen: false,
        openEdit(id, name) { 
            document.getElementById('editName').value = name;
            document.getElementById('editForm').action = '/categories/' + id;
            this.editModal = true; 
        }
    }">

        <div class="flex items-stretch gap-6 h-[140px]">
            <div class="flex-1 bg-gradient-to-r from-[#8E001B] to-[#551224] p-10 rounded-[32px] shadow-xl text-white flex flex-col justify-center">
                <h2 class="text-3xl font-black tracking-tight">Katalog Kategori</h2>
                <p class="text-red-100/70 text-sm mt-1">Kelola aset perusahaan Anda.</p>
            </div>
            <div class="bg-white/70 backdrop-blur-md px-10 rounded-[32px] border border-white/50 shadow-sm text-center flex flex-col justify-center w-56">
                <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Total Kategori</p>
                <h3 class="text-5xl font-black text-gray-800">{{ $categories->total() }}</h3>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <button @click="createModal = true" class="flex items-center gap-2 px-6 py-3 bg-[#8E001B] text-white rounded-2xl shadow-sm hover:bg-[#6e0015] font-bold text-sm transition-all">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kategori
            </button>
            <div class="relative">
                <button @click="sortOpen = !sortOpen" class="flex items-center gap-2 px-6 py-3 bg-white rounded-2xl shadow-sm hover:bg-red-50 font-bold text-sm text-gray-700">
                    <i data-lucide="filter" class="w-4 h-4"></i> Urutkan
                </button>
                <div x-show="sortOpen" @click.away="sortOpen = false" x-cloak class="absolute top-14 right-0 bg-white shadow-xl rounded-2xl w-40 p-2 z-40 border border-gray-100">
                    <a href="?sort=newest" class="block px-4 py-2 hover:bg-red-50 rounded-xl text-sm font-bold text-gray-700">Terbaru</a>
                    <a href="?sort=oldest" class="block px-4 py-2 hover:bg-red-50 rounded-xl text-sm font-bold text-gray-700">Terlama</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($categories as $category)
            <div class="bg-white/70 backdrop-blur-md p-5 rounded-[24px] border border-white/50 shadow-sm hover:shadow-md transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-gradient-to-br from-[#FF596A] to-[#D81B3A] rounded-2xl text-white shadow-md">
                        <i data-lucide="layers" class="w-5 h-5"></i>
                    </div>
                    <div class="flex gap-1">
                        <button @click="openEdit({{ $category->id }}, '{{ $category->name }}')" class="p-2 text-gray-400 hover:text-blue-600"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                        <button @click="deleteUrl = '{{ route('categories.destroy', $category->id) }}'; deleteModal = true" class="p-2 text-gray-400 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </div>
                <h3 class="text-md font-bold text-gray-800 truncate">{{ $category->name }}</h3>
                <p class="text-2xl font-black text-gray-900">{{ $category->products_count }} <span class="text-sm font-medium text-gray-500">Barang</span></p>
                <p class="text-[9px] uppercase tracking-widest text-gray-400 mt-3 pt-3 border-t border-gray-100">
                    Diperbarui {{ $category->updated_at->diffForHumans() }}
                </p>
            </div>
            @endforeach
        </div>

        {{ $categories->links() }}

        <div x-show="createModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <form action="{{ route('categories.store') }}" method="POST" x-show="createModal" x-transition class="bg-white/90 p-8 rounded-[32px] w-96 shadow-2xl border border-white/50">
                @csrf
                <h3 class="text-xl font-bold mb-6 text-gray-800">Tambah Kategori</h3>
                <input type="text" name="name" class="w-full p-3 rounded-2xl border border-gray-200 mb-6" required placeholder="Nama Kategori Baru">
                <div class="flex gap-2">
                    <button type="button" @click="createModal = false" class="flex-1 p-3 bg-gray-200 rounded-2xl font-bold">Batal</button>
                    <button type="submit" class="flex-1 p-3 bg-red-600 text-white rounded-2xl font-bold">Simpan</button>
                </div>
            </form>
        </div>

        <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <form id="editForm" method="POST" x-show="editModal" x-transition class="bg-white/90 p-8 rounded-[32px] w-96 shadow-2xl border border-white/50">
                @csrf @method('PUT')
                <h3 class="text-xl font-bold mb-6 text-gray-800">Edit Kategori</h3>
                <label class="block text-sm text-gray-500 mb-2">Nama Saat Ini</label>
                <input type="text" id="editName" readonly class="w-full p-3 rounded-2xl bg-gray-100 text-gray-500 mb-4 cursor-not-allowed">
                <label class="block text-sm text-gray-500 mb-2">Nama Baru</label>
                <input type="text" name="name" class="w-full p-3 rounded-2xl border border-gray-200 mb-6" required placeholder="Masukkan nama baru">
                <div class="flex gap-2">
                    <button type="button" @click="editModal = false" class="flex-1 p-3 bg-gray-200 rounded-2xl font-bold">Batal</button>
                    <button type="submit" class="flex-1 p-3 bg-red-600 text-white rounded-2xl font-bold">Simpan</button>
                </div>
            </form>
        </div>

        <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div x-show="deleteModal" x-transition class="bg-white/90 p-8 rounded-[32px] w-96 shadow-2xl border border-white/50 text-center">
                <h3 class="text-xl font-bold mb-4">Konfirmasi Hapus</h3>
                <p class="text-gray-500 mb-6">Yakin ingin menghapus kategori ini?</p>
                <form :action="deleteUrl" method="POST" class="flex gap-2">
                    @csrf @method('DELETE')
                    <button type="button" @click="deleteModal = false" class="flex-1 p-3 bg-gray-200 rounded-2xl font-bold">Batal</button>
                    <button type="submit" class="flex-1 p-3 bg-red-600 text-white rounded-2xl font-bold">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>
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
