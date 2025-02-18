<?php

// app/Http/Controllers/EquipoController.php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::all();
        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        $leaders = User::whereHas('roles', function($query) {
            $query->where('name', 'Lider de Equipo');
        })->doesntHave('equipoAsLeader')->get();

        $operators = User::whereHas('roles', function($query) {
            $query->where('name', 'Operador');
        })->doesntHave('equipoAsOperator')->get();

        return view('equipos.create', compact('leaders', 'operators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'leader_id' => 'required|exists:users,id',
            'operators' => 'array',
        ]);

        $equipo = Equipo::create($request->only('name', 'leader_id'));
        $equipo->users()->sync($request->operators);

        return redirect()->route('equipos.index');
    }

    public function edit(Equipo $equipo)
    {
        $leaders = User::whereHas('roles', function($query) {
            $query->where('name', 'Lider de Equipo');
        })->doesntHave('equipoAsLeader')->orWhere('id', $equipo->leader_id)->get();

        $operators = User::whereHas('roles', function($query) {
            $query->where('name', 'Operador');
        })->doesntHave('equipoAsOperator')->orWhereIn('id', $equipo->users->pluck('id'))->get();

        return view('equipos.edit', compact('equipo', 'leaders', 'operators'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'leader_id' => 'required|exists:users,id',
            'operators' => 'array',
        ]);

        $equipo->update($request->only('name', 'leader_id'));
        $equipo->users()->sync($request->operators);

        return redirect()->route('equipos.index');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();

        return redirect()->route('equipos.index');
    }
}
