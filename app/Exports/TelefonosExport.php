<?php
namespace App\Exports;

use App\Models\Telefono;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TelefonosExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Telefono::with(['city.state']);

        if ($this->request->has('state') && $this->request->state != '') {
            $cityIds = City::where('state_id', $this->request->state)->pluck('id');
            $query->whereIn('city_id', $cityIds);
        }

        if ($this->request->has('city') && $this->request->city != '') {
            $query->where('city_id', $this->request->city);
        }

        return $query->get();
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
