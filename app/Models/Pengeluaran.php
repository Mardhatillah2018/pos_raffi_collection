<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'kode_cabang',
        'created_by',
        'kategori_id',
        'total_pengeluaran',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPengeluaran::class, 'kategori_id');
    }
}
