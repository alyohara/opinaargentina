<?php
namespace App\Http\Controllers;

use App\Models\Telefono;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class TelefonoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $filter = $request->get('filter', '');

        $telefonos = Telefono::with(['city.state'])
            ->where('telefono', 'like', "%{$filter}%")
            ->orWhere('movil', 'like', "%{$filter}%")
            ->paginate($perPage);

        return view('telefonos.index', compact('telefonos', 'perPage', 'filter'));
    }

    public function create()
    {
        $provincias = State::all();
        return view('telefonos.create', compact('provincias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'telefono' => 'required',
            'movil' => 'required',
            'city_id' => 'required|exists:cities,id'
        ]);

        Telefono::create($request->all());
        return redirect()->route('telefonos.index');
    }

    public function show(Telefono $telefono)
    {
        return view('telefonos.show', compact('telefono'));
    }

    public function edit(Telefono $telefono)
    {
        $provincias = State::all();
        $ciudades = City::where('state_id', $telefono->city->state_id)->get();
        return view('telefonos.edit', compact('telefono', 'provincias', 'ciudades'));
    }

    public function update(Request $request, Telefono $telefono)
    {
        $request->validate([
            'telefono' => 'required',
            'movil' => 'required',
            'city_id' => 'required|exists:cities,id'
        ]);

        $telefono->update($request->all());
        return redirect()->route('telefonos.index');
    }

    public function destroy(Telefono $telefono)
    {
        $telefono->delete();
        return redirect()->route('telefonos.index');
    }
}
