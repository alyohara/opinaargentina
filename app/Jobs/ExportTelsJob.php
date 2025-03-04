<?php

namespace App\Jobs;

use App\Models\Tel;
use App\Models\Localidad;
use App\Models\Export;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\DB;

class ExportTelsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $quantity;
    protected $userId;
    protected $fileName;
    protected $tipoTelefono;
<<<<<<< HEAD
    protected $chunkSize = 1000000; // Adjust as needed
=======
    protected $chunkSize = 150000; // Adjust as needed
>>>>>>> dac26ec (export job 0.6.4.1)

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

        // Save export details as "procesando"
        $export = new Export();
        $export->file_path = $this->fileName;
        $export->user_id = $this->userId;
        $export->job_started_at = now();
        $export->status = 'procesando';
        $export->save();

        try {
            if ($this->quantity <= $this->chunkSize) {
                //if is small enough to avoid problems, it runs as before.
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

                // Randomize the query
                $data = $query->inRandomOrder()->limit($this->quantity)->get();

                Excel::store(new \App\Exports\TelsExport($data), $this->fileName, 'public');
                $export->file_size = Storage::disk('public')->size($this->fileName);
                $export->status = 'terminado';
                $export->job_ended_at = now();
                $export->save();
                return;
            } else {
                $numChunks = ceil($this->quantity / $this->chunkSize);
                $baseFileName = pathinfo($this->fileName, PATHINFO_FILENAME);
                $extension = pathinfo($this->fileName, PATHINFO_EXTENSION);
                $tempFiles = [];

                for ($i = 0; $i < $numChunks; $i++) {
                    $offset = $i * $this->chunkSize;
                    //dispatch a job for every chunk
                    ExportTelChunkJob::dispatch($this->stateId, $this->cityId, $offset, $this->chunkSize, $this->userId, $baseFileName, $extension, $i, $this->tipoTelefono, true);
                    $tempFiles[] = "{$baseFileName}_part_{$i}.{$extension}";

                }
                //wait for all jobs to be finished
                $this->waitForChunkJobs($tempFiles);
                $this->mergeExcelFiles($tempFiles, $this->fileName);

                // Delete temp files
                foreach ($tempFiles as $tempFile) {
                    Storage::disk('public')->delete($tempFile);
                }

                $export->file_size = Storage::disk('public')->size($this->fileName);
                $export->status = 'terminado';
            }
        } catch (\Exception $e) {
            $export->status = 'error';

            // Delete temp files if there was an error
            if(isset($tempFiles)){
                foreach ($tempFiles as $tempFile) {
                    Storage::disk('public')->delete($tempFile);
                }
            }
        }

        $export->job_ended_at = now();
        $export->save();
    }
    protected function waitForChunkJobs($tempFiles)
    {
        // Check if all chunk files exist before proceeding
        while (true) {
            $allFilesExist = true;
            foreach ($tempFiles as $tempFile) {
                if (!Storage::disk('public')->exists($tempFile)) {
                    $allFilesExist = false;
                    break;
                }
            }

            if ($allFilesExist) {
                break; // All files exist, exit the loop
            }

            sleep(5); // Wait for 5 seconds before checking again
        }
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
