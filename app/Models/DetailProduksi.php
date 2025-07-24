<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduksi extends Model
{
    use HasFactory;

    protected $table = 'detail_produksis';

    protected $fillable = [
        'produksi_id',
        'detail_produk_id',
        'qty',
    ];

    public function produksi()
    {
        return $this->belongsTo(Produksi::class);
    }
    public function detailProduk()
    {
        return $this->belongsTo(DetailProduk::class);
    }
}
