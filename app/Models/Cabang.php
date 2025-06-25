<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $fillable = [
        'kode_cabang',
        'nama_cabang',
        'jam_buka',
        'jam_tutup',
        'alamat',
    ];
}
