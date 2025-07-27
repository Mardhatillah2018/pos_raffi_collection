<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_cabang',
        'tanggal_pembelian',
        'total_biaya',
        'created_by',
        'keterangan',
    ];

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'kode_cabang', 'kode_cabang');
    }
}
