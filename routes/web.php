<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\MapLivewire;
use App\Http\Livewire\SensorDetail;

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

Route::get('/sensor',                [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


// Route::get('/dashboard',                      MapLivewire::class);
Route::get('/dashboard',                   [App\Http\Controllers\HomeController::class, 'dashboard']);

Route::post('/sensordetailtest',               SensorDetail::class);

Route::get('/sensor/activation',        [App\Http\Controllers\SensorController::class, 'index']);
Route::get('/activate-a-sensorku',      [App\Http\Controllers\SensorController::class, 'activationProcess']);

Route::post('/sensor/detail',           [App\Http\Controllers\SensorController::class, 'indexDetail']);
Route::post('/sensor/change-location',           [App\Http\Controllers\SensorController::class, 'indexChangeLocation']);
Route::post('/sensor/save-new-location', [App\Http\Controllers\SensorController::class, 'saveNewLocation']);
Route::post('/save-modify',             [App\Http\Controllers\SensorController::class, 'updateSensor']);

Route::post('/add-bookmark',            [App\Http\Controllers\SensorController::class, 'addBookmark']);
Route::post('/remove-bookmark',            [App\Http\Controllers\SensorController::class, 'removeBookmark']);