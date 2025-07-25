<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailProduk extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'produk_id',
        'ukuran_id',
        'harga_modal',
        'harga_jual',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id')->withTrashed(); // ← tambahkan ini
    }

    public function ukuran()
    {
        return $this->belongsTo(UkuranProduk::class, 'ukuran_id')->withTrashed(); // opsional kalau ukuran juga bisa soft delete
    }

    public function detailProduksis()
    {
        return $this->hasMany(DetailProduksi::class);
    }

}
