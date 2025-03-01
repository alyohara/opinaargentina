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
use App\Jobs\ExportTelsJob; // Import the correct job class

class TelController extends Controller
{
    /**
     * Muestra una lista de los registros de teléfonos.
     */
    public function index(Request $request)
    {
        ini_set('memory_limit', '2G');

        $states = Provincia::all();
        //$cities = Localidad::all();
        $query =  Tel::with(['localidad.provincia']);

        $selectedState = $request->provincia;
        $selectedCity = $request->localidad;
        $selectedTipoTelefono = $request->tipo_telefono;
        $orderBy = $request->order_by;
        $orderBy = $request->order_by;


        if ($selectedState) {
            $cities = Localidad::where('provincia_id', $selectedState)->get();
            $cityIds = $cities->pluck('id');
            $query->whereIn('localidad_id', $cityIds);
        } else {
            $selectedState = null;
            $cities = Localidad::all();
        }

        if ($selectedCity) {
            $query->where('localidad_id', $selectedCity);
        }
        if ($selectedTipoTelefono) {
            $query->where('tipo_telefono', $selectedTipoTelefono);
        }

        $tels = $query->paginate(100);
        //dd($tels);
        $provincias = $states;
        $localidades = $cities;
        $selectedProvincia = $selectedState;
        $selectedLocalidad = $selectedCity;

        return view('tels.index', compact('provincias', 'localidades', 'tels', 'selectedProvincia', 'selectedLocalidad'));
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
    public function export(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'provincia_id' => 'nullable|integer|exists:provincias,id',
            'localidad_id' => 'nullable|integer|exists:localidades,id',
            'file_name' => 'nullable|string|max:255',
            'tipo_telefono' => 'nullable|string|in:fijo,movil',
        ]);

        $quantity = $validated['quantity'];
        $stateId = $validated['provincia_id'] ?? null;
        $cityId = $validated['localidad_id'] ?? null;
        $fileName = $validated['file_name'] ?? 'tels_export_' . now()->format('YmdHis') . '.xlsx'; // Default filename
        $tipoTelefono = $validated['tipo_telefono'] ?? null;

        $userId = auth()->id();

        ExportTelsJob::dispatch($stateId, $cityId, $quantity, $userId, $fileName, $tipoTelefono);

        return response()->json(['message' => 'Exportación iniciada.']);
    }
}
