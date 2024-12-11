<?php

namespace App\Exports;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class TelsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $query;

    /**
     * Constructor to accept a query builder instance.
     *
     * @param Builder $query
     */
    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    /**
     * Query method for streaming data.
     *
     * @return Builder
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * Define the headings for the exported file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Telefono',
            'Localidad',
        ];
    }

    /**
     * Map each row of data to the desired format.
     *
     * @param mixed $telefono
     * @return array
     */
    public function map($telefono): array
    {
        $formattedData = [];

        if ($telefono->movil) {
            $formattedData[] = [
                'telefono' => $telefono->movil,
                'localidad' => $telefono->city->name ?? '',
            ];
        }

        if ($telefono->telefono) {
            $formattedData[] = [
                'telefono' => $telefono->telefono,
                'localidad' => $telefono->city->name ?? '',
            ];
        }

        // Handle cases where both "movil" and "telefono" exist
        return count($formattedData) > 0 ? reset($formattedData) : ['telefono' => '', 'localidad' => ''];
    }
}
