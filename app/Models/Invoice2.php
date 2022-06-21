<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice2 extends Model
{
    use HasFactory;
    protected $table = 'tb_kd_invoice2';
    protected $fillable = [
        'no_invoice', 'tanggal'
    ];
}
