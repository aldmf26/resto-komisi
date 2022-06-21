<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelPeralatan extends Model
{
    use HasFactory;
    protected $table = 'tb_kelompok_peralatan';
    protected $fillable = [
        'nm_kelompok', 'umur', 'satuan', 'tarif', 'barang_kelompok'
    ];
}
