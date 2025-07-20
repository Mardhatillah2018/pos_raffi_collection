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
        Schema::create('detail_produks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('produk_id');
            $table->unsignedInteger('ukuran_id');

            $table->decimal('harga_modal', 12, 2);
            $table->decimal('harga_jual', 12, 2);

            $table->timestamps();

            // Untuk memastikan 1 ukuran hanya bisa sekali per produk
            $table->unique(['produk_id', 'ukuran_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_produks');
    }
};
