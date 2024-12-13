<?php
//namespace App\Jobs;
//
//use App\Exports\TelsExport;
//use App\Models\Export;
//use App\Models\Telefono;
//use App\Models\City;
//use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Foundation\Bus\Dispatchable;
//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Queue\SerializesModels;
//use Maatwebsite\Excel\Facades\Excel;
//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\Log;
//use ZipArchive;
//use Carbon\Carbon;
//use App\Events\ExportCompleted;
//
//class ExportTelefonosJob implements ShouldQueue
//{
//    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
//
//    protected $stateId;
//    protected $cityId;
//    protected $quantity;
//    protected $userId;
//
//    public $timeout = 1200;
//
//    public function __construct($stateId, $cityId, $quantity, $userId)
//    {
//        $this->stateId = $stateId;
//        $this->cityId = $cityId;
//        $this->quantity = $quantity;
//        $this->userId = $userId;
//    }
//
//    public function handle()
//    {
//        $export = Export::create([
//            'user_id' => $this->userId,
//            'job_started_at' => Carbon::now(),
//            'status' => 'in_progress',
//            'file_path' => '',
//            'file_size' => 0
//        ]);
//        Log::info('ExportTelefonosJob saved', ['exportId' => $export->id, 'job_started_at' => $export->job_started_at, 'status' => $export->status]);
//
//        Log::info('ExportTelefonosJob started', ['stateId' => $this->stateId, 'cityId' => $this->cityId, 'quantity' => $this->quantity, 'userId' => $this->userId]);
//
//        try {
//            $query = Telefono::query()->with(['city.state']);
//
//            if ($this->stateId) {
//                $cityIds = City::where('state_id', $this->stateId)->pluck('id');
//                $query->whereIn('city_id', $cityIds);
//            }
//
//            if ($this->cityId) {
//                $query->where('city_id', $this->cityId);
//            }
//
//            $fileNames = [];
//            if ($this->quantity > 20000) {
//                $chunks = ceil($this->quantity / 10000);
//
//                for ($i = 0; $i < $chunks; $i++) {
//                    $data = $query->skip($i * 10000)->take(10000)->get()->shuffle();
//                    $fileName = 'tels_export_' . now()->format('YmdHis') . '_part_' . ($i + 1) . '.xlsx';
//                    Excel::store(new TelsExport($data), $fileName, 'public');
//                    $fileNames[] = $fileName;
//                }
//
//                $zipFileName = 'tels_export_' . now()->format('YmdHis') . '.zip';
//                $zip = new ZipArchive;
//
//                if ($zip->open(storage_path('app/public/' . $zipFileName), ZipArchive::CREATE) === TRUE) {
//                    foreach ($fileNames as $file) {
//                        if (Storage::disk('public')->exists($file)) {
//                            $zip->addFile(storage_path('app/public/' . $file), $file);
//                        }
//                    }
//                    $zip->close();
//                }
//
//                foreach ($fileNames as $file) {
//                    Storage::disk('public')->delete($file);
//                }
//
//                $filePath = $zipFileName;
//                $fileSize = Storage::disk('public')->size($zipFileName) / 1024; // size in KB
//            } else {
//                $totalRecords = $query->count();
//                $randomStart = rand(0, max(0, $totalRecords - $this->quantity));
//                $data = $query->skip($randomStart)->take($this->quantity)->get();
//                $fileName = 'tels_export_' . now()->format('YmdHis') . '.xlsx';
//                Excel::store(new TelsExport($data), $fileName, 'public');
//                $filePath = $fileName;
//                $fileSize = Storage::disk('public')->size($fileName) / 1024; // size in KB
//            }
//
//            $export->update([
//                'file_path' => $filePath,
//                'file_size' => $fileSize,
//                'job_ended_at' => Carbon::now(),
//                'status' => 'creado'
//            ]);
//            event(new ExportCompleted($this->userId));
//
//            Log::info('ExportTelefonosJob completed successfully', ['filePath' => $filePath]);
//        } catch (\Exception $e) {
//            $export->update([
//                'job_ended_at' => Carbon::now(),
//                'status' => 'fail'
//            ]);
//
//            Log::error('ExportTelefonosJob failed', ['error' => $e->getMessage()]);
//            throw $e;
//        }
//    }
//}


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
use App\Events\ExportCompleted;

class ExportTelefonosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $quantity;
    protected $userId;
    protected $fileName;

    public $timeout = 1200;

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
            $query = Telefono::query()->with(['city.state']);

            if ($this->stateId) {
                $cityIds = City::where('state_id', $this->stateId)->pluck('id');
                $query->whereIn('city_id', $cityIds);
            }

            if ($this->cityId) {
                $query->where('city_id', $this->cityId);
            }

            $fileNames = [];
            $baseFileName = $this->fileName ?: 'tels_export';
            $timestamp = now()->format('YmdHis');

            if ($this->quantity > 20000) {
                $chunks = ceil($this->quantity / 10000);
                $allData = [];

                // make it in chunks



//                for ($i = 0; $i < $chunks; $i++) {
//                    $data = $query->skip($i * 10000)->take(10000)->get()->shuffle();
//                    $fileName = "{$baseFileName}_{$timestamp}_part_" . ($i + 1) . '.xlsx';
//                    Excel::store(new TelsExport($data), $fileName, 'public');
//                    $fileNames[] = $fileName;
//                    //$allData = array_merge($allData, $data->toArray());
//                }
//
//                $zipFileName = "{$baseFileName}_{$timestamp}.zip";
//                $zip = new ZipArchive;
//
//                if ($zip->open(storage_path('app/public/' . $zipFileName), ZipArchive::CREATE) === TRUE) {
//                    foreach ($fileNames as $file) {
//                        if (Storage::disk('public')->exists($file)) {
//                            $zip->addFile(storage_path('app/public/' . $file), $file);
//                        }
//                    }
//                    $zip->close();
//                }

                //$mergedFileName = "{$baseFileName}_{$timestamp}_merged.xlsx";
                //Excel::store(new TelsExport($allData), $mergedFileName, 'public');


//                foreach ($fileNames as $file) {
//                    Storage::disk('public')->delete($file);
//                }

                $allData = collect();

                for ($i = 0; $i < $chunks; $i++) {
                    $data = $query->skip($i * 10000)->take(10000)->get()->shuffle();
                    $allData = $allData->merge($data);
                }

                $fileName = "{$baseFileName}_{$timestamp}.xlsx";
                Excel::store(new TelsExport($allData), $fileName, 'public');
                $filePath = $fileName;
                $fileSize = Storage::disk('public')->size($fileName) / 1024; // size in KB

//                $filePath = $zipFileName;
//                $fileSize = Storage::disk('public')->size($zipFileName) / 1024; // size in KB
            } else {
                $totalRecords = $query->count();
                $randomStart = rand(0, max(0, $totalRecords - $this->quantity));
                $data = $query->skip($randomStart)->take($this->quantity)->get();
                $fileName = "{$baseFileName}_{$timestamp}.xlsx";
                Excel::store(new TelsExport($data), $fileName, 'public');
                $filePath = $fileName;
                $fileSize = Storage::disk('public')->size($fileName) / 1024; // size in KB
            }

            $export->update([
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'job_ended_at' => Carbon::now(),
                'status' => 'creado'
            ]);
            event(new ExportCompleted($this->userId));

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
