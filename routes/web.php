<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PersonController;




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
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('equipos', EquipoController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('people', PersonController::class);

    //  Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles.index');
  //  Route::post('/roles', [RolePermissionController::class, 'store'])->name('roles.store');
  //  Route::delete('/roles/{role}', [RolePermissionController::class, 'destroy'])->name('roles.destroy');

    //Route::resource('roles', RoleController::class);
    //Route::post('users/{user}/assign-role', [RoleController::class, 'assignRole'])->name('users.assignRole');

});
