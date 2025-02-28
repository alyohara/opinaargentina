<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class TelsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $query;
    protected $quantity;

    public function __construct(Builder $query, int $quantity)
    {
        $this->query = $query;
        $this->quantity = $quantity;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'nro_telefono',
            'localidad'
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
