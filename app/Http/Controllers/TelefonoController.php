<?php
namespace App\Http\Controllers;

use App\Exports\TelsExport;
use App\Models\Telefono;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TelefonosExport;
class TelefonoController extends Controller
{
    public function index(Request $request)
    {
        $states = State::all();
        $cities = City::all();
        $query = Telefono::with(['city.state']);

        $selectedState = $request->state;
        $selectedCity = $request->city;
        $orderBy = $request->order_by;

        if ($selectedState) {
            $cityIds = City::where('state_id', $selectedState)->pluck('id');
            $query->whereIn('city_id', $cityIds);
        }

        if ($selectedCity) {
            $query->where('city_id', $selectedCity);
        }

        switch ($orderBy) {
            case 'city_asc':
                $query->orderBy('city_id', 'asc');
                break;
            case 'city_desc':
                $query->orderBy('city_id', 'desc');
                break;
            case 'state_asc':
                $query->orderBy('state_id', 'asc');
                break;
            case 'state_desc':
                $query->orderBy('state_id', 'desc');
                break;
        }

        $telefonos = $query->cursorPaginate(100);

        return view('telefonos.index', compact('states', 'cities', 'telefonos', 'selectedState', 'selectedCity'));
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
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:states,id'
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
        $ciudades = City::where('state_id', $telefono->state_id)->get();
        return view('telefonos.edit', compact('telefono', 'provincias', 'ciudades'));
    }

    public function update(Request $request, Telefono $telefono)
    {
        $request->validate([
            'telefono' => 'required',
            'movil' => 'required',
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:states,id'
        ]);

        $telefono->update($request->all());
        return redirect()->route('telefonos.index');
    }

    public function destroy(Telefono $telefono)
    {
        $telefono->delete();
        return redirect()->route('telefonos.index');
    }

    public function filter(Request $request)
    {
        $query = Telefono::with(['city.state']);

        if ($request->has('state_id') && $request->state_id) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->has('city_id') && $request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        $telefonos = $query->paginate(10);

        return response()->json($telefonos);
    }

    public function export(Request $request)
    {
        $stateId = $request->input('state_id');
        $cityId = $request->input('city_id');
        $quantity = $request->input('quantity', 1000); // Default to 1000 if not specified

        return Excel::download(new TelsExport($stateId, $cityId, $quantity), 'tels.xlsx');
    }
}
