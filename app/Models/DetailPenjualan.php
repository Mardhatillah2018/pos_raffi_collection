<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        'penjualan_id',
        'detail_produk_id',
        'qty',
        'harga_satuan',
        'subtotal',
    ];
    public function detailProduk()
    {
        return $this->belongsTo(DetailProduk::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
