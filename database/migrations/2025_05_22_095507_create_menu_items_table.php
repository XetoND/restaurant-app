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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            // --- Tambahkan kolom 'name' di sini ---
            $table->string('name')->unique(); // Nama menu, harus unik
            // ------------------------------------
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('image')->nullable(); // optional image path
            $table->boolean('available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};