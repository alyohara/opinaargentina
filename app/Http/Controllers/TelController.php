<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Localidad;
use App\Models\Provincia;
use App\Models\State;
use App\Models\Tel;
use App\Models\Telefono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TelController extends Controller
{
    /**
     * Muestra una lista de los registros de teléfonos.
     */
    public function index(Request $request)
    {
        ini_set('memory_limit', '1024M');

        $states = Provincia::all();
        $cities = Localidad::all();
       // $query = Telefono::with(['city.state']);

        $selectedState = $request->provincia ?? 0;
        $selectedCity = $request->localidad ?? 0;
        $orderBy = $request->order_by;

        if ($selectedState) {
            $cityIds = Localidad::where('provincia_id', $selectedState)->pluck('id');
           // $query->whereIn('city_id', $cityIds);
        }

        if ($selectedCity) {
            //$query->where('city_id', $selectedCity);
        }

        switch ($orderBy) {
            case 'city_asc':
                //$query->orderBy('city_id', 'asc');
                break;
            case 'city_desc':
                //$query->orderBy('city_id', 'desc');
                break;
            case 'state_asc':
                //$query->orderBy('state_id', 'asc');
                break;
            case 'state_desc':
                //$query->orderBy('state_id', 'desc');
                break;
        }
        $telefonos = Tel::with(['localidad.provincia'])->take(10)->get();
        //$telefonos = $query->cursorPaginate(100);
        $provincias = $states;
        $localidades = $cities;
        $selectedProvincia = $selectedState;
        $selectedLocalidad = $selectedCity;

        return view('tels.index', compact('provincias', 'localidades', 'telefonos', 'selectedProvincia', 'selectedLocalidad'));
    }

    /**
     * Muestra el formulario para crear un nuevo registro.
     */
    public function create()
    {
        return view('tels.create');
    }

    /**
     * Almacena un nuevo registro en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'persona_id' => 'nullable|integer|exists:personas_t,id',
            'tipo_telefono' => 'nullable|in:fijo,movil',
            'nro_telefono' => 'nullable|string|max:15',
            'localidad_id' => 'nullable|integer|exists:localidades,id',
            'provincia_id' => 'nullable|integer|exists:provincias,id',
        ]);

        Tel::create($data);

        return redirect()->route('tels.index')->with('success', 'Registro creado exitosamente.');
    }

    /**
     * Muestra un registro específico.
     */
    public function show(Tel $tel)
    {
        return view('tels.show', compact('tel'));
    }

    /**
     * Muestra el formulario para editar un registro.
     */
    public function edit(Tel $tel)
    {
        return view('tels.edit', compact('tel'));
    }

    /**
     * Actualiza el registro en la base de datos.
     */
    public function update(Request $request, Tel $tel)
    {
        $data = $request->validate([
            'persona_id' => 'nullable|integer|exists:personas_t,id',
            'tipo_telefono' => 'nullable|in:fijo,movil',
            'nro_telefono' => 'nullable|string|max:15',
            'localidad_id' => 'nullable|integer|exists:localidades,id',
            'provincia_id' => 'nullable|integer|exists:provincias,id',
        ]);

        $tel->update($data);

        return redirect()->route('tels.index')->with('success', 'Registro actualizado exitosamente.');
    }

    /**
     * Elimina el registro de la base de datos.
     */
    public function destroy(Tel $tel)
    {
        $tel->delete();
        return redirect()->route('tels.index')->with('success', 'Registro eliminado exitosamente.');
    }
}
