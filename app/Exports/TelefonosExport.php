<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TelefonosExport implements FromView
{
    protected $telefonos;

    public function __construct($telefonos)
    {
        $this->telefonos = $telefonos;
    }

    public function view(): View
    {
        return view('exports.telefonos', ['telefonos' => $this->telefonos]);
    }
}
