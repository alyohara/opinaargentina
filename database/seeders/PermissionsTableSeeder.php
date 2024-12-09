<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'alta_usuario',
                'created_at' => '2024-12-09 12:14:49',
                'updated_at' => '2024-12-09 12:14:49',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'baja_usuario',
                'created_at' => '2024-12-09 12:15:00',
                'updated_at' => '2024-12-09 12:15:00',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'modificacion_usuario',
                'created_at' => '2024-12-09 12:15:11',
                'updated_at' => '2024-12-09 12:15:11',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'vista_usuario',
                'created_at' => '2024-12-09 12:15:24',
                'updated_at' => '2024-12-09 12:15:24',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'alta_rol',
                'created_at' => '2024-12-09 12:15:34',
                'updated_at' => '2024-12-09 12:15:34',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'baja_rol',
                'created_at' => '2024-12-09 12:15:42',
                'updated_at' => '2024-12-09 12:15:42',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'modificacion_rol',
                'created_at' => '2024-12-09 12:15:51',
                'updated_at' => '2024-12-09 12:15:51',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'vista_rol',
                'created_at' => '2024-12-09 12:15:56',
                'updated_at' => '2024-12-09 12:15:56',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'alta_permiso',
                'created_at' => '2024-12-09 12:16:08',
                'updated_at' => '2024-12-09 12:16:08',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'baja_permiso',
                'created_at' => '2024-12-09 12:16:20',
                'updated_at' => '2024-12-09 12:16:20',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'modificacion_permiso',
                'created_at' => '2024-12-09 12:16:27',
                'updated_at' => '2024-12-09 12:16:27',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'vista_permiso',
                'created_at' => '2024-12-09 12:16:36',
                'updated_at' => '2024-12-09 12:16:36',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'alta_equipo',
                'created_at' => '2024-12-09 12:22:08',
                'updated_at' => '2024-12-09 12:22:08',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'baja_equipo',
                'created_at' => '2024-12-09 12:22:14',
                'updated_at' => '2024-12-09 12:22:14',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'modificacion_equipo',
                'created_at' => '2024-12-09 12:22:27',
                'updated_at' => '2024-12-09 12:22:27',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'vista_equipo',
                'created_at' => '2024-12-09 12:22:40',
                'updated_at' => '2024-12-09 12:22:40',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'alta_provincia',
                'created_at' => '2024-12-09 12:22:54',
                'updated_at' => '2024-12-09 12:22:54',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'baja_provincia',
                'created_at' => '2024-12-09 12:23:01',
                'updated_at' => '2024-12-09 12:23:01',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'modificacion_provincia',
                'created_at' => '2024-12-09 12:23:16',
                'updated_at' => '2024-12-09 12:23:16',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'vista_provincia',
                'created_at' => '2024-12-09 12:26:05',
                'updated_at' => '2024-12-09 12:26:05',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'alta_ciudad',
                'created_at' => '2024-12-09 12:26:16',
                'updated_at' => '2024-12-09 12:26:16',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'baja_ciudad',
                'created_at' => '2024-12-09 12:26:21',
                'updated_at' => '2024-12-09 12:26:21',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'modificacion_ciudad',
                'created_at' => '2024-12-09 12:26:29',
                'updated_at' => '2024-12-09 12:26:29',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'vista_ciudad',
                'created_at' => '2024-12-09 12:26:42',
                'updated_at' => '2024-12-09 12:26:42',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'alta_persona',
                'created_at' => '2024-12-09 12:26:58',
                'updated_at' => '2024-12-09 12:26:58',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'baja_persona',
                'created_at' => '2024-12-09 12:27:05',
                'updated_at' => '2024-12-09 12:27:05',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'modificacion_persona',
                'created_at' => '2024-12-09 12:27:14',
                'updated_at' => '2024-12-09 12:27:14',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'vista_persona',
                'created_at' => '2024-12-09 12:27:19',
                'updated_at' => '2024-12-09 12:27:19',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'alta_telefono',
                'created_at' => '2024-12-09 12:28:09',
                'updated_at' => '2024-12-09 12:28:09',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'baja_telefono',
                'created_at' => '2024-12-09 12:28:18',
                'updated_at' => '2024-12-09 12:28:18',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'modificacion_telefono',
                'created_at' => '2024-12-09 12:28:31',
                'updated_at' => '2024-12-09 12:28:31',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'vista_telefono',
                'created_at' => '2024-12-09 12:28:50',
                'updated_at' => '2024-12-09 12:29:03',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'exportar_archivos',
                'created_at' => '2024-12-09 12:34:26',
                'updated_at' => '2024-12-09 12:34:26',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'ver_archivos_exportados',
                'created_at' => '2024-12-09 12:34:39',
                'updated_at' => '2024-12-09 12:34:39',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'eliminar_archivos_exportados',
                'created_at' => '2024-12-09 12:34:57',
                'updated_at' => '2024-12-09 12:34:57',
            ),
        ));
        
        
    }
}