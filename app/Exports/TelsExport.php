<?php
namespace App\Exports;

use App\Models\Tel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Database\Eloquent\Builder;

class TelsExport implements FromQuery, WithChunkReading, WithHeadings, WithMapping
{
    use Exportable;

    protected $query;
    protected $quantity;

    public function __construct(Builder $query, int $quantity)
    {
        $this->query = $query;
        $this->quantity = $quantity;
    }

    public function query()
    {
        return $this->query->take($this->quantity);
    }

    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time
    }

    public function headings(): array
    {
        return [
            'nro_telefono',
            'localidad',
        ];
    }

    public function map($tel): array
    {
        return [
            $tel->nro_telefono,
            $tel->localidad->nombre ?? '',
        ];
    }
}
