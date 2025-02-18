<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;

    // Especificamos el nombre de la tabla (opcional, ya que Laravel asume el plural en minúsculas)
    protected $table = 'provincias';

    // Define los atributos asignables
    protected $fillable = [
        'nombre',
    ];

    // Ejemplo de relación: si una provincia tiene muchas localidades
    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }
}
