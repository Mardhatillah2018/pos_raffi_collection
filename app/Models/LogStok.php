<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStok extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'detail_produk_id',
        'kode_cabang',
        'qty',
        'jenis',
        'created_by',
        'status',
        'sumber',
        'keterangan',
    ];

    public function detailProduk()
    {
        return $this->belongsTo(DetailProduk::class);
    }

}
