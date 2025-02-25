<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    /**
     * Muestra una lista de las localidades.
     */
    public function index()
    {
        $localidades = Localidad::all();
        return view('localidades.index', compact('localidades'));
    }

    /**
     * Muestra el formulario para crear una nueva localidad.
     */
    public function create()
    {
        return view('localidades.create');
    }

    /**
     * Almacena una nueva localidad en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'nullable|string|max:100',
            'provincia_id' => 'required|exists:provincias,id',
        ]);

        Localidad::create($data);

        return redirect()->route('localidades.index')->with('success', 'Localidad creada exitosamente.');
    }

    /**
     * Muestra una localidad específica.
     */
    public function show(Localidad $localidad)
    {
        return view('localidades.show', compact('localidad'));
    }

    /**
     * Muestra el formulario para editar una localidad.
     */
    public function edit(Localidad $localidad)
    {
        return view('localidades.edit', compact('localidad'));
    }

    /**
     * Actualiza la localidad en la base de datos.
     */
    public function update(Request $request, Localidad $localidad)
    {
        $data = $request->validate([
            'nombre' => 'nullable|string|max:100',
            'provincia_id' => 'required|exists:provincias,id',
        ]);

        $localidad->update($data);

        return redirect()->route('localidades.index')->with('success', 'Localidad actualizada exitosamente.');
    }

    /**
     * Elimina la localidad de la base de datos.
     */
    public function destroy(Localidad $localidad)
    {
        $localidad->delete();
        return redirect()->route('localidades.index')->with('success', 'Localidad eliminada exitosamente.');
    }

    public function getLocalidadesByProvincia($provinciaId)
    {
        $localidades = Localidad::where('provincia_id', $provinciaId)->paginate(500);
        return response()->json($localidades);
    }
}
