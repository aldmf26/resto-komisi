<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handicap extends Model
{
    use HasFactory;
    protected $table = 'tb_handicap';
    protected $fillable = [
        'handicap', 'point','ket', 'id_lokasi'
    ];
}
