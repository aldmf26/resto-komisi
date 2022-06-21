<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldOut extends Model
{
    use HasFactory;
    protected $table = 'tb_sold_out';
    protected $fillable = [
        'tgl','id_menu', 'id_lokasi', 'admin'
    ];
}
