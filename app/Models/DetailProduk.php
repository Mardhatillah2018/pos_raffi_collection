<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduk extends Model
{
    use HasFactory;
    protected $fillable = [
        'produk_id',
        'ukuran_id',
        'harga_modal',
        'harga_jual',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    public function ukuran()
    {
        return $this->belongsTo(UkuranProduk::class, 'ukuran_id');
    }

    public function detailProduksis()
    {
        return $this->hasMany(DetailProduksi::class);
    }


}
