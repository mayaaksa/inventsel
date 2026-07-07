<x-app-layout>
    @if(session('success') || session('error'))
        <div class="p-6 rounded-[32px] mb-8 shadow-sm border backdrop-blur-md text-white font-bold text-center 
            {{ session('success') ? 'bg-green-500/90 border-green-400' : 'bg-red-500/90 border-red-400' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <div class="space-y-6" x-data="{ 
        createModal: false,
        editModal: false,
        deleteModal: false,
        selectedProduct: null,
        editProduct: null,
        deleteUrl: '',
        sortOpen: false,
        openEdit(product) {
            // close other modals first to avoid overlap
            this.deleteModal = false;
            this.createModal = false;
            this.selectedProduct = null;
            this.editProduct = { ...product };
            this.editModal = true;
        },
        openDelete(id) {
            // ensure edit/create are closed before showing delete confirmation
            this.editModal = false;
            this.createModal = false;
            this.selectedProduct = null;
            this.deleteUrl = '/products/' + id;
            this.deleteModal = true;
        }
    }">

        <div class="flex items-stretch gap-6 h-[140px]">
            <div class="flex-1 bg-gradient-to-r from-[#8E001B] to-[#551224] p-10 rounded-[32px] shadow-xl text-white flex flex-col justify-center">
                <h2 class="text-3xl font-black tracking-tight">Master Data Barang</h2>
                <p class="text-red-100/70 text-sm mt-1">Kelola inventaris perusahaan Anda.</p>
            </div>
                <div class="grid grid-cols-3 gap-4 w-[600px]">
                <div class="bg-white/70 backdrop-blur-md p-4 rounded-[32px] border border-white/50 shadow-sm text-center flex flex-col justify-center">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Total Stok</p>
                    <h3 class="text-5xl font-black text-gray-800">{{ $totalStock }}</h3>
                </div>
                <div class="bg-white/70 backdrop-blur-md p-4 rounded-[32px] border border-white/50 shadow-sm text-center flex flex-col justify-center">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Stok Menipis</p>
                    <h3 class="text-5xl font-black text-orange-600">{{ $lowStockCount }}</h3>
                </div>
                <div class="bg-white/70 backdrop-blur-md p-4 rounded-[32px] border border-white/50 shadow-sm text-center flex flex-col justify-center">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Total Barang</p>
                    <h3 class="text-5xl font-black text-gray-800">{{ $totalItems }}</h3>
                </div>
            </div>
        </div>

<div class="flex justify-between items-center gap-4">
    <button @click="createModal = true" class="px-6 py-3 bg-[#8E001B] text-white rounded-2xl font-bold hover:bg-[#6e0015] shadow-lg transition">+ Tambah Barang</button>
    
    <div class="flex gap-3 flex-1 justify-end">
        <form action="{{ route('products.index') }}" method="GET" class="relative">
            <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}" 
                   class="pl-10 pr-10 py-3 rounded-2xl border border-gray-200 bg-white/50 w-64 text-sm focus:ring-2 focus:ring-red-500">
            <i data-lucide="search" class="w-4 h-4 absolute left-4 top-4 text-gray-400"></i>
            
            @if(request('search'))
                <a href="{{ route('products.index') }}" class="absolute right-4 top-4 text-gray-400 hover:text-red-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </a>
            @endif
        </form>

        <div class="relative">
            <button @click="sortOpen = !sortOpen" class="px-6 py-3 bg-white/50 rounded-2xl border border-gray-200 font-bold text-sm flex items-center gap-2 hover:bg-gray-50">
                <i data-lucide="filter" class="w-4 h-4"></i> Urutkan
            </button>
            <div x-show="sortOpen" @click.away="sortOpen = false" x-cloak 
                 class="absolute right-0 mt-2 bg-white rounded-2xl shadow-xl w-40 p-2 z-50 border border-gray-100">
                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" 
                   class="block px-4 py-2 hover:bg-red-50 rounded-xl text-sm font-bold text-gray-700">Terbaru</a>
                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'oldest'])) }}" 
                   class="block px-4 py-2 hover:bg-red-50 rounded-xl text-sm font-bold text-gray-700">Terlama</a>
            </div>
        </div>
    </div>
</div>

        <div class="flex gap-6 items-start">
            <div class="flex-1 bg-white/70 backdrop-blur-md p-8 rounded-[32px] border border-white/50 shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-600 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="pb-5 px-2">No</th>
                            <th class="pb-5">Nama Barang</th>
                            <th class="pb-5">Kategori</th>
                            <th class="pb-5">Stok</th>
                            <th class="pb-5">Kondisi</th>
                            <th class="pb-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-medium text-gray-800">
                        @foreach($products as $index => $product)
                        <tr class="border-b border-gray-50 hover:bg-white/50 transition cursor-pointer" @click="selectedProduct = {{ json_encode($product) }}">
                            <td class="py-4 px-2 text-gray-500">{{ $products->firstItem() + $index }}</td>
                            <td class="py-4">{{ $product['name'] }}</td>
                            <td class="py-4">{{ $product['category_name'] }}</td>
                            <td class="py-4 font-bold">{{ $product['stok'] }}</td>
                            <td class="py-4">
                                <span class="px-2 py-1 rounded-lg text-[10px] {{ $product['condition'] == 'Baik' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">{{ $product['condition'] }}</span>
                            </td>
                            <td class="py-4 text-center">
                                <button class="text-red-700 font-bold text-xs bg-red-50 px-3 py-1 rounded-lg hover:bg-red-100">DETAIL</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6">{{ $products->links() }}</div>
            </div>

            <div x-show="selectedProduct !== null" x-cloak class="w-80 bg-white p-8 rounded-[32px] shadow-xl border border-gray-100 sticky top-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg">Detail Barang</h3>
                    <button @click="selectedProduct = null" class="text-gray-400 hover:text-red-500">✕</button>
                </div>
                <div class="space-y-5 text-sm">
                    <div><p class="text-[10px] uppercase text-gray-400 font-bold">Kode Barang</p><p class="font-bold text-gray-900" x-text="selectedProduct?.code"></p></div>
                    <div><p class="text-[10px] uppercase text-gray-400 font-bold">Nama Barang</p><p class="font-bold text-gray-900" x-text="selectedProduct?.name"></p></div>
                    <div><p class="text-[10px] uppercase text-gray-400 font-bold">Jumlah Stok</p><p class="font-bold text-gray-900" x-text="selectedProduct?.stok"></p></div>
                    <div><p class="text-[10px] uppercase text-gray-400 font-bold">Lokasi</p><p class="font-bold text-gray-900" x-text="selectedProduct?.location || '-'"> </p></div>
                    <div><p class="text-[10px] uppercase text-gray-400 font-bold">Kategori</p><p class="font-bold text-gray-900" x-text="selectedProduct?.category_name"></p></div>
                    <div><p class="text-[10px] uppercase text-gray-400 font-bold">Terakhir Diperbarui</p><p class="font-bold text-gray-900" x-text="selectedProduct?.updated_at"></p></div>
                </div>
                <div class="flex gap-2 mt-8 pt-6 border-t">
                    <button type="button" @click="openEdit(selectedProduct)" class="flex-1 py-2 bg-blue-50 text-blue-700 rounded-xl text-xs font-bold">Edit</button>
                    <button type="button" @click="openDelete(selectedProduct?.id)" class="flex-1 py-2 bg-red-700 text-white rounded-xl text-xs font-bold">Hapus</button>
                </div>
            </div>
        </div>

    <div x-show="createModal" x-cloak class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center">
        <form action="{{ route('products.store') }}" method="POST" class="bg-white p-8 rounded-[32px] w-[28rem] shadow-2xl">
            @csrf
            <h3 class="font-bold text-xl mb-6">Tambah Barang</h3>
            <input type="text" name="code" placeholder="Kode Barang" class="w-full mb-3 p-3 border rounded-2xl" required>
            <input type="text" name="name" placeholder="Nama Barang" class="w-full mb-3 p-3 border rounded-2xl" required>
            <select name="category_id" class="w-full mb-3 p-3 border rounded-2xl" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <input type="number" name="stok" placeholder="Stok" class="w-full mb-3 p-3 border rounded-2xl" required>
            <input type="text" name="location" placeholder="Lokasi Penyimpanan" class="w-full mb-3 p-3 border rounded-2xl" required>
            <select name="condition" class="w-full mb-6 p-3 border rounded-2xl" required>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>
            <div class="flex gap-2">
                <button type="button" @click="createModal = false" class="flex-1 py-3 bg-gray-100 rounded-2xl font-bold">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-red-700 text-white rounded-2xl font-bold">Simpan</button>
            </div>
        </form>
    </div>

    <div x-show="editModal" x-cloak class="fixed inset-0 bg-black/40 backdrop-blur-sm z-60 flex items-center justify-center">
        <form :action="'/products/' + editProduct?.id" method="POST" class="bg-white p-8 rounded-[32px] w-[28rem] shadow-2xl">
            @csrf
            @method('PUT')
            <h3 class="font-bold text-xl mb-6">Edit Barang</h3>
            <input type="text" name="code" :value="editProduct?.code || ''" placeholder="Kode Barang" class="w-full mb-3 p-3 border rounded-2xl" required>
            <input type="text" name="name" :value="editProduct?.name || ''" placeholder="Nama Barang" class="w-full mb-3 p-3 border rounded-2xl" required>
            <select name="category_id" class="w-full mb-3 p-3 border rounded-2xl" :value="editProduct?.category_id || ''" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <input type="number" name="stok" :value="editProduct?.stok || ''" placeholder="Stok" class="w-full mb-3 p-3 border rounded-2xl" required>
            <input type="text" name="location" :value="editProduct?.location || ''" placeholder="Lokasi Penyimpanan" class="w-full mb-3 p-3 border rounded-2xl" required>
            <select name="condition" class="w-full mb-6 p-3 border rounded-2xl" :value="editProduct?.condition || ''" required>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>
            <div class="flex gap-2">
                <button type="button" @click="editModal = false" class="flex-1 py-3 bg-gray-100 rounded-2xl font-bold">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-red-700 text-white rounded-2xl font-bold">Simpan</button>
            </div>
        </form>
    </div>

    <div x-show="deleteModal" x-cloak class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-[32px] w-96 shadow-2xl text-center">
            <h3 class="font-bold text-xl mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-500 mb-6">Yakin ingin menghapus barang ini?</p>
            <form :action="deleteUrl" method="POST" class="flex gap-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="deleteModal = false" class="flex-1 py-3 bg-gray-100 rounded-2xl font-bold">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-red-700 text-white rounded-2xl font-bold">Ya, Hapus</button>
            </form>
        </div>
    </div>
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