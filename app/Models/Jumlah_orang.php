<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jumlah_orang extends Model
{
    use HasFactory;
    protected $table = 'tb_jumlah_orang';
    protected $fillable = [
        'id_orang', 'ket_karyawan', 'jumlah'
    ];
}
