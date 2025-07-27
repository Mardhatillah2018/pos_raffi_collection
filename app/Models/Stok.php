<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $fillable = [
        'detail_produk_id',
        'kode_cabang',
        'stok',
    ];

    public function detailProduk()
    {
        return $this->belongsTo(DetailProduk::class);
    }   
}
