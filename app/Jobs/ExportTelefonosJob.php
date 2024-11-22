<?php
namespace App\Jobs;

use App\Exports\TelsExport;
use App\Models\Export;
use App\Models\Telefono;
use App\Models\City;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Carbon\Carbon;

class ExportTelefonosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $quantity;
    protected $userId;

    public $timeout = 12000;

    public function __construct($stateId, $cityId, $quantity, $userId)
    {
        $this->stateId = $stateId;
        $this->cityId = $cityId;
        $this->quantity = $quantity;
        $this->userId = $userId;
    }

    public function handle()
    {
        $export = Export::create([
            'user_id' => $this->userId,
            'job_started_at' => Carbon::now(),
            'status' => 'in_progress',
            'file_path' => '',
            'file_size' => 0
        ]);
        Log::info('ExportTelefonosJob saved', ['exportId' => $export->id, 'job_started_at' => $export->job_started_at, 'status' => $export->status]);

        Log::info('ExportTelefonosJob started', ['stateId' => $this->stateId, 'cityId' => $this->cityId, 'quantity' => $this->quantity, 'userId' => $this->userId]);

        try {
            // Filtrar por estado y ciudad si es necesario
            $query = Telefono::query()->with(['city.state']);

            if ($this->stateId) {
                $cityIds = City::where('state_id', $this->stateId)->pluck('id');
                $query->whereIn('city_id', $cityIds);
            }

            if ($this->cityId) {
                $query->where('city_id', $this->cityId);
            }

            // Obtener los datos
            $data = $query->inRandomOrder()->limit($this->quantity)->get();

            // Exportar los datos
            if ($data->count() > 10000) {
                // Lógica para manejar grandes cantidades de datos (dividir en chunks y comprimir)
                // ...
            } else {
                // Exportación directa si la cantidad es manejable
                $fileName = 'tels_export_' . now()->format('YmdHis') . '.xlsx';
                Excel::store(new TelsExport($data), $fileName, 'public');
                $filePath = $fileName;
                $fileSize = Storage::disk('public')->size($fileName) / 1024; // size in KB
            }

            // Actualizar el registro de exportación
            $export->update([
                'file_path' => isset($filePath) ? $filePath : '',
                'file_size' => isset($fileSize) ? $fileSize : 0,
                'job_ended_at' => Carbon::now(),
                'status' => 'creado'
            ]);

            Log::info('ExportTelefonosJob completed successfully', ['filePath' => isset($filePath) ? $filePath : '']);
        } catch (\Exception $e) {
            // Manejo de errores
            $export->update([
                'job_ended_at' => Carbon::now(),
                'status' => 'fail'
            ]);

            Log::error('ExportTelefonosJob failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
