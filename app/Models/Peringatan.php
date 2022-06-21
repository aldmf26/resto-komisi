<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peringatan extends Model
{
    use HasFactory;
    protected $table = 'tb_peringatan';
    protected $fillable = [
        'id_lokasi', 'jam_buat', 'jam_akhir', 'tgl', 'admin'
    ];
}
