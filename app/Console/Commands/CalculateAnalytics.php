<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Telefono;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Role;
use App\Models\Analytics;

class CalculateAnalytics extends Command
{
    protected $signature = 'analytics:calculate';
    protected $description = 'Calculate and store daily analytics data';

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
