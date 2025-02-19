<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\LocalidadController;

Route::get('/states/{state}/cities', [CityController::class, 'getCitiesByState']);
Route::get('/cities', [CityController::class, 'getCitiesByState']);
Route::get('/telefonos', [TelefonoController::class, 'filter']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/provincias/{provincia}/localidades', [LocalidadController::class, 'getLocalidadesByProvincia']);
