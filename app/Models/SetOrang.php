<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetOrang extends Model
{
    use HasFactory;
    protected $table = 'tb_jumlah_orang';
    protected $fillable = [
        'ket_karyawan', 'jumlah'
    ];
}
