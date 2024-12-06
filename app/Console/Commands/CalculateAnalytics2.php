<?php

namespace App\Console\Commands;

use App\Models\Analytics;
use App\Models\Telefono;
use App\Models\User;
use Illuminate\Console\Command;

class CalculateAnalytics2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-analytics2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store daily analytics data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $totalTelefonos = Telefono::count();
        $totalUsuarios = User::count();

        $telefonosPorProvincia = Telefono::selectRaw('states.name as provincia, count(*) as total')
            ->join('cities', 'telefonos.city_id', '=', 'cities.id')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->groupBy('states.name')
            ->pluck('total', 'provincia');

        $usuariosPorRol = User::selectRaw('roles.name as rol, count(*) as total')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->groupBy('roles.name')
            ->pluck('total', 'rol');

        $localidadConMasTelefonos = Telefono::selectRaw('cities.name as localidad, count(*) as total')
            ->join('cities', 'telefonos.city_id', '=', 'cities.id')
            ->groupBy('cities.name')
            ->orderByDesc('total')
            ->first()
            ->localidad;

        $rankingProvincias = Telefono::selectRaw('states.name as provincia, count(*) as total')
            ->join('cities', 'telefonos.city_id', '=', 'cities.id')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->groupBy('states.name')
            ->orderByDesc('total')
            ->pluck('total', 'provincia');

        Analytics::create([
            'total_telefonos' => $totalTelefonos,
            'total_usuarios' => $totalUsuarios,
            'telefonos_por_provincia' => $telefonosPorProvincia,
            'usuarios_por_rol' => $usuariosPorRol,
            'localidad_con_mas_telefonos' => $localidadConMasTelefonos,
            'ranking_provincias' => $rankingProvincias,
        ]);

        $this->info('Analytics data calculated and stored successfully.');
    }
}
