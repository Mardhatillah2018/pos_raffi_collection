<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_cabang',
        'nama_cabang',
        'jam_buka',
        'jam_tutup',
        'no_hp',
        'alamat',
    ];
}
