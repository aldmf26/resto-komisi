<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCenter extends Model
{
    use HasFactory;
    protected $table = 'tb_post_center';
    protected $fillable = [
        'id_akun', 'nm_post', 'id_lokasi'
    ];
}
