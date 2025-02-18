<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    /**
     * Muestra una lista de las provincias.
     */
    public function index()
    {
        $provincias = Provincia::all();
        return view('provincias.index', compact('provincias'));
    }

    /**
     * Muestra el formulario para crear una nueva provincia.
     */
    public function create()
    {
        return view('provincias.create');
    }

    /**
     * Almacena una nueva provincia en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'nullable|string|max:100|unique:provincias,nombre',
        ]);

        Provincia::create($data);

        return redirect()->route('provincias.index')->with('success', 'Provincia creada exitosamente.');
    }

    /**
     * Muestra una provincia específica.
     */
    public function show(Provincia $provincia)
    {
        return view('provincias.show', compact('provincia'));
    }

    /**
     * Muestra el formulario para editar una provincia.
     */
    public function edit(Provincia $provincia)
    {
        return view('provincias.edit', compact('provincia'));
    }

    /**
     * Actualiza la provincia en la base de datos.
     */
    public function update(Request $request, Provincia $provincia)
    {
        $data = $request->validate([
            'nombre' => 'nullable|string|max:100|unique:provincias,nombre,' . $provincia->id,
        ]);

        $provincia->update($data);

        return redirect()->route('provincias.index')->with('success', 'Provincia actualizada exitosamente.');
    }

    /**
     * Elimina la provincia de la base de datos.
     */
    public function destroy(Provincia $provincia)
    {
        $provincia->delete();
        return redirect()->route('provincias.index')->with('success', 'Provincia eliminada exitosamente.');
    }
}
