<?php

namespace App\Jobs;

use App\Models\Tel;
use App\Models\Localidad;
use App\Exports\TelsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExportTelChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $offset;
    protected $chunkSize;
    protected $userId;
    protected $baseFileName;
    protected $extension;
    protected $chunkIndex;
    protected $tipoTelefono;
    protected $randomOrder;

    public function __construct($stateId, $cityId, $offset, $chunkSize, $userId, $baseFileName, $extension, $chunkIndex, $tipoTelefono, $randomOrder = false)
    {
        $this->stateId = $stateId;
        $this->cityId = $cityId;
        $this->offset = $offset;
        $this->chunkSize = $chunkSize;
        $this->userId = $userId;
        $this->baseFileName = $baseFileName;
        $this->extension = $extension;
        $this->chunkIndex = $chunkIndex;
        $this->tipoTelefono = $tipoTelefono;
        $this->randomOrder = $randomOrder;
    }

    public function handle()
    {
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

        // Apply random order if needed
        if ($this->randomOrder) {
            $query->inRandomOrder();
        }

        $chunkData = $query->skip($this->offset)->take($this->chunkSize)->get();
        $tempFileName = "{$this->baseFileName}_part_{$this->chunkIndex}.{$this->extension}";
        Excel::store(new TelsExport($chunkData), $tempFileName, 'public');
    }
}
