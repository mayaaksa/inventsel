<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Models\Borrowing;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->query('view', 'active');
        $search = trim((string) $request->query('search', ''));
        $sort = $request->query('sort', 'newest');

        $query = Borrowing::with(['user', 'details.product'])
            ->when($view === 'active', function ($query) {
                $query->whereIn('status', ['Dipinjam', 'Terlambat']);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(function ($nameQuery) use ($search) {
                        $nameQuery->where('borrower_name', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($userQuery) use ($search) {
                                $userQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%" );
                            });
                    })->orWhereHas('details.product', function ($productQuery) use ($search) {
                        $productQuery->where('nama_barang', 'like', "%{$search}%")
                            ->orWhere('kode_barang', 'like', "%{$search}%" );
                    })->orWhere('status', 'like', "%{$search}%")
                      ->orWhere('tanggal_pinjam', 'like', "%{$search}%" );
                });
            })
            ->when($sort === 'oldest', function ($query) {
                $query->orderBy('tanggal_pinjam', 'asc');
            }, function ($query) {
                $query->latest();
            });

        $activeBorrowings = (clone $query)
            ->whereIn('status', ['Dipinjam', 'Terlambat'])
            ->paginate(10)
            ->appends(['view' => 'active', 'search' => $search, 'sort' => $sort]);

        $historyBorrowings = (clone $query)
            ->paginate(10)
            ->appends(['view' => 'history', 'search' => $search, 'sort' => $sort]);

        $borrowings = $view === 'history' ? $historyBorrowings : $activeBorrowings;

        $sedangDipinjam = Borrowing::where('status', 'Dipinjam')->count();
        $menunggu = Borrowing::where('status', 'Menunggu')->count();

        $stats = [
            'dipinjam' => (clone $query)->whereIn('status', ['Dipinjam', 'Terlambat'])->count(),
            'terlambat' => (clone $query)->where('status', 'Terlambat')->count(),
            'dikembalikan' => (clone $query)->where('status', 'Dikembalikan')->count(),
            'bulan_ini' => (clone $query)->whereYear('tanggal_pinjam', now()->year)
                ->whereMonth('tanggal_pinjam', now()->month)
                ->count(),
        ];

        return view('borrowings.index', compact('borrowings', 'activeBorrowings', 'historyBorrowings', 'stats', 'sedangDipinjam', 'menunggu', 'view', 'search', 'sort'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => 'sometimes|exists:users,id',
                'borrower_name' => 'nullable|string|max:255',
                'nama_barang' => 'required|string|max:255',
                'tanggal_pinjam' => 'required|date',
                'tanggal_kembali' => 'nullable|date',
                'status' => 'required|in:Dipinjam,Dikembalikan,Terlambat',
                'notes' => 'nullable|string',
            ]);

            $data['borrower_name'] = $data['borrower_name'] ?? $request->input('borrower_name') ?? auth()->user()->name;
            $data['user_id'] = $request->input('user_id', auth()->id());

$borrowing = Borrowing::create($data);

if ($request->has('product_id')) {
    $borrowing->details()->create(['product_id' => $request->product_id]);
}

            return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan.');
        } catch (ValidationException $e) {

    dd($e->errors()); 
            return back()->withInput()->with('error', 'Data peminjaman tidak valid.');
        }
    }
public function show($id)
{
    $borrowing = Borrowing::findOrFail($id); 

    // Pastikan 'compact' atau array yang dikirim kunci-nya adalah 'borrowing'
    return view('borrowings.show', compact('borrowing'));
}
    public function update(Request $request, Borrowing $borrowing)
    {
        try {
            $data = $request->validate([
                'user_id' => 'sometimes|exists:users,id',
                'borrower_name' => 'nullable|string|max:255',
                'tanggal_pinjam' => 'required|date',
                'tanggal_kembali' => 'nullable|date',
                'status' => 'required|in:Dipinjam,Dikembalikan,Terlambat',
                'notes' => 'nullable|string',
            ]);

            $data['borrower_name'] = $data['borrower_name'] ?? $request->input('borrower_name') ?? $borrowing->borrower_name ?? auth()->user()->name;
            $data['user_id'] = $request->input('user_id', auth()->id());

            $borrowing->update($data);

            return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withInput()->with('error', 'Data peminjaman tidak valid.');
        }
    }

    public function destroy(Borrowing $borrowing)
    {
        try {
            if ($borrowing->image_path) {
                Storage::disk('public')->delete($borrowing->image_path);
            }

            $borrowing->delete();

            return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus peminjaman.');
        }
    }

public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'borrowing_id' => 'required|exists:borrowings,id'
            ]);

            // 1. Ambil data peminjaman
            $borrowing = Borrowing::findOrFail($request->borrowing_id);

            // 2. Simpan foto
if ($request->hasFile('image')) {
    $path = $request->file('image')->store('borrowings', 'public');
    
    // Sesuaikan kuncinya menjadi image_path
    $borrowing->update(['image_path' => $path]); 
}

            return back()->with('success', 'Foto peminjaman berhasil diunggah.');

        } catch (ValidationException $e) {
            return back()->with('error', 'File gambar tidak valid.');
} catch (\Throwable $e) {
            // Hapus atau beri komentar pada return back()
            // dd($e->getMessage()); // AKTIFKAN INI untuk melihat error aslinya
            return back()->with('error', 'Gagal: ' . $e->getMessage()); 
        }
    }
}
