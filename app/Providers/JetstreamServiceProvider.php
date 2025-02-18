<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);


        Jetstream::role('adminit', 'AdminIT', [
            'create',
            'read',
            'update',
            'delete',
            'assignRoles',
            'assignPermissions',
            'createTeams',
            'deleteTeams',
            'addTeamMembers',
            'removeTeamMembers',
            'deleteTeams',
            'deleteUsers',
            'createUsers',
            'updateUsers',

        ])->description('Usuario Administardor de IT');

        Jetstream::role('admin', 'Administrador', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Los uduarios administradores pueden realizar cualquier acciòn');

        Jetstream::role('editor', 'TeamLeader', [
            'read',
            'update',
        ])->description('Los TeamLeaders pueden asignar operadores a su equipo.');
        Jetstream::role('operator', 'Operador', [
            'read',
            'update',
        ])->description('Los operadores pueden realizar tareas asignadas por su TeamLeader.');

    }
}
