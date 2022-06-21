<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;
    protected $table = 'tb_peralatan';
    protected $fillable = [
        'tgl', 'id_kelompok_peralatan', 'barang', 'qty', 'lokasi', 'id_satuan', 'debit','lokasi','penanggung_jawab','b_penyusutan','id_peralatan_kredit','kredit'
    ];
}
