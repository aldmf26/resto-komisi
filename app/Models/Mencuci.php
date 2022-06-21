<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mencuci extends Model
{
    use HasFactory;
    protected $table = 'tb_mencuci';
    protected $fillable = [
    'nm_karyawan', 'id_ket', 'j_awal', 'j_akhir', 'tgl','admin','ket2'
    ];
}
