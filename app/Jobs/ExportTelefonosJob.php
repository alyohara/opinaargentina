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

    public $timeout = 1200;

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
            $query = Telefono::query()->select('id')->with(['city.state']);

            if ($this->stateId) {
                $cityIds = City::where('state_id', $this->stateId)->pluck('id');
                $query->whereIn('city_id', $cityIds);
            }

            if ($this->cityId) {
                $query->where('city_id', $this->cityId);
            }

            $totalRecords = $query->count();
            $selectedIds = $query->inRandomOrder()->take($this->quantity)->pluck('id');

            $fileNames = [];
            $chunkSize = 10000;
            $chunks = ceil($this->quantity / $chunkSize);

            for ($i = 0; $i < $chunks; $i++) {
                $chunkIds = $selectedIds->slice($i * $chunkSize, $chunkSize);
                $data = Telefono::whereIn('id', $chunkIds)->with(['city.state'])->get();

                $fileName = 'tels_export_' . now()->format('YmdHis') . '_part_' . ($i + 1) . '.xlsx';
                Excel::store(new TelsExport($data), $fileName, 'public');
                $fileNames[] = $fileName;
            }

            $zipFileName = 'tels_export_' . now()->format('YmdHis') . '.zip';
            $zip = new ZipArchive;

            if ($zip->open(storage_path('app/public/' . $zipFileName), ZipArchive::CREATE) === TRUE) {
                foreach ($fileNames as $file) {
                    if (Storage::disk('public')->exists($file)) {
                        $zip->addFile(storage_path('app/public/' . $file), $file);
                    }
                }
                $zip->close();
            }

            foreach ($fileNames as $file) {
                Storage::disk('public')->delete($file);
            }

            $filePath = $zipFileName;
            $fileSize = Storage::disk('public')->size($zipFileName) / 1024; // size in KB

            $export->update([
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'job_ended_at' => Carbon::now(),
                'status' => 'creado'
            ]);

            Log::info('ExportTelefonosJob completed successfully', ['filePath' => $filePath]);
        } catch (\Exception $e) {
            $export->update([
                'job_ended_at' => Carbon::now(),
                'status' => 'fail'
            ]);

            Log::error('ExportTelefonosJob failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
