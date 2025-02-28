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

class ExportTelefonosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $quantity;
    protected $userId;
    protected $fileName;
    protected $tipoTelefono;

    public $timeout = 7200; // 2 hours
    //public $tries = 5; // Maximum number of attempts

    public function __construct($stateId, $cityId, $quantity, $userId, $fileName = null, $tipoTelefono = null)
    {
        $this->stateId = $stateId;
        $this->cityId = $cityId;
        $this->quantity = $quantity;
        $this->userId = $userId;
        $this->fileName = $fileName ?: 'tels_export';
        $this->tipoTelefono = $tipoTelefono;
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

        Log::info('ExportTelefonosJob iniciado', ['exportId' => $export->id]);

        try {
            $baseQuery = Tel::query();
            $baseQuery->with('localidad.provincia')
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

            $totalRecords = $baseQuery->count();
            if ($this->quantity > $totalRecords) {
                $this->quantity = $totalRecords;
                Log::info('Export quantity adjusted to actual records count', ['quantity' => $this->quantity]);
            }

            $fileName = "{$this->fileName}_" . now()->format('YmdHis') . ".xlsx";
            $filePath = $this->exportData($baseQuery, $fileName, $this->quantity);
            $fileSize = Storage::disk('public')->size($filePath) / 1024; // Size in KB

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

    private function exportData($baseQuery, $fileName, $quantity)
    {
        $filePath = "exports/{$fileName}";
        $export = new TelsExport($baseQuery->limit($quantity));
        Excel::store($export, $filePath, 'public');

        return $filePath;
    }
}
