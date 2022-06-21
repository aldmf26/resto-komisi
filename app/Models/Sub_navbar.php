<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_navbar extends Model
{
    use HasFactory;
    protected $table = 'tb_sub_navbar';
    protected $fillable = [
        'urutan'
    ];
}
