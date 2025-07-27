<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $fillable = [
        'pembelian_id',
        'detail_produk_id',
        'qty',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
    public function detailProduk()
    {
        return $this->belongsTo(DetailProduk::class)->withTrashed();
    }
}
