<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin_it',
                'created_at' => '2024-12-09 13:43:54',
                'updated_at' => '2024-12-09 13:43:54',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'admin',
                'created_at' => '2024-12-09 13:44:47',
                'updated_at' => '2024-12-09 13:44:47',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'team_leader',
                'created_at' => '2024-12-09 13:45:34',
                'updated_at' => '2024-12-09 13:45:34',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'supervisor',
                'created_at' => '2024-12-09 13:46:16',
                'updated_at' => '2024-12-09 13:46:16',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'operator',
                'created_at' => '2024-12-09 13:46:35',
                'updated_at' => '2024-12-09 13:46:35',
            ),
        ));
        
        
    }
}