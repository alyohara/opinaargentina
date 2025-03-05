<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analytics;
use App\Models\Provincia;
use App\Models\Localidad;
use App\Models\Tel;

class DashboardController extends Controller
{
    public function index()
    {
        $analytics = Analytics::latest()->first();
        return view('dashboard', compact('analytics'));
    }

    public function telefonosPorProvincia($provinciaId)
    {
        $localidades = Localidad::where('provincia_id', $provinciaId)->withCount('telefonos')->get();
        return response()->json($localidades);
    }

    public function buscarTelefonos(Request $request)
    {
        $query = Tel::query();

        if ($request->filled('provincia_id')) {
            $query->whereHas('localidad', function ($q) use ($request) {
                $q->where('provincia_id', $request->provincia_id);
            });
        }

        if ($request->filled('localidad_id')) {
            $query->where('localidad_id', $request->localidad_id);
        }

        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }

        if ($request->filled('edad_min') && $request->filled('edad_max')) {
            $query->whereBetween('edad', [$request->edad_min, $request->edad_max]);
        }

        $telefonos = $query->get();
        return response()->json($telefonos);
    }
    public function ciudadesPorProvincia($provinciaNombre)
    {
        $provinciaId = Provincia::where('nombre', $provinciaNombre)->first()->id;
        $ciudades = Localidad::where('provincia_id', $provinciaId)->withCount('telefonos')->get()->pluck('telefonos_count', 'nombre');
        return response()->json($ciudades);
    }

}
