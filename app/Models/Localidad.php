<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    // Si el nombre de la tabla no es el plural de "Localidad", especifícalo
    protected $table = 'localidades';

    // Define los atributos asignables
    protected $fillable = [
        'nombre',
        'provincia_id',
        'telefonos_count',
    ];

    // Relaciones: Por ejemplo, si cada localidad pertenece a una provincia:
    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
    public function telefonos()
    {
        return $this->hasMany(Tel::class);
    }
}
