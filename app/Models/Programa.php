<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Programa extends Model
{
    use HasFactory;
    protected $guarded = [];    

    
    /* -------------------------------------------------------------------------------------------- */
    // Relationships
    /* -------------------------------------------------------------------------------------------- */
    public function menciones(): HasMany
    {
        return $this->hasMany(Mencion::class);
    }



}
