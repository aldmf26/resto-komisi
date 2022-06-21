<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;
    protected $table = 'tb_kasbon';
    protected $fillable = [
        'nm_karyawan', 'nominal', 'tgl', 'admin'
    ];
}
