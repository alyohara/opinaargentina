<?php

namespace App\Http\Controllers;

use App\Models\PersonaT;
use Illuminate\Http\Request;

class PersonaTController extends Controller
{
    /**
     * Muestra una lista de los registros de personas.
     */
    public function index()
    {
        $personas = PersonaT::all();
        return view('personas_t.index', compact('personas'));
    }

    /**
     * Muestra el formulario para crear una nueva persona.
     */
    public function create()
    {
        return view('personas_t.create');
    }

    /**
     * Almacena una nueva persona en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'apellido_y_nombre'         => 'nullable|string|max:255',
            'dni'                       => 'nullable|integer',
            'direccion'                 => 'nullable|string|max:255',
            'anio_nacimiento'           => 'nullable|integer',
            'genero'                    => 'nullable|string',
            'nacionalidad'              => 'nullable|string|max:100',
            'email'                     => 'nullable|string|max:100',
            'dato_extra_1'              => 'nullable|string',
            'dato_extra_2'              => 'nullable|string',
            'telefono'                  => 'nullable|string|max:20',
            'movil'                     => 'nullable|string|max:20',
            'cp'                        => 'nullable|integer',
            'seccion'                   => 'nullable|string|max:50',
            'circuito'                  => 'nullable|string|max:50',
            'mesa'                      => 'nullable|integer',
            'orden'                     => 'nullable|integer',
            'establecimiento'           => 'nullable|string|max:255',
            'direccion_establecimiento' => 'nullable|string|max:255',
            'state'                     => 'nullable|string|max:50',
            'created_by'                => 'nullable|integer',
            'updated_by'                => 'nullable|integer',
            'deleted_by'                => 'nullable|integer',
            'created_at'                => 'nullable|date',
            'updated_at'                => 'nullable|date',
            'deleted_at'                => 'nullable|date',
            'localidad_id'              => 'nullable|integer|exists:localidades,id',
        ]);

        PersonaT::create($data);

        return redirect()->route('personas_t.index')->with('success', 'Registro creado exitosamente.');
    }

    /**
     * Muestra un registro específico.
     */
    public function show(PersonaT $personaT)
    {
        return view('personas_t.show', compact('personaT'));
    }

    /**
     * Muestra el formulario para editar un registro.
     */
    public function edit(PersonaT $personaT)
    {
        return view('personas_t.edit', compact('personaT'));
    }

    /**
     * Actualiza el registro en la base de datos.
     */
    public function update(Request $request, PersonaT $personaT)
    {
        $data = $request->validate([
            'apellido_y_nombre'         => 'nullable|string|max:255',
            'dni'                       => 'nullable|integer',
            'direccion'                 => 'nullable|string|max:255',
            'anio_nacimiento'           => 'nullable|integer',
            'genero'                    => 'nullable|string',
            'nacionalidad'              => 'nullable|string|max:100',
            'email'                     => 'nullable|string|max:100',
            'dato_extra_1'              => 'nullable|string',
            'dato_extra_2'              => 'nullable|string',
            'telefono'                  => 'nullable|string|max:20',
            'movil'                     => 'nullable|string|max:20',
            'cp'                        => 'nullable|integer',
            'seccion'                   => 'nullable|string|max:50',
            'circuito'                  => 'nullable|string|max:50',
            'mesa'                      => 'nullable|integer',
            'orden'                     => 'nullable|integer',
            'establecimiento'           => 'nullable|string|max:255',
            'direccion_establecimiento' => 'nullable|string|max:255',
            'state'                     => 'nullable|string|max:50',
            'created_by'                => 'nullable|integer',
            'updated_by'                => 'nullable|integer',
            'deleted_by'                => 'nullable|integer',
            'created_at'                => 'nullable|date',
            'updated_at'                => 'nullable|date',
            'deleted_at'                => 'nullable|date',
            'localidad_id'              => 'nullable|integer|exists:localidades,id',
        ]);

        $personaT->update($data);

        return redirect()->route('personas_t.index')->with('success', 'Registro actualizado exitosamente.');
    }

    /**
     * Elimina el registro de la base de datos.
     */
    public function destroy(PersonaT $personaT)
    {
        $personaT->delete();
        return redirect()->route('personas_t.index')->with('success', 'Registro eliminado exitosamente.');
    }
}
