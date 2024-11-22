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

        Log::info('ExportTelefonosJob started', ['stateId' => $this->stateId, 'cityId' => $this->cityId, 'quantity' => $this->quantity, 'userId' => $this->userId]);

        try {
            $query = Telefono::query()->with(['city.state']);

            if ($this->stateId) {
                $cityIds = City::where('state_id', $this->stateId)->pluck('id');
                $query->whereIn('city_id', $cityIds);
            }

            if ($this->cityId) {
                $query->where('city_id', $this->cityId);
            }

            if ($this->quantity) {
                $query->inRandomOrder()->limit($this->quantity);
            }

            if ($this->quantity > 10000) {
                // Procesar en chunks
                $filePaths = [];
                $chunkSize = 10000;
                $chunkIndex = 1;

                $query->chunk($chunkSize, function ($rows) use (&$filePaths, &$chunkIndex) {
                    $fileName = 'tels_export_chunk_' . $chunkIndex . '_' . now()->format('YmdHis') . '.xlsx';
                    Excel::store(new TelsExport($rows), $fileName, 'public');
                    $filePaths[] = $fileName;
                    $chunkIndex++;
                });

                // Crear archivo ZIP
                $zipFileName = 'tels_export_' . now()->format('YmdHis') . '.zip';
                $zipFilePath = storage_path('app/public/' . $zipFileName);
                $zip = new ZipArchive();

                if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
                    foreach ($filePaths as $filePath) {
                        $zip->addFile(storage_path('app/public/' . $filePath), basename($filePath));
                    }
                    $zip->close();
                }

                // Eliminar archivos individuales
                foreach ($filePaths as $filePath) {
                    Storage::disk('public')->delete($filePath);
                }

                $filePath = $zipFileName;
                $fileSize = Storage::disk('public')->size($zipFileName) / 1024; // KB
            } else {
                // Exportar directamente
                $data = $query->get();
                $fileName = 'tels_export_' . now()->format('YmdHis') . '.xlsx';
                Excel::store(new TelsExport($data), $fileName, 'public');
                $filePath = $fileName;
                $fileSize = Storage::disk('public')->size($fileName) / 1024; // KB
            }

            $export->update([
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'job_ended_at' => Carbon::now(),
                'status' => 'created'
            ]);

            Log::info('ExportTelefonosJob completed successfully', ['filePath' => $filePath]);
        } catch (\Exception $e) {
            $export->update([
                'job_ended_at' => Carbon::now(),
                'status' => 'failed'
            ]);

            Log::error('ExportTelefonosJob failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
