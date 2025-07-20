<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_produk',
    ];

    public function detailProduks()
    {
        return $this->hasMany(DetailProduk::class, 'produk_id');
    }

}
