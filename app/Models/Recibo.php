<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;




class Recibo extends Model
{
    use HasFactory;
    protected $guarded = [];


     /* -------------------------------------------------------------------------------------------- */
    // Relationships
    /* -------------------------------------------------------------------------------------------- */


    public function estudiante(): belongsTo
    {
        return $this->belongsTo(Estudiante::class,'no_doc','no_doc');
    }

    public function depositos(): HasMany
    {
        return $this->hasMany(Deposito::class);
    }

    public function constancias(): HasMany
    {
        return $this->hasMany(Constancia::class);
    }
    public function aranceles(): HasMany
    {
        return $this->hasMany(Constancia::class)->where('tipo','ARANCEL');
    }

    public function matriculas(): HasMany
    {
        return $this->hasMany(Constancia::class)->where('tipo','MATRICULA');
    }


}
