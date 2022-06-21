<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posisi extends Model
{
    use HasFactory;
    protected $table = 'tb_posisi';
    protected $fillable = [
        'nm_posisi', 'ket'
    ];
}
