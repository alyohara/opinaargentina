<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        $states = [
            ['name' => 'Buenos Aires', 'code' => 'BA', 'region' => 'Pampeana'],
            ['name' => 'Ciudad de Buenos Aires', 'code' => 'CABA', 'region' => 'CABA'],
            ['name' => 'Catamarca', 'code' => 'CA', 'region' => 'Noroeste'],
            ['name' => 'Chaco', 'code' => 'CH', 'region' => 'Noreste'],
            ['name' => 'Chubut', 'code' => 'CH', 'region' => 'Patagonia'],
            ['name' => 'Córdoba', 'code' => 'CB', 'region' => 'Centro'],
            ['name' => 'Corrientes', 'code' => 'CO', 'region' => 'Noreste'],
            ['name' => 'Entre Ríos', 'code' => 'ER', 'region' => 'Litoral'],
            ['name' => 'Formosa', 'code' => 'FO', 'region' => 'Noreste'],
            ['name' => 'Jujuy', 'code' => 'JY', 'region' => 'Noroeste'],
            ['name' => 'La Pampa', 'code' => 'LP', 'region' => 'Pampeana'],
            ['name' => 'La Rioja', 'code' => 'LR', 'region' => 'Noroeste'],
            ['name' => 'Mendoza', 'code' => 'MZ', 'region' => 'Cuyo'],
            ['name' => 'Misiones', 'code' => 'M', 'region' => 'Mesopotámica'],
            ['name' => 'Neuquén', 'code' => 'N', 'region' => 'Patagonia'],
            ['name' => 'Río Negro', 'code' => 'RN', 'region' => 'Patagonia'],
            ['name' => 'Salta', 'code' => 'SA', 'region' => 'Noroeste'],
            ['name' => 'San Juan', 'code' => 'SJ', 'region' => 'Cuyo'],
            ['name' => 'San Luis', 'code' => 'SL', 'region' => 'Cuyo'],
            ['name' => 'Santa Cruz', 'code' => 'SC', 'region' => 'Patagonia'],
            ['name' => 'Santa Fe', 'code' => 'SF', 'region' => 'Litoral'],
            ['name' => 'Santiago del Estero', 'code' => 'SE', 'region' => 'Noroeste'],
            ['name' => 'Tierra del Fuego', 'code' => 'TF', 'region' => 'Patagonia'],
            ['name' => 'Tucumán', 'code' => 'TU', 'region' => 'Noroeste'],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
