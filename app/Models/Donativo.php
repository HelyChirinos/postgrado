<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donativo extends Model
{
    use HasFactory;
    protected $guarded = [];


     
     /* -------------------------------------------------------------------------------------------- */
    // Relationships
    /* -------------------------------------------------------------------------------------------- */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }   
   
    public function recibo(): BelongsTo
    {
        return $this->belongsTo(Recibo::class);
    }   
   

}
