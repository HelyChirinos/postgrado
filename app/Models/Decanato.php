<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decanato extends Model
{
    use HasFactory;
    protected $connection = 'credentials';
    public $timestamps = false;

}
