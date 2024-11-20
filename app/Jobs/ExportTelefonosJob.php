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

class ExportTelefonosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $quantity;
    protected $userId;

    // Set the timeout to 20 minutes (1200 seconds)
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

            $fileNames = [];
            if ($this->quantity > 10000) {
                $chunks = ceil($this->quantity / 10000);

                for ($i = 0; $i < $chunks; $i++) {
                    $data = $query->skip($i * 10000)->take(10000)->get();
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

                $filePath = 'storage/' . $zipFileName;
            } else {
                $data = $query->limit($this->quantity)->get();
                $fileName = 'tels_export_' . now()->format('YmdHis') . '.xlsx';
                Excel::store(new TelsExport($data), $fileName, 'public');
                $filePath = 'storage/' . $fileName;
            }

            Export::create([
                'file_path' => $filePath,
                'user_id' => $this->userId,
            ]);

            Log::info('ExportTelefonosJob completed successfully', ['filePath' => $filePath]);
        } catch (\Exception $e) {
            Log::error('ExportTelefonosJob failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
