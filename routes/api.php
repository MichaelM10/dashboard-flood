<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API Gateways
Route::get('sensor/geoJson', [App\Http\Controllers\ApiController::class, 'getGeoJsonSensorData']);
Route::get('sensor/geoJsonOne/{id}', [App\Http\Controllers\ApiController::class, 'getOneGeoJsonSensorData']);
Route::post('sensor/test', [App\Http\Controllers\ApiController::class, 'test']);
Route::post('sensor/send', [App\Http\Controllers\ApiController::class, 'updateSensor']);