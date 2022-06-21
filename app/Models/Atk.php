<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atk extends Model
{
    use HasFactory;
    protected $table = 'tb_atk';
    protected $fillable = [
        'nm_barang', 'qty_debit', 'qty_kredit', 'debit_atk', 'kredit_atk', 'no_nota', 'id_satuan', 'tgl', 'id_lokasi'
    ];
}
