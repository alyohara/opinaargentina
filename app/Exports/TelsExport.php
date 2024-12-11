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
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Database\Eloquent\Builder;

class TelsExport implements FromView
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

//    public function headings(): array
//    {
//        return [
//            'Telefono',
//            'Localidad',
//        ];
//    }
//
//    public function map($telefono): array
//    {
//        return [
//            $telefono->telefono,
//            $telefono->city->name,
//        ];
//    }

    public function view(): ViewContract
    {
        $formattedData = [];

        foreach ($this->data as $telefono) {
            if ($telefono->movil) {
                $formattedData[] = [
                    'telefono' => $telefono->movil,
                    'localidad' => $telefono->city->name,
                ];
            }
            if ($telefono->telefono) {
                $formattedData[] = [
                    'telefono' => $telefono->telefono,
                    'localidad' => $telefono->city->name,
                ];
            }
        }

        return view('exports.telefonosSimplificado', [
            'telefonos' => $formattedData
        ]);
    }
}
