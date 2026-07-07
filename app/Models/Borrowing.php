<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Borrowing extends Model
{
    // Gunakan $fillable lebih disarankan daripada $guarded agar lebih aman
    protected $fillable = [
        'user_id',
        'borrower_name',
        'nama_barang',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'notes',
        'image_path',
    ];

    protected $appends = ['display_product_name'];

    // 1. Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // 2. Relasi ke Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // 3. Relasi ke BorrowingDetail
    public function details(): HasMany
    {
        return $this->hasMany(BorrowingDetail::class, 'borrowing_id');
    }

    public function getBorrowerNameAttribute($value)
    {
        return $this->attributes['borrower_name'] ?? $value;
    }

public function getDisplayProductNameAttribute(): string
{
    // 1. Prioritaskan kolom nama_barang di tabel borrowings
    if (!empty($this->nama_barang)) {
        return $this->nama_barang;
    }

    // 2. Jika kosong, baru cek relasi ke details
    $productNames = $this->details()->with('product')->get()
        ->map(fn ($detail) => $detail->product?->nama_barang ?? 'Barang Dihapus')
        ->filter()
        ->values();

    return $productNames->isNotEmpty() ? $productNames->join(', ') : 'Barang Dihapus';
}
}