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
        Schema::create('log_stoks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('detail_produk_id');
            $table->string('kode_cabang', 10);
            $table->integer('qty');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->unsignedBigInteger('created_by');
            $table->enum('status', ['disetujui', 'ditolak']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_stoks');
    }
};
