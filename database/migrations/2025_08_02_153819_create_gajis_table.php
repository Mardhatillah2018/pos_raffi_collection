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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cabang', 10);
            $table->unsignedBigInteger('karyawan_id');
            $table->date('periode');
            $table->enum('jenis_gaji', ['mingguan', 'bulanan']);
            $table->date('tanggal_dibayar')->nullable();
            $table->decimal('gaji_pokok', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('jumlah_dibayar', 12, 2)->default(0);
            $table->enum('status', ['pending', 'dibayar'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
