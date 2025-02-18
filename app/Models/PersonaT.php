<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaT extends Model
{
    use HasFactory;

    // Especificamos el nombre de la tabla (opcional, ya que Laravel infiere 'persona_ts' a partir de 'PersonaT')
    protected $table = 'personas_t';

    // Define los atributos asignables
    protected $fillable = [
        'apellido_y_nombre',
        'dni',
        'direccion',
        'anio_nacimiento',
        'genero',
        'nacionalidad',
        'email',
        'dato_extra_1',
        'dato_extra_2',
        'telefono',
        'movil',
        'cp',
        'seccion',
        'circuito',
        'mesa',
        'orden',
        'establecimiento',
        'direccion_establecimiento',
        'state',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'localidad_id',
    ];

    // Si deseas definir relaciones, por ejemplo:
    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }
}
