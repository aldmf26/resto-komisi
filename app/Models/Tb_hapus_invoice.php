<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_hapus_invoice extends Model
{
    use HasFactory;
    protected $table = 'tb_hapus_invoice';
    protected $fillable = [
        'no_order', 'tgl_order', 'alasan', 'nominal_invoice', 'id_lokasi', 'meja', 'admin'
    ];
}
