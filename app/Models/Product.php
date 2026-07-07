<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    public function getNameAttribute($value)
    {
        return $this->attributes['nama_barang'] ?? $value;
    }

    public function getStockAttribute($value)
    {
        return $this->attributes['stok'] ?? $value;
    }

    public function getConditionAttribute($value)
    {
        return $this->attributes['kondisi_barang'] ?? $value;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}