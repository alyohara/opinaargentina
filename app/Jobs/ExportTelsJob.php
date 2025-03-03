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

class ExportTelsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $quantity;
    protected $userId;
    protected $fileName;
    protected $tipoTelefono;
    protected $chunkSize = 10000; // Adjust as needed


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
        $query->limit($this->quantity);
        $data = $query->get();
// Save export details as "procesando"
        $export = new Export();
        $export->file_path = $this->fileName;
        $export->user_id = $this->userId;
        $export->job_started_at = now();
        $export->status = 'procesando';
        $export->save();

        $tempFiles = [];
        $finalPath = 'public/' . $this->fileName;
        $data->chunk($this->chunkSize)->each(function ($chunk, $index) use ($tempFiles) {
            $tempFileName = 'temp/' . $this->fileName . '_' . $index . '.xlsx';
            Excel::store(new TelsExport($chunk), $tempFileName, 'public');
            $tempFiles[] = $tempFileName;
        });

        try {
            Excel::store(new TelsExport($data), $this->fileName, 'public');
            $export->file_size = Storage::disk('public')->size($this->fileName);
            $export->status = 'terminado';
        } catch (\Exception $e) {
            $export->status = 'error';
        }

        $export->job_ended_at = now();
        $export->save();
    }
}
