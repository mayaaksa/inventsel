<x-app-layout>
    @if(session('success') || session('error'))
        <div class="mb-8 rounded-[32px] border p-6 text-center font-bold text-white shadow-sm backdrop-blur-md {{ session('success') ? 'border-green-400 bg-green-500/90' : 'border-red-400 bg-red-500/90' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <div class="space-y-6" x-data="{
        selectedBorrowing: null,
        imagePreview: null,
        createModal: false,
        editModal: false,
        deleteModal: false,
        deleteUrl: '',
        editBorrowing: null,
        sortOpen: false,
        openEdit(borrowing) {
            this.editBorrowing = { ...borrowing };
            this.editModal = true;
        },
        openDelete(id) {
            this.deleteUrl = '/borrowings/' + id;
            this.deleteModal = true;
        }
    }">
        <div class="bg-gradient-to-r from-[#8E001B] to-[#551224] p-8 rounded-[32px] text-white shadow-xl">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="text-3xl font-black">Manajemen Peminjaman</h2>
                    <p class="text-red-100/70 mt-1">Pantau seluruh proses peminjaman secara real-time, mulai dari aktif hingga riwayat.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
            @php 
                $cards = [
                    ['title' => 'Aktif', 'val' => $stats['dipinjam'], 'color' => 'red', 'icon' => 'package'],
                    ['title' => 'Terlambat', 'val' => $stats['terlambat'], 'color' => 'orange', 'icon' => 'alert-triangle'],
                    ['title' => 'Dikembalikan', 'val' => $stats['dikembalikan'], 'color' => 'green', 'icon' => 'check-circle'],
                    ['title' => 'Bulan Ini', 'val' => $stats['bulan_ini'], 'color' => 'purple', 'icon' => 'calendar']
                ];
            @endphp
            @foreach($cards as $c)
            <div class="relative overflow-hidden rounded-[32px]
    bg-white/55
    backdrop-blur-xl
    border border-white/40
    shadow-[0_10px_40px_rgba(255,255,255,0.15),0_10px_30px_rgba(0,0,0,0.08)]
    p-6">
                <p class="text-gray-500 text-xs font-bold">{{ $c['title'] }}</p>
                <h3 class="text-3xl font-black mt-2">{{ $c['val'] }}</h3>
                <div class="absolute right-4 top-4 p-3 bg-{{$c['color']}}-100 rounded-2xl text-{{$c['color']}}-600">
                    <i data-lucide="{{ $c['icon'] }}" class="w-6 h-6"></i>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex flex-col gap-6 xl:flex-row xl:items-start">
            <div class="flex-1 space-y-4">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('borrowings.index', ['view' => 'active', 'search' => $search, 'sort' => $sort]) }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ $view === 'active' ? 'bg-[#8E001B] text-white shadow' : 'border border-white/30 bg-white/45 text-red-700 hover:bg-white/45' }}">
                                Peminjaman Aktif
                            </a>
                            <a href="{{ route('borrowings.index', ['view' => 'history', 'search' => $search, 'sort' => $sort]) }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ $view === 'history' ? 'bg-[#8E001B] text-white shadow' : 'border border-white/30 bg-white/45 text-red-700 hover:bg-white/45' }}">
                                Riwayat
                            </a>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <button @click="createModal = true" class="flex items-center gap-2 px-6 py-3 bg-[#8E001B] text-white rounded-2xl shadow-sm hover:bg-[#6e0015] font-bold text-sm transition-all">
                                <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                                Tambah Peminjaman
                            </button>

                            <form method="GET" action="{{ route('borrowings.index') }}" class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                <input type="hidden" name="view" value="{{ $view }}">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari peminjam atau barang..." class="w-full rounded-2xl border border-gray-200 bg-white/45 py-3 pl-10 pr-10 text-sm text-gray-700 focus:border-red-500 focus:ring-2 focus:ring-red-200 sm:w-72">
                                    <i data-lucide="search" class="absolute left-3 top-3.5 h-4 w-4 text-gray-400"></i>
                                    @if($search)
                                        <a href="{{ route('borrowings.index', ['view' => $view, 'sort' => $sort]) }}" class="absolute right-3 top-3.5 text-gray-400 hover:text-red-600">
                                            <i data-lucide="x" class="h-4 w-4"></i>
                                        </a>
                                    @endif
                                </div>
                                <div class="relative">
                                    <button type="button" @click="sortOpen = !sortOpen" class="flex items-center justify-center gap-2 rounded-2xl border border-gray-20 bg-white/45 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-white/45">
                                        <i data-lucide="filter" class="h-4 w-4"></i> Urutkan
                                    </button>
                                    <div x-show="sortOpen" @click.away="sortOpen = false" x-cloak class="absolute right-0 z-50 mt-2 w-40 rounded-2xl border border-gray-100 bg-white p-2 shadow-xl">
                                        <a href="{{ route('borrowings.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" class="block rounded-xl px-4 py-2 text-sm font-bold text-gray-700 hover:bg-red-50">Terbaru</a>
                                        <a href="{{ route('borrowings.index', array_merge(request()->query(), ['sort' => 'oldest'])) }}" class="block rounded-xl px-4 py-2 text-sm font-bold text-gray-700 hover:bg-red-50">Terlama</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                <div class="rounded-[32px]
    bg-white/45
    backdrop-blur-xl
    border border-white/40
    shadow-[0_12px_35px_rgba(0,0,0,0.08)]
    p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="pb-5 px-2">No</th>
                            <th class="pb-5">Peminjam</th>
                            <th class="pb-5">Nama Barang</th>
                            <th class="pb-5">Tgl Pinjam</th>
                            <th class="pb-5">Status</th>
                            <th class="pb-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-medium text-gray-800">
                        @forelse($borrowings as $index => $b)
                        <tr class="border-b border-gray-50 hover:bg-white/50 transition cursor-pointer" 
                            @click="selectedBorrowing = { 
                                id: {{ $b->id }}, 
                                borrower_name: '{{ addslashes($b->borrower_name ?? ($b->user->name ?? '-')) }}', 
                                product_name: '{{ addslashes($b->display_product_name) }}', 
                                status: '{{ $b->status }}', 
                                tanggal_pinjam: '{{ $b->tanggal_pinjam ?? '-' }}',
                                notes: '{{ addslashes($b->notes ?? 'Tidak ada catatan') }}', 
                                image_path: '{{ addslashes($b->image_path ?? '') }}' 
                            }">
                            <td class="py-5 px-2 text-gray-500">{{ $borrowings->firstItem() + $index }}</td>
                            <td class="py-5 font-bold">{{ $b->borrower_name ?? ($b->user->name ?? '-') }}</td>
                            <td class="py-5">{{ $b->display_product_name }}</td>
                            <td class="py-5">{{ $b->tanggal_pinjam ?? '-' }}</td>
                            <td class="py-5">
                                @php
                                    $statusClass = match ($b->status) {
                                        'Terlambat' => 'bg-amber-100 text-amber-700',
                                        'Dikembalikan' => 'bg-green-100 text-green-700',
                                        default => 'bg-blue-100 text-blue-700',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-lg text-[10px] {{ $statusClass }}">
                                    {{ $b->status }}
                                </span>
                            </td>
                            <td class="py-5 text-center">
                                <button type="button" @click.stop="selectedBorrowing = { 
                                    id: {{ $b->id }}, 
                                    borrower_name: '{{ addslashes($b->borrower_name ?? ($b->user->name ?? '-')) }}', 
                                    product_name: '{{ addslashes($b->display_product_name) }}', 
                                    status: '{{ $b->status }}', 
                                    tanggal_pinjam: '{{ $b->tanggal_pinjam ?? '-' }}',
                                    notes: '{{ addslashes($b->notes ?? 'Tidak ada catatan') }}', 
                                    image_path: '{{ addslashes($b->image_path ?? '') }}' 
                                }" class="rounded-lg bg-red-50 px-3 py-1 text-xs font-bold text-red-700 hover:bg-red-100">Detail</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-500">Tidak ada data peminjaman pada kategori ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $borrowings->links() }}
                </div>
                </div>
            </div>

            <div x-show="selectedBorrowing !== null" x-cloak class="w-full xl:max-w-[360px] bg-white p-6 rounded-[32px] shadow-2xl border border-gray-100 sticky top-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-red-500">Detail Peminjaman</p>
                    </div>
                    <button @click="selectedBorrowing = null" class="rounded-full bg-gray-100 p-2 text-gray-500 hover:text-red-500">✕</button>
                </div>
                
                <div class="mb-6">
                    <p class="text-[10px] uppercase text-gray-400 font-bold mb-2">Foto Bukti</p>
                    
                    <template x-if="selectedBorrowing?.image_path && selectedBorrowing.image_path !== ''">
                        <img :src="'/storage/' + selectedBorrowing.image_path" 
                             class="w-full h-40 object-cover rounded-2xl border border-gray-200"
                             alt="Foto Bukti">
                    </template>

                    <template x-if="!selectedBorrowing?.image_path || selectedBorrowing.image_path === ''">
                        <div class="w-full h-40 flex items-center justify-center bg-gray-50 rounded-2xl border border-dashed border-gray-300 text-gray-400 text-xs">
                            Tidak ada foto
                        </div>
                    </template>
                </div>
                <form method="POST" action="{{ route('borrowings.upload-image') }}" enctype="multipart/form-data" class="rounded-[24px] border border-dashed border-red-200 bg-red-50/70 p-4 text-center text-sm text-gray-600 mb-6">
                    @csrf
                    <input type="hidden" name="borrowing_id" x-bind:value="selectedBorrowing?.id">
                    <p class="font-semibold text-gray-800">Foto / Bukti Peminjaman</p>
                    <p class="mt-1 text-xs text-gray-500">Tambahkan gambar untuk dokumentasi detail barang.</p>
                    <label class="mt-4 inline-flex cursor-pointer items-center justify-center rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-100">
                        <i data-lucide="image-plus" class="mr-2 h-4 w-4"></i>
                        Upload Gambar
                        <input type="file" name="image" class="hidden" @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                    </label>
                    <button type="submit" class="mt-3 w-full rounded-2xl bg-red-700 px-4 py-2 text-sm font-semibold text-white hover:bg-red-800">Simpan Foto</button>
                    <template x-if="imagePreview">
                        <img :src="imagePreview" alt="Preview upload" class="mt-4 h-32 w-full rounded-2xl object-cover">
                    </template>
                </form>

                <div class="mt-6 space-y-5 text-sm">
                    <div>
                        <p class="text-[10px] uppercase text-gray-400 font-bold">Nama Peminjam</p>
                        <p class="font-bold text-gray-900" x-text="selectedBorrowing?.borrower_name"></p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase text-gray-400 font-bold">Barang Dipinjam</p>
                        <p class="font-bold text-gray-900" x-text="selectedBorrowing?.product_name"></p>
                        <div>
                        <p class="text-[10px] uppercase text-gray-400 font-bold">Tanggal Pinjam</p>
                        <p class="font-bold text-gray-900" x-text="selectedBorrowing?.tanggal_pinjam"></p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase text-gray-400 font-bold">Status</p>
                        <p class="font-bold text-red-600" x-text="selectedBorrowing?.status"></p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase text-gray-400 font-bold">Catatan</p>
                        <p class="text-gray-600 italic" x-text="selectedBorrowing?.notes"></p>
                    </div>
                </div>
                
                <div class="mt-8 flex gap-2 border-t border-gray-100 pt-6">
                    <button type="button" @click="openEdit(selectedBorrowing)" class="flex-1 rounded-2xl bg-blue-50 py-3 text-xs font-bold text-blue-700">Edit</button>
                    <button type="button" @click="openDelete(selectedBorrowing?.id)" class="flex-1 rounded-2xl bg-red-700 py-3 text-xs font-bold text-white">Hapus</button>
                </div>
            </div>
        </div>

        <div x-show="createModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <form action="{{ route('borrowings.store') }}" method="POST" class="w-[32rem] rounded-[32px] bg-white p-8 shadow-2xl">
                @csrf
                <h3 class="mb-6 text-xl font-bold text-gray-800">Tambah Peminjaman</h3>
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <div class="mb-3">
                    <label class="mb-1 block text-sm font-semibold text-gray-600">Nama Peminjam</label>
                    <input type="text" name="borrower_name" value="{{ old('borrower_name', auth()->user()->name) }}" class="w-full rounded-2xl border border-gray-200 p-3" required>
                </div>
<div class="mb-3">
    <label class="block text-sm font-semibold text-gray-600">Nama Barang</label>
    <select name="nama_barang" class="w-full rounded-2xl border border-gray-200 p-3" required>
        <option value="">-- Pilih Barang --</option>
        @foreach(\App\Models\Product::all() as $product)
            <option value="{{ $product->nama_barang }}">{{ $product->nama_barang }}</option>
        @endforeach
    </select>
</div>
                <div class="mb-3">
                    <label class="mb-1 block text-sm font-semibold text-gray-600">Tanggal Dipinjam</label>
                    <input type="date" name="tanggal_pinjam" value="{{ now()->toDateString() }}" class="w-full rounded-2xl border border-gray-200 p-3" required>
                </div>
                <div class="mb-3">
                    <label class="mb-1 block text-sm font-semibold text-gray-600">Status</label>
                    <select name="status" class="w-full rounded-2xl border border-gray-200 p-3" required>
                        <option value="Dipinjam">Dipinjam</option>
                        <option value="Terlambat">Terlambat</option>
                        <option value="Dikembalikan">Dikembalikan</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="button" @click="createModal = false" class="flex-1 rounded-2xl bg-gray-100 py-3 font-bold">Batal</button>
                    <button type="submit" class="flex-1 rounded-2xl bg-red-700 py-3 font-bold text-white">Simpan</button>
                </div>
            </form>
        </div>

<div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <form :action="'/borrowings/' + editBorrowing?.id" method="POST" class="w-[32rem] rounded-[32px] bg-white p-8 shadow-2xl">
        @csrf @method('PUT')
        <h3 class="mb-6 text-xl font-bold text-gray-800">Edit Peminjaman</h3>
        
        <div class="mb-3">
            <label class="block text-sm font-semibold text-gray-600">Nama Peminjam</label>
            <input type="text" name="borrower_name" :value="editBorrowing?.borrower_name" class="w-full rounded-2xl border border-gray-200 p-3" required>
        </div>

<div class="mb-3">
    <label class="block text-sm font-semibold text-gray-600">Nama Barang</label>
    <select name="nama_barang" class="w-full rounded-2xl border border-gray-200 p-3" required>
        <option value="">-- Pilih Barang --</option>
        @foreach(\App\Models\Product::all() as $product)
            <option value="{{ $product->nama_barang }}">{{ $product->nama_barang }}</option>
        @endforeach
    </select>
</div>

        <div class="mb-3">
            <label class="block text-sm font-semibold text-gray-600">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" :value="editBorrowing?.tanggal_pinjam" class="w-full rounded-2xl border border-gray-200 p-3" required>
        </div>

        <div class="mb-3">
            <label class="block text-sm font-semibold text-gray-600">Catatan</label>
            <textarea name="notes" rows="3" :value="editBorrowing?.notes" class="w-full rounded-2xl border border-gray-200 p-3"></textarea>
        </div>

        <div class="mb-3">
            <label class="block text-sm font-semibold text-gray-600">Status</label>
            <select name="status" class="w-full rounded-2xl border border-gray-200 p-3" required>
                <option value="Dipinjam" :selected="editBorrowing?.status === 'Dipinjam'">Dipinjam</option>
                <option value="Terlambat" :selected="editBorrowing?.status === 'Terlambat'">Terlambat</option>
                <option value="Dikembalikan" :selected="editBorrowing?.status === 'Dikembalikan'">Dikembalikan</option>
            </select>
        </div>

        <div class="flex gap-2 mt-6">
            <button type="button" @click="editModal = false" class="flex-1 rounded-2xl bg-gray-100 py-3 font-bold hover:bg-gray-200">Batal</button>
            <button type="submit" class="flex-1 rounded-2xl bg-red-700 py-3 font-bold text-white hover:bg-red-800">Update Data</button>
        </div>
    </form>
</div>

<div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="w-96 rounded-[32px] bg-white p-8 text-center shadow-2xl">
        <h3 class="mb-4 text-xl font-bold">Hapus Peminjaman?</h3>
        <p class="text-sm text-gray-500 mb-6">Data yang dihapus tidak bisa dikembalikan.</p>
        <form :action="deleteUrl" method="POST">
            @csrf @method('DELETE')
            <div class="flex gap-2">
                <button type="button" @click="deleteModal = false" class="flex-1 rounded-2xl bg-gray-100 py-3 font-bold">Batal</button>
                <button type="submit" class="flex-1 rounded-2xl bg-red-700 py-3 font-bold text-white">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>
    </div>
</x-app-layout>