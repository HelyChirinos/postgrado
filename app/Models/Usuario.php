<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'email',
        'password',
        'telefono',
        'fecha_nac',
        'is_propietario',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_propietario' => 'boolean',
        'password' => 'hashed',
        'fecha_nac' => 'date:d/m/Y',
    ];

    /* -------------------------------------------------------------------------------------------- */
    // Accessors & Mutators
    /* -------------------------------------------------------------------------------------------- */

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = ucwords(trim(strtolower($value)));
    }

    public function setApellidoAttribute($value)
    {
       $this->attributes['apellido'] = ucwords(trim(strtolower($value)));
    }

    public function getFullNameAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function getNameAttribute()
    {
        $nombre = strpos(trim($this->nombre)," ") ? substr($this->nombre,0,strpos(trim($this->nombre)," ")) : trim($this->nombre);
        $apellido = strpos(trim($this->apellido)," ") ? substr($this->apellido,0,strpos(trim($this->apellido)," ")) : trim($this->apellido);
        return $nombre . ' ' . $apellido;
    }

     /**
     * Appends .
     */
 
     protected $appends = [
        'name',
    ];   

    /* -------------------------------------------------------------------------------------------- */
    // Relationships
    /* -------------------------------------------------------------------------------------------- */
    public function userlogs(): HasMany
    {
        return $this->hasMany(Userlog::class, 'user_id');
    }
}



