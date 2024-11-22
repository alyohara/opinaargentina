<?php

namespace App\Exports;

use App\Models\Telefono;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Database\Eloquent\Builder;

class TelsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
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
