<?php

namespace App\Exports;

use App\Models\Tel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldQueue;
use Illuminate\Support\Collection;


class TelsExport implements FromQuery, WithChunkReading, ShouldQueue
{
    use Exportable;

    public function query()
    {
        return Tel::query();
    }

    public function chunkSize(): int
    {
        return 10000; // Adjust chunk size as needed
    }
}
