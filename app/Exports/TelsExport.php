<?php

namespace App\Exports;

use App\Models\Telefono;
use Maatwebsite\Excel\Concerns\FromCollection;

class TelsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Telefono::all()->where('state_id', 24);
    }
}
