<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;


class TelsExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'nro_telefono' => $item->nro_telefono,
                'localidad_id' => $item->localidad_id,
            ];
        });
    }
    public function headings(): array
    {
        return [
            'nro_telefono',
            'localidad_id',
        ];
    }
}
