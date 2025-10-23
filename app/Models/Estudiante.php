<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estudiante extends Model
{
    use HasFactory;
    protected $guarded = [];




    /* -------------------------------------------------------------------------------------------- */
    // Accessors & Mutators
    /* -------------------------------------------------------------------------------------------- */

    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = ucwords(trim(strtolower($value)));
    }

    public function setApellidosAttribute($value)
    {
        $this->attributes['apellidos'] = ucwords(trim(strtolower($value)));
    }

    public function getnombreAttribute()
    {
        $nombre = strpos(trim($this->nombres)," ") ? substr($this->nombres,0,strpos(trim($this->nombres)," ")) : trim($this->nombres);
        $apellido = strpos(trim($this->apellidos)," ") ? substr($this->apellidos,0,strpos(trim($this->apellidos)," ")) : trim($this->apellidos);
        return $nombre . ' ' . $apellido;
    }

     /**
     * Appends .
     */
 
     protected $appends = [
        'nombre',
    ];   



     /* -------------------------------------------------------------------------------------------- */
    // Relationships
    /* -------------------------------------------------------------------------------------------- */
    public function programa(): BelongsTo
    {
        return $this->belongsTo(Programa::class);
    }

    public function mencion(): belongsTo
    {
        return $this->belongsTo(Mencion::class);
    }

    public function recibos(): HasMany
    {
        return $this->hasMany(Recibo::class, 'estudiante_id');
    }

}
