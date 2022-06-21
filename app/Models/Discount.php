<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'tb_discount';
    protected $fillable = [
        'disc', 'ket', 'jenis', 'dari', 'expired', 'status', 'lokasi'
    ];
}
