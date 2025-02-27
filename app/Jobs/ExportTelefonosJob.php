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
use ZipArchive;
use Carbon\Carbon;
use App\Events\ExportCompleted;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
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

    public $timeout = 7200; // 2 horas

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

        \Log::info('ExportTelefonosJob iniciado', ['exportId' => $export->id]);

        try {
            $baseQuery = Tel::select('nro_telefono', 'localidad_id', 'id') // Add 'id' to the selection
            ->with('localidad')
                ->whereNotNull('nro_telefono')
                ->where('nro_telefono', '!=', '');

            if ($this->stateId && !$this->cityId) {
                $baseQuery->where('provincia_id', $this->stateId);
            } elseif ($this->cityId) {
                $baseQuery->where('localidad_id', $this->cityId);
            }
            if ($this->tipoTelefono) {
                $baseQuery->where('tipo_telefono', $this->tipoTelefono);
            }
            $totalRecords = $baseQuery->count();
            if ($this->quantity > $totalRecords) {
                $this->quantity = $totalRecords;
                \Log::info('Export quantity adjusted to actual records count', ['quantity' => $this->quantity]);
            }

            $filePath = $this->exportData($baseQuery, $totalRecords);
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

    private function exportData($baseQuery, $totalRecords)
    {
        $timestamp = now()->format('YmdHis');
        $fileNames = [];

        $query = clone $baseQuery;
        if ($this->quantity > 1000000) {
            $chunks = ceil($this->quantity / 1000);

            for ($i = 0; $i < $chunks; $i++) {
                $data = $query->skip($i * 1000)->take(1000)->get();
                $fileName = "{$this->fileName}_{$timestamp}_part_{$i}.xlsx";
                Excel::store(new TelsExport($data), $fileName, 'public');
                $fileNames[] = $fileName;
            }

            return $this->createZip($fileNames, $timestamp);
        } else {
            if ($this->quantity <= 1000) {
                $randomNumber = rand(0, 100000);
            } elseif ($this->quantity <= 10000) {
                $randomNumber = rand(0, 10000);
            } elseif ($this->quantity <= 100000) {
                $randomNumber = rand(0, 1000);
            } else {
                $randomNumber = rand(0, 100);
            }


            $query->chunk(1000, function ($data) use (&$fileNames, $timestamp) {
                $fileName = "{$this->fileName}_{$timestamp}_part_" . count($fileNames) . ".xlsx";
                Excel::store(new TelsExport($data), $fileName, 'public');
                $fileNames[] = $fileName;
            });

            return $this->mergeExcelFiles($fileNames, $timestamp);
            // here i want to put a random number between 0 and 100
            // if quantity is between 0 and 1000, the random must be between 0 and 100000;
            // if quantity is between 1000 and 10000, the random must be between 0 and 10000;
            // if quantity is between 10000 and 100000, the random must be between 0 and 1000;
            // if quantity is between 100000 and 1000000, the random must be between 0 and 100;
//            if ($this->quantity <= 1000) {
//                $randomNumber = rand(0, 100000);
//            } elseif ($this->quantity <= 10000) {
//                $randomNumber = rand(0, 10000);
//            } elseif ($this->quantity <= 100000) {
//                $randomNumber = rand(0, 1000);
//            } else {
//                $randomNumber = rand(0, 100);
//            }
//            // use this random number to move the start of the query
//            $query = $query->skip($randomNumber % $totalRecords);
//
//            $data = $query->take($this->quantity)->get();
//            $fileName = "{$this->fileName}_{$timestamp}.xlsx";
//            Excel::store(new TelsExport($data), $fileName, 'public');
//            return $fileName;
        }
    }

    private function mergeExcelFiles($fileNames, $timestamp)
    {
        $spreadsheet = new Spreadsheet();
        $masterSheet = $spreadsheet->getActiveSheet();
        $currentRow = 1;

        foreach ($fileNames as $file) {
            $filePath = storage_path("app/public/{$file}");

            if (!Storage::disk('public')->exists($file)) {
                continue;
            }

            $spreadsheetPart = IOFactory::load($filePath);
            $sheet = $spreadsheetPart->getActiveSheet();
            $data = $sheet->toArray();

            // Omitir encabezados después del primer archivo
            if ($currentRow > 1) {
                array_shift($data);
            }

            // Escribir en la hoja maestra
            foreach ($data as $row) {
                $masterSheet->fromArray($row, null, "A{$currentRow}");
                $currentRow++;
            }

            // Borrar el archivo parcial
            Storage::disk('public')->delete($file);
        }

        // Guardar el archivo final
        $finalFileName = "{$this->fileName}_{$timestamp}.xlsx";
        $finalFilePath = storage_path("app/public/{$finalFileName}");
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($finalFilePath);

        return $finalFileName;
    }

    private function createZip($fileNames, $timestamp)
    {
        $zipFileName = "{$this->fileName}_{$timestamp}.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($fileNames as $file) {
                $filePath = storage_path("app/public/{$file}");
                if (Storage::disk('public')->exists($file)) {
                    $zip->addFile($filePath, $file);
                }
            }
            $zip->close();
        }

        foreach ($fileNames as $file) {
            Storage::disk('public')->delete($file);
        }

        return $zipFileName;
    }
}
