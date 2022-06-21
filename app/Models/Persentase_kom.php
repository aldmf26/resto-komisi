<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persentase_kom extends Model
{
    use HasFactory;
    protected $table = 'persentse_komisi';
    protected $fillable = [
        'id_persentase', 'nama_persentase', 'jumlah_persen', 'id_lokasi'
    ];
}
