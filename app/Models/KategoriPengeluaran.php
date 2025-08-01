<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPengeluaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kategori',
        'is_modal_produk',
    ];
}
