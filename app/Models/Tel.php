<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tel extends Model
{
    use HasFactory;

    // Especificamos el nombre de la tabla, ya que no se sigue la convención de pluralización
    protected $table = 'tels';

    // Atributos asignables
    protected $fillable = [
        'persona_id',
        'tipo_telefono',
        'nro_telefono',
        'localidad_id',
        'provincia_id',
    ];

    /**
     * Relación: cada teléfono pertenece a una persona.
     */
    public function persona()
    {
        return $this->belongsTo(PersonaT::class, 'persona_id');
    }

    /**
     * Relación: cada teléfono pertenece a una localidad.
     */
    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    /**
     * Relación: cada teléfono pertenece a una provincia.
     */
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }
    
}
