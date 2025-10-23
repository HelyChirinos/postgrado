<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisa extends Model
{
    use HasFactory;
    protected $connection = 'credentials';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'fecha' => 'datetime',
    ];


}
