<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tel;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Role;
use App\Models\Analytics;
use App\Models\Provincia;
use App\Models\Localidad;


class CalculateAnalytics extends Command
{
    protected $signature = 'analytics:calculate';
    protected $description = 'Calculate and store daily analytics data';

    public function handle()
    {
        $totalTelefonos = Tel::count();
        $totalUsuarios = User::count();

        $telefonosPorProvincia = Tel::selectRaw('provincias.nombre as provincia, count(*) as total')
            ->join('localidades', 'tels.localidad_id', '=', 'localidades.id')
            ->join('provincias', 'localidades.provincia_id', '=', 'provincias.id')
            ->groupBy('provincias.nombre')
            ->pluck('total', 'provincia');

        $usuariosPorRol = User::selectRaw('roles.name as rol, count(*) as total')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->groupBy('roles.name')
            ->pluck('total', 'rol');

        $localidadConMasTelefonos = Tel::selectRaw('localidades.nombre as localidad, count(*) as total')
            ->join('localidades', 'tels.localidad_id', '=', 'localidades.id')
            ->groupBy('localidades.nombre')
            ->orderByDesc('total')
            ->first()
            ->localidad;

        $rankingProvincias = Tel::selectRaw('provincias.nombre as provincia, count(*) as total')
            ->join('localidades', 'tels.localidad_id', '=', 'localidades.id')
            ->join('provincias', 'localidades.provincia_id', '=', 'provincias.id')
            ->groupBy('provincias.nombre')
            ->orderByDesc('total')
            ->pluck('total', 'provincia');

        foreach ($rankingProvincias as $provinciaName => $count) {
            $provincia = Provincia::where('nombre', $provinciaName)->first();
            if ($provincia) {
                $provincia->telefonos_count = $count;
                $provincia->save();
            }
        }
        $localidades = Localidad::all();
        foreach ($localidades as $localidad) {
            $localidad->telefonos_count = Tel::where('localidad_id', $localidad->id)->count();
            $localidad->save();
        }


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
