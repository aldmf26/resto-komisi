<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    use HasFactory;
    protected $table = 'tb_limit';
    protected $fillable = [
        'id_menu', 'id_lokasi', 'batas_limit', 'jml_limit', 'admin', 'tgl'
    ];
}
