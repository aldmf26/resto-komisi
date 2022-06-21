<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktiva extends Model
{
    use HasFactory;
    protected $table = 'aktiva';
    protected $fillable = [
        'tgl', 'id_kelompok', 'barang', 'qty', 'id_lokasi', 'satuan', 'debit_aktiva', 'kredit_aktiva', 'nota',' b_penyusutan'
    ];
}
