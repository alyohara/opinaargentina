<?php

use App\Models\Tel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\PersonaTController;
use App\Http\Controllers\TelController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Export routes
    Route::get('/exports', [ExportController::class, 'index'])->name('exports.index');

    // Telefono routes
    Route::resource('tels', TelController::class);
    Route::post('/telefonos/export', [TelefonoController::class, 'export'])->name('telefonos.export');

    // User routes
    Route::resource('users', UserController::class);

    // Role routes
    Route::resource('roles', RoleController::class);

    // Permission routes
    Route::resource('permissions', PermissionController::class);

    //Equipo routes
    Route::resource('equipos', EquipoController::class);

    //Provincia routes
    Route::resource('states', ProvinciaController::class);

    //Localidad routes
    Route::resource('cities', LocalidadController::class);

    // PersonasT routes
    Route::resource('personas_t', PersonaTController::class);

});
