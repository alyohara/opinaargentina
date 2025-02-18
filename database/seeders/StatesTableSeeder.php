<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('states')->delete();
        
        \DB::table('states')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Buenos Aires',
                'code' => 'BA',
                'region' => 'Pampeana',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Ciudad Autónoma de Buenos Aires',
                'code' => 'CABA',
                'region' => 'CABA',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Catamarca',
                'code' => 'CA',
                'region' => 'Noroeste',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Chaco',
                'code' => 'CH',
                'region' => 'Noreste',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Chubut',
                'code' => 'CH',
                'region' => 'Patagonia',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Córdoba',
                'code' => 'CB',
                'region' => 'Centro',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Corrientes',
                'code' => 'CO',
                'region' => 'Noreste',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Entre Ríos',
                'code' => 'ER',
                'region' => 'Litoral',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Formosa',
                'code' => 'FO',
                'region' => 'Noreste',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Jujuy',
                'code' => 'JY',
                'region' => 'Noroeste',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'La Pampa',
                'code' => 'LP',
                'region' => 'Pampeana',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'La Rioja',
                'code' => 'LR',
                'region' => 'Noroeste',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Mendoza',
                'code' => 'MZ',
                'region' => 'Cuyo',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Misiones',
                'code' => 'M',
                'region' => 'Mesopotámica',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Neuquén',
                'code' => 'N',
                'region' => 'Patagonia',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Río Negro',
                'code' => 'RN',
                'region' => 'Patagonia',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Salta',
                'code' => 'SA',
                'region' => 'Noroeste',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'San Juan',
                'code' => 'SJ',
                'region' => 'Cuyo',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'San Luis',
                'code' => 'SL',
                'region' => 'Cuyo',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Santa Cruz',
                'code' => 'SC',
                'region' => 'Patagonia',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Santa Fe',
                'code' => 'SF',
                'region' => 'Litoral',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Santiago del Estero',
                'code' => 'SE',
                'region' => 'Noroeste',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Tierra del Fuego',
                'code' => 'TF',
                'region' => 'Patagonia',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Tucumán',
                'code' => 'TU',
                'region' => 'Noroeste',
                'created_at' => '2024-11-05 11:36:02',
                'updated_at' => '2024-11-05 11:36:02',
            ),
        ));
        
        
    }
}