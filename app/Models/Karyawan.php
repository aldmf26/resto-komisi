<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'tb_karyawan';
    protected $fillable = [
        'nama', 'id_status', 'tgl_masuk', 'id_posisi'
    ];
}
