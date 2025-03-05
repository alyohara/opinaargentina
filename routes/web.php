<?php

use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\PersonaTController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\DashboardController;




Route::get('/', function () {
    return view('welcome');
});
//Route::get('telefonos/export/', [TelefonoController::class, 'export'])->name('telefonos.export');
Route::post('telefonos/export/', [TelController::class, 'export'])->name('telefonos.export');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('equipos', EquipoController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('people', PersonController::class);
    Route::resource('telefonos', TelefonoController::class);
    Route::resource('localidades', LocalidadController::class);
    Route::resource('provincias', ProvinciaController::class);
    Route::resource('tels', TelController::class);
    Route::get('/exports', [ExportController::class, 'index'])->name('exports.index');

    Route::resource('personas_t', PersonaTController::class)->except(['update', 'destroy', 'edit','show']);
    Route::get('personas_t/{id}', [PersonaTController::class, 'show'])->name('personas_t.show');
    Route::get('personas_t/{id}/edit', [PersonaTController::class, 'edit'])->name('personas_t.edit');
    Route::put('personas_t/{id}', [PersonaTController::class, 'update'])->name('personas_t.update');
    Route::delete('personas_t/{id}', [PersonaTController::class, 'destroy'])->name('personas_t.destroy');
// routes/web.php

    Route::get('/telefonos/provincia/{provincia}', [DashboardController::class, 'telefonosPorProvincia'])->name('telefonos.provincia');
    Route::get('/buscar-telefonos', [DashboardController::class, 'buscarTelefonos'])->name('buscar.telefonos');
    Route::get('/telefonos/provincia/{provincia}/ciudades', [DashboardController::class, 'ciudadesPorProvincia'])->name('telefonos.ciudades');

});
