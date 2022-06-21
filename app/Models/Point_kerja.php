<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point_kerja extends Model
{
    use HasFactory;
    protected $table = 'keterangan_cuci';
    protected $fillable = [
        'id_ket', 'ket', 'point'
    ];
}
