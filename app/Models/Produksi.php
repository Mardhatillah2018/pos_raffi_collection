<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_cabang',
        'tanggal_produksi',
        'total_biaya',
        'created_by',
        'keterangan',
    ];
    public function detailProduksis()
    {
        return $this->hasMany(DetailProduksi::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    } 


}
