<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $table = 'tb_absen';
    protected $fillable = [
        'id_karyawan', 'status', 'tgl', 'id_lokasi'
    ];
}
