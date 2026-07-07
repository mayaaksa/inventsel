<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('borrowings', function (Blueprint $table) {
        // Cek dulu apakah kolomnya sudah ada, jika belum baru tambahkan
        if (!Schema::hasColumn('borrowings', 'notes')) {
            $table->text('notes')->nullable();
        }
    });
}

public function down()
{
    Schema::table('borrowings', function (Blueprint $table) {
        $table->dropColumn('notes');
    });
}

};
