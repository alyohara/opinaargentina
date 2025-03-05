<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    // Define the table if it's not the plural of the model name
    protected $table = 'analytics';

    // Define the fillable fields
    protected $fillable = [
        'total_telefonos',
        'total_usuarios',
        'localidad_con_mas_telefonos',
        'telefonos_por_provincia',
        'usuarios_por_rol',
        'ranking_provincias',
    ];

    // Cast attributes to appropriate types
    protected $casts = [
        'telefonos_por_provincia' => 'array',
        'usuarios_por_rol' => 'array',
        'ranking_provincias' => 'array',
    ];
    public static function updateAnalytics()
    {
        // Update logic for analytics
        $analytics = self::latest()->first();
        $analytics->update([
            'telefonos_por_provincia' => Provincia::withCount('telefonos')->get()->pluck('telefonos_count', 'nombre')->toArray(),
            'ranking_provincias' => Provincia::withCount('telefonos')->orderBy('telefonos_count', 'desc')->get()->pluck('telefonos_count', 'nombre')->toArray(),
        ]);
    }
}
