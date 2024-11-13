<?php
namespace App\Http\Controllers;

use App\Exports\TelsExport;
use App\Models\Telefono;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TelefonosExport;
use Illuminate\Support\Facades\Storage;
use ZipArchive;



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

        $query = Telefono::query()->with(['city.state']);

        if ($stateId) {
            $cityIds = City::where('state_id', $stateId)->pluck('id');
            $query->whereIn('city_id', $cityIds);
        }

        if ($cityId) {
            $query->where('city_id', $cityId);
        }

        if ($quantity > 10000) {
            $chunks = ceil($quantity / 10000);
            $fileNames = [];

            for ($i = 0; $i < $chunks; $i++) {
                $data = $query->skip($i * 10000)->take(10000)->get();
                $fileName = 'tels_export_' . now()->format('YmdHis') . '_part_' . ($i + 1) . '.xlsx';
                Excel::store(new TelsExport($data), $fileName, 'local');
                $fileNames[] = storage_path('app/' . $fileName);
            }

            // Create a zip file containing all the Excel files
            $zipFileName = 'tels_export_' . now()->format('YmdHis') . '.zip';
            $zipFilePath = storage_path('app/' . $zipFileName);
            $zip = new ZipArchive;
            if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
                foreach ($fileNames as $file) {
                    if (file_exists($file)) {
                        $zip->addFile($file, basename($file));
                    }
                }
                $zip->close();
            }

            return response()->download($zipFilePath);
        } else {
            $data = $query->limit($quantity)->get();
            $fileName = 'tels_export_' . now()->format('YmdHis') . '.xlsx';
            return Excel::download(new TelsExport($data), $fileName);
        }
    }
}
