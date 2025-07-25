<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama_produk',
    ];

    public function detailProduks()
    {
        return $this->hasMany(DetailProduk::class, 'produk_id');
    }

}
