<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;
    protected $table = 'tb_akun';
    protected $fillable = [
        'kd_akun', 'no_akun', 'nm_akun', 'id_kategori', 'id_lokasi'
    ];
}
