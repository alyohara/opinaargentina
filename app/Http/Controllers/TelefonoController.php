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
        $quantity = $request->input('quantity', 10000);

        $query = Telefono::query()->with(['city.state']);

        if ($stateId) {
            $cityIds = City::where('state_id', $stateId)->pluck('id');
            $query->whereIn('city_id', $cityIds);
        }

        if ($cityId) {
            $query->where('city_id', $cityId);
        }

        if ($quantity <= 10000) {
            // Si la cantidad es 10000 o menos, exportar directamente
            $fileName = 'tels_export_' . now()->format('YmdHis') . '.xlsx';
            return Excel::download(new TelsExport($query, $quantity), $fileName);
        } else {
            // Si la cantidad es más de 10000, usar el sistema de lotes
            $batchSize = 10000;
            $batches = ceil($quantity / $batchSize);

            $zipFileName = 'tels_export_' . now()->format('YmdHis') . '.zip';
            $zip = new ZipArchive();
            $zip->open(storage_path('app/public/' . $zipFileName), ZipArchive::CREATE | ZipArchive::OVERWRITE);

            $remainingQuantity = $quantity;

            for ($i = 0; $i < $batches; $i++) {
                $currentBatchSize = min($batchSize, $remainingQuantity);
                $offset = $i * $batchSize;
                $currentQuery = clone $query;
                $currentQuery->offset($offset)->limit($currentBatchSize);

                $fileName = 'tels_part_' . ($i + 1) . '.xlsx';
                $tempPath = storage_path('app/temp/' . $fileName);

                Excel::store(new TelsExport($currentQuery, $currentBatchSize), 'temp/' . $fileName);
                $zip->addFile($tempPath, $fileName);

                $remainingQuantity -= $currentBatchSize;
            }

            $zip->close();

            // Limpiar archivos temporales
            foreach (Storage::files('temp') as $file) {
                Storage::delete($file);
            }

            return response()->download(storage_path('app/public/' . $zipFileName))->deleteFileAfterSend(true);
        }
    }
}
