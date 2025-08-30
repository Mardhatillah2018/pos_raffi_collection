<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'kode_cabang',
        'created_by',
        'kategori_id',
        'total_pengeluaran',
        'keterangan',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPengeluaran::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
