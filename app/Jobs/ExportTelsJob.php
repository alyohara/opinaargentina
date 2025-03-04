<?php

namespace App\Jobs;

use App\Models\Tel;
use App\Models\Localidad;
use App\Models\Export;
use App\Exports\TelsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExportTelsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $quantity;
    protected $userId;
    protected $fileName;
    protected $tipoTelefono;
    protected $chunkSize = 150000; // Adjust as needed

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($stateId, $cityId, $quantity, $userId, $fileName, $tipoTelefono)
    {
        $this->stateId = $stateId;
        $this->cityId = $cityId;
        $this->quantity = $quantity;
        $this->userId = $userId;
        $this->fileName = $fileName;
        $this->tipoTelefono = $tipoTelefono;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('max_execution_time', 7200);
        ini_set('memory_limit', '512M'); // Set memory limit to 512MB

        $query = Tel::query()->select('nro_telefono', 'localidad_id');

        if ($this->stateId) {
            $cityIds = Localidad::where('provincia_id', $this->stateId)->pluck('id');
            $query->whereIn('localidad_id', $cityIds);
        }

        if ($this->cityId) {
            $query->where('localidad_id', $this->cityId);
        }

        if ($this->tipoTelefono) {
            $query->where('tipo_telefono', $this->tipoTelefono);
        }

        // Add randomization
        $query->inRandomOrder();

        // Save export details as "procesando"
        $export = new Export();
        $export->file_path = $this->fileName;
        $export->user_id = $this->userId;
        $export->job_started_at = now();
        $export->status = 'procesando';
        $export->save();

        try {
            $writer = IOFactory::createWriter(new Spreadsheet(), 'Xlsx');
            $writer->setPreCalculateFormulas(false);
            $spreadsheet = $writer->getSpreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $rowIndex = 1;
            $query->chunkById(1000, function ($rows) use ($sheet, &$rowIndex) {
                foreach ($rows as $row) {
                    $sheet->fromArray($row->toArray(), null, 'A' . $rowIndex);
                    $rowIndex++;
                }
            });

            $writer->save(Storage::disk('public')->path($this->fileName));

            $export->file_size = Storage::disk('public')->size($this->fileName);
            $export->status = 'terminado';
        } catch (\Exception $e) {
            $export->status = 'error';
        }

        $export->job_ended_at = now();
        $export->save();
    }

    protected function mergeExcelFiles(array $filePaths, string $outputFileName)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0); // Remove the default sheet

        foreach ($filePaths as $filePath) {
            $fullFilePath = Storage::disk('public')->path($filePath);
            $reader = IOFactory::createReaderForFile($fullFilePath);
            $reader->setReadDataOnly(true);
            $tempSpreadsheet = $reader->load($fullFilePath);
            foreach ($tempSpreadsheet->getAllSheets() as $sheet) {
                $newSheet = clone $sheet;
                $spreadsheet->addSheet($newSheet);
            }
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $outputFullPath = Storage::disk('public')->path($outputFileName);
        $writer->save($outputFullPath);
    }
}
