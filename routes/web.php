<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;


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

  //  Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles.index');
  //  Route::post('/roles', [RolePermissionController::class, 'store'])->name('roles.store');
  //  Route::delete('/roles/{role}', [RolePermissionController::class, 'destroy'])->name('roles.destroy');

    //Route::resource('roles', RoleController::class);
    //Route::post('users/{user}/assign-role', [RoleController::class, 'assignRole'])->name('users.assignRole');

});
