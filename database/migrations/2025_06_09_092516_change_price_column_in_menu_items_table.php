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
        Schema::table('menu_items', function (Blueprint $table) {
            // Kita ubah kolom 'price' menjadi BIGINT agar bisa menampung angka besar
            // 'unsigned' berarti hanya angka positif
            $table->unsignedBigInteger('price')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            // Ini untuk mengembalikan ke kondisi semula jika migrasi di-rollback
            $table->decimal('price', 15, 2)->change();
        });
    }
};