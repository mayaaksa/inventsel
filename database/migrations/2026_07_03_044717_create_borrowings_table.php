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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Nama Peminjam [cite: 68]
            $table->date('tanggal_pinjam'); // [cite: 70]
            $table->date('tanggal_kembali')->nullable(); // [cite: 71]
            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Dipinjam'); // [cite: 72]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
