<?php

namespace App\Http\Controllers;

use App\Models\Tel;
use Illuminate\Http\Request;

class TelController extends Controller
{
    /**
     * Muestra una lista de los registros de teléfonos.
     */
    public function index(Request $request)
    {
        // Cache provinces and localities to reduce database load
        $provincias = Cache::remember('provincias', now()->addMinutes(10), function () {
            return Provincia::all();
        });

        $localidades = Cache::remember('localidades', now()->addMinutes(10), function () {
            return Localidad::all();
        });

        $query = Tel::with(['localidad.provincia']);

        if ($request->has('provincia_id') && $request->provincia_id) {
            $query->where('provincia_id', $request->provincia_id);
        }

        if ($request->has('localidad_id') && $request->localidad_id) {
            $query->where('localidad_id', $request->localidad_id);
        }

        // Use cursor pagination for better performance with large datasets
        $tels = $query->cursorPaginate(100);

        return view('tels.index', compact('provincias', 'localidades', 'tels'));
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
