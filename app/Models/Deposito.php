<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deposito extends Model
{
    use HasFactory;
    protected $guarded = [];

    /* -------------------------------------------------------------------------------------------- */
    // Accessors & Mutators
    /* -------------------------------------------------------------------------------------------- */


    public function getReferenciaAttribute()
    {
        $referencia = substr(($this->numero),-5);
        return $referencia;
    }

 /**
     * Appends .
     */
 
     protected $appends = [
        'referencia'
    ];



     /* -------------------------------------------------------------------------------------------- */
    // Relationships
    /* -------------------------------------------------------------------------------------------- */

    


    public function estudiante(): belongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function recibo(): belongsTo
    {
        return $this->belongsTo(Recibo::class);
    }


}
