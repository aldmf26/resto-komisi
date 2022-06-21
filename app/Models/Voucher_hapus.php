<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher_hapus extends Model
{
    use HasFactory;
    protected $table = 'tb_voucher_hapus';
    protected $fillable = [
        'kode_voucher', 'status'
    ];
}
