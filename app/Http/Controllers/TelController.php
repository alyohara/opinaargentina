<?php

namespace App\Http\Controllers;

use App\Jobs\ExportTelefonosJob;
use App\Models\Localidad;
use App\Models\Provincia;
use App\Models\Tel;
use Illuminate\Http\Request;

class TelController extends Controller
{
    public function export(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'provincia_id' => 'nullable|integer|exists:provincias,id',
            'localidad_id' => 'nullable|integer|exists:localidades,id',
            'file_name' => 'nullable|string|max:255',
            'tipo_telefono' => 'nullable|string',
        ]);

        $quantity = $validated['quantity'];
        $stateId = $validated['provincia_id'] ?? null;
        $cityId = $validated['localidad_id'] ?? null;
        $fileName = $validated['file_name'] ?? null;
        $tipoTelefono = $validated['tipo_telefono'] ?? null;

        $userId = auth()->id();

        ExportTelefonosJob::dispatch($stateId, $cityId, $quantity, $userId, $fileName, $tipoTelefono);

        return response()->json(['message' => 'Exportación iniciada.']);
    }
}
