<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        $states = [
            ['id' => 1, 'name' => 'Buenos Aires', 'code' => 'BA', 'region' => 'Pampeana'],
            ['id' => 2, 'name' => 'Ciudad de Buenos Aires', 'code' => 'CABA', 'region' => 'CABA'],
            ['id' => 3, 'name' => 'Catamarca', 'code' => 'CA', 'region' => 'Noroeste'],
            ['id' => 4, 'name' => 'Chaco', 'code' => 'CH', 'region' => 'Noreste'],
            ['id' => 5, 'name' => 'Chubut', 'code' => 'CH', 'region' => 'Patagonia'],
            ['id' => 6, 'name' => 'Córdoba', 'code' => 'CB', 'region' => 'Centro'],
            ['id' => 7, 'name' => 'Corrientes', 'code' => 'CO', 'region' => 'Noreste'],
            ['id' => 8, 'name' => 'Entre Ríos', 'code' => 'ER', 'region' => 'Litoral'],
            ['id' => 9, 'name' => 'Formosa', 'code' => 'FO', 'region' => 'Noreste'],
            ['id' => 10, 'name' => 'Jujuy', 'code' => 'JY', 'region' => 'Noroeste'],
            ['id' => 11, 'name' => 'La Pampa', 'code' => 'LP', 'region' => 'Pampeana'],
            ['id' => 12, 'name' => 'La Rioja', 'code' => 'LR', 'region' => 'Noroeste'],
            ['id' => 13, 'name' => 'Mendoza', 'code' => 'MZ', 'region' => 'Cuyo'],
            ['id' => 14, 'name' => 'Misiones', 'code' => 'M', 'region' => 'Mesopotámica'],
            ['id' => 15, 'name' => 'Neuquén', 'code' => 'N', 'region' => 'Patagonia'],
            ['id' => 16, 'name' => 'Río Negro', 'code' => 'RN', 'region' => 'Patagonia'],
            ['id' => 17, 'name' => 'Salta', 'code' => 'SA', 'region' => 'Noroeste'],
            ['id' => 18, 'name' => 'San Juan', 'code' => 'SJ', 'region' => 'Cuyo'],
            ['id' => 19, 'name' => 'San Luis', 'code' => 'SL', 'region' => 'Cuyo'],
            ['id' => 20, 'name' => 'Santa Cruz', 'code' => 'SC', 'region' => 'Patagonia'],
            ['id' => 21, 'name' => 'Santa Fe', 'code' => 'SF', 'region' => 'Litoral'],
            ['id' => 22, 'name' => 'Santiago del Estero', 'code' => 'SE', 'region' => 'Noroeste'],
            ['id' => 23, 'name' => 'Tierra del Fuego', 'code' => 'TF', 'region' => 'Patagonia'],
            ['id' => 24, 'name' => 'Tucumán', 'code' => 'TU', 'region' => 'Noroeste'],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
