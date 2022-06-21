<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'tb_transaksi';
    protected $fillable = [
        'tgl_transaksi', 'no_order','discount', 'voucher', 'dp', 'gosen', 'round', 'total_orderan', 'total_bayar', 'cash', 'd_bca', 'k_bca', 'd_mandiri', 'k_mandiri', 'admin', 'id_lokasi', 'ongkir', 'service', 'tax'
    ];
}
