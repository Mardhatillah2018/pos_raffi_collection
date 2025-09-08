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
        Schema::create('kas_harians', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cabang', 10);
            $table->date('tanggal');
            $table->decimal('saldo_awal', 12, 2)->default(0);
            $table->decimal('total_penjualan', 12, 2)->default(0);
            $table->decimal('setor', 12, 2)->default(0);
            $table->decimal('saldo_akhir', 12, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('created_by'); 
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_harians');
    }
};
