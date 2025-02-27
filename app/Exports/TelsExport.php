<?php

namespace App\Exports;

use App\Models\Telefono;
use Couchbase\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
//use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TelsExport implements FromCollection, WithChunkReading, WithHeadings, WithMapping
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
            $tel->localidad->nombre,
        ];
    }

//    public function view(): ViewContract
//    {
//        return view('exports.telefonosSimplificado', [
//            'telefonos' => $this->data
//        ]);
//    }
}
