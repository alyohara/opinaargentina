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
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Events\ExportCompleted;

class ExportTelefonosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $quantity;
    protected $userId;
    protected $fileName;

    public $timeout = 3600; // 1 hour

    public function __construct($stateId, $cityId, $quantity, $userId, $fileName = null)
    {
        $this->stateId = $stateId;
        $this->cityId = $cityId;
        $this->quantity = $quantity;
        $this->userId = $userId;
        $this->fileName = $fileName;
    }

    public function handle()
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(3600); // 1 hour

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
            $query = Telefono::query()->with(['city.state' => function ($query) {
                $query->select('id', 'name');
            }]);

            if ($this->stateId) {
                $cityIds = City::where('state_id', $this->stateId)->pluck('id');
                $query->whereIn('city_id', $cityIds);
            }

            if ($this->cityId) {
                $query->where('city_id', $this->cityId);
            }

            $baseFileName = $this->fileName ?: 'tels_export';
            $timestamp = now()->format('YmdHis');
            $fileName = "{$baseFileName}_{$timestamp}.xlsx";

            $totalRecords = $query->count();
            $chunkSize = 1000;
            $progress = 0;

            $query->chunk($chunkSize, function ($data) use (&$progress, $fileName) {
                Excel::store(
                    new TelsExport($data),
                    $fileName,
                    'public',
                    \Maatwebsite\Excel\Excel::XLSX
                );
                $progress += count($data);
                Log::info('ExportTelefonosJob progress', ['progress' => $progress]);
            });

            $filePath = $fileName;
            $fileSize = Storage::disk('public')->size($fileName) / 1024; // size in KB

            $export->update([
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'job_ended_at' => Carbon::now(),
                'status' => 'creado'
            ]);
            event(new ExportCompleted($this->userId));

            Log::info('ExportTelefonosJob completed successfully', ['filePath' => $filePath]);
        } catch (\Exception $e) {
            Log::error('ExportTelefonosJob failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $export->update([
                'job_ended_at' => Carbon::now(),
                'status' => 'fail',
                'error_message' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
