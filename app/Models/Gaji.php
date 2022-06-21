<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = 'tb_gaji';
    protected $fillable = [
        'id_karyawan', 'rp_e', 'rp_m', 'rp_sp', 'g_bulanan'
    ];
}

