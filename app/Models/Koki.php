<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koki extends Model
{
    use HasFactory;
    protected $table = 'tb_koki';
    protected $fillable = [
        'id_karyawan', 'tgl', 'status', 'id_lokasi'
    ];
}
