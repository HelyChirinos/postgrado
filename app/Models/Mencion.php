<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mencion extends Model
{
    use HasFactory;
    protected $table = 'menciones';
    protected $guarded = [];



public function programa(): BelongsTo
{
    return $this->belongsTo(Programa::class);
}



}

