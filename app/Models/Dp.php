<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dp extends Model
{
    use HasFactory;
    protected $table = 'tb_dp';
    protected $fillable = [
        'kd_dp', 'nm_customer', 'server', 'jumlah', 'tgl', 'ket', 'metode', 'tgl_input', 'tgl_digunakan', 'status', 'admin', 'id_lokasi'
    ];
}
