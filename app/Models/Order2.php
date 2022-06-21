<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order2 extends Model
{
    use HasFactory;
    protected $table = 'tb_order2';
    protected $fillable = [
        'id_order2', 'id_order1', 'no_order', 'no_order2', 'id_harga', 'qty','harga','tgl','id_lokasi','admin','id_distribusi','id_meja'
    ];
}
