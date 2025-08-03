<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_cabang',
        'karyawan_id',
        'periode',
        'jenis_gaji',
        'tanggal_dibayar',
        'gaji_pokok',
        'bonus',
        'jumlah_dibayar',
        'status',
        'keterangan',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'kode_cabang', 'kode_cabang');
    }

    /**
     * Relasi ke karyawan.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
