<?php

namespace App\Exports;

use App\Models\Telefono;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TelsExport implements FromQuery, WithChunkReading, WithHeadings
{
    protected $stateId;
    protected $cityId;
    protected $quantity;

    public function __construct($stateId, $cityId, $quantity)
    {
        $this->stateId = $stateId;
        $this->cityId = $cityId;
        $this->quantity = $quantity;
    }

    public function query()
    {
        $query = Telefono::query();

        if ($this->stateId) {
            $query->where('state_id', $this->stateId);
        }

        if ($this->cityId) {
            $query->where('city_id', $this->cityId);
        }

        return $query->limit($this->quantity);
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size as needed
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
}
