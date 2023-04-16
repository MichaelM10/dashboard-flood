<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\MapLivewire;

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

Route::redirect('/','/dashboard');
Route::redirect('/home','/dashboard');

Auth::routes();

Route::get('/dashboard',                [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


Route::get('/map',                      [App\Http\Livewire\MapLivewire::class, 'render']);

Route::get('/sensor/activation',        [App\Http\Controllers\SensorController::class, 'index']);
Route::get('/activate-a-sensorku',      [App\Http\Controllers\SensorController::class, 'activationProcess']);

Route::post('/sensor/modify',           [App\Http\Controllers\SensorController::class, 'indexModify']);
Route::post('/save-modify',             [App\Http\Controllers\SensorController::class, 'updateSensor']);

Route::post('/add-bookmark',            [App\Http\Controllers\SensorController::class, 'addBookmark']);

Route::post('/api/sensor/test', [App\Http\Controllers\ApiController::class, 'test']);
Route::post('/api/sensor/update', [App\Http\Controllers\ApiController::class, 'update']);