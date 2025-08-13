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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($produk) {
            if ($produk->isForceDeleting()) {
                // Force delete detail juga
                $produk->detailProduks()->forceDelete();
            } else {
                // Soft delete detail
                $produk->detailProduks()->delete();
            }
        });
    }
}
