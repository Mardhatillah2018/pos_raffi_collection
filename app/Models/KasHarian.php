<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasHarian extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_cabang',
        'tanggal',
        'saldo_awal',
        'total_penjualan',
        'total_pengeluaran',
        'setor',
        'saldo_akhir',
        'status',
        'created_by',
        'keterangan'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'kode_cabang', 'kode_cabang');
    }
}
