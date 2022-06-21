<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal';
    protected $fillable = [
        'id_buku', 'id_akun','id_post_center', 'kd_gabungan', 'id_lokasi', 'no_nota', 'jenis','no_urutan', 'debit', 'kredit', 'no_bkin', 'id_produk', 'qty', 'id_satuan', 'admin', 'rp_beli', 'ttl_rp', 'rp_pajak','tgl_input', 'status', 'ket','ket2', 'tgl'
    ];
}
