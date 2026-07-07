<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique(); // [cite: 54]
            $table->string('nama_barang'); // [cite: 56]
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Kategori [cite: 57]
            $table->integer('stok'); // [cite: 58]
            $table->string('lokasi_penyimpanan'); // [cite: 59]
            $table->enum('kondisi_barang', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik'); // [cite: 60]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
