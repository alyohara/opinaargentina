<?php

namespace App\Jobs;

use App\Exports\TelsExport;
use App\Models\Export;
use App\Models\Tel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Events\ExportCompleted;
use Illuminate\Support\Facades\DB;
use PDO;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ExportTelefonosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $quantity;
    protected $userId;
    protected $fileName;
    protected $tipoTelefono;
    protected $orderBy;

    public $timeout = 7200; // 2 horas

    public function __construct($stateId, $cityId, $quantity, $userId, $fileName = null, $tipoTelefono = null, $orderBy = null)
    {
        $this->stateId = $stateId;
        $this->cityId = $cityId;
        $this->quantity = $quantity;
        $this->userId = $userId;
        $this->fileName = $fileName ?: 'tels_export';
        $this->tipoTelefono = $tipoTelefono;
        $this->orderBy = $orderBy;
    }

    public function handle()
    {
        ini_set('max_execution_time', 28800); // 8 hours
        ini_set('memory_limit', '8192M'); // 8GB

        // Set database timeout
        DB::connection()->getPdo()->setAttribute(PDO::ATTR_TIMEOUT, 28800);

        $export = Export::create([
            'user_id' => $this->userId,
            'job_started_at' => Carbon::now(),
            'status' => 'in_progress',
            'file_path' => '',
            'file_size' => 0
        ]);

        \Log::info('ExportTelefonosJob iniciado', ['exportId' => $export->id]);

        try {
            $baseQuery = Tel::select('nro_telefono', 'localidad_id', 'id')
                ->with('localidad.provincia')
                ->whereNotNull('nro_telefono')
                ->where('nro_telefono', '!=', '');

            if ($this->stateId && !$this->cityId) {
                $baseQuery->whereHas('localidad', function ($query) {
                    $query->where('provincia_id', $this->stateId);
                });
            } elseif ($this->cityId) {
                $baseQuery->where('localidad_id', $this->cityId);
            }
            if ($this->tipoTelefono) {
                $baseQuery->where('tipo_telefono', $this->tipoTelefono);
            }
//            if ($this->orderBy) {
//                switch ($this->orderBy) {
//                    case 'city_asc':
//                        $baseQuery->join('localidades', 'tels.localidad_id', '=', 'localidades.id')
//                            ->orderBy('localidades.nombre', 'asc');
//                        break;
//                    case 'city_desc':
//                        $baseQuery->join('localidades', 'tels.localidad_id', '=', 'localidades.id')
//                            ->orderBy('localidades.nombre', 'desc');
//                        break;
//                    case 'state_asc':
//                        $baseQuery->join('localidades', 'tels.localidad_id', '=', 'localidades.id')
//                            ->join('provincias', 'localidades.provincia_id', '=', 'provincias.id')
//                            ->orderBy('provincias.nombre', 'asc');
//                        break;
//                    case 'state_desc':
//                        $baseQuery->join('localidades', 'tels.localidad_id', '=', 'localidades.id')
//                            ->join('provincias', 'localidades.provincia_id', '=', 'provincias.id')
//                            ->orderBy('provincias.nombre', 'desc');
//                        break;
//                }
//            }
            $totalRecords = $baseQuery->count();
            if ($this->quantity > $totalRecords) {
                $this->quantity = $totalRecords;
                \Log::info('Export quantity adjusted to actual records count', ['quantity' => $this->quantity]);
            }
            //only get the quantity of records needed
            $baseQuery->take($this->quantity);
            $fileName = "{$this->fileName}_" . now()->format('YmdHis') . ".xlsx";
            $filePath = $this->exportData($baseQuery, $fileName);
            $fileSize = Storage::disk('public')->size($filePath) / 1024; // Tamaño en KB

            $export->update([
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'job_ended_at' => Carbon::now(),
                'status' => 'creado'
            ]);

            event(new ExportCompleted($this->userId));
            Log::info('ExportTelefonosJob finalizado', ['filePath' => $filePath]);
        } catch (\Exception $e) {
            $export->update(['job_ended_at' => Carbon::now(), 'status' => 'fail']);
            Log::error('ExportTelefonosJob falló', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    private function exportData($baseQuery, $fileName)
    {
        $filePath = "exports/{$fileName}"; // Guardar en storage/app/public/exports
        Excel::store(new TelsExport($baseQuery), $filePath, 'public', ExcelExcel::XLSX);

        return Storage::disk('public')->path($filePath); // Devolver la ruta absoluta
    }
}
