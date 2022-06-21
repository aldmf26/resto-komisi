<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $table = 'ctt_driver';
    protected $fillable = [
        'no_order', 'nm_driver', 'nominal', 'tgl', 'admin'
    ];

}
