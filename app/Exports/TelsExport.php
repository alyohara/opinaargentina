<?php

namespace App\Exports;

use App\Models\Telefono;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;
class TelsExport implements FromQuery, WithChunkReading, WithHeadings, WithMapping
{
    protected $query;
    protected $quantity;

    public function __construct($query, $quantity)
    {
        $this->query = $query;
        $this->quantity = $quantity;
    }

    public function query()
    {
        return $this->query->limit($this->quantity);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function headings(): array
    {
        return [
            'Teléfono',
            'Móvil',
            'Ciudad',
            'Provincia',
        ];
    }

    public function map($telefono): array
    {
        return [
            $telefono->telefono,
            $telefono->movil,
            $telefono->city->name,
            $telefono->city->state->name,
        ];
    }
}
