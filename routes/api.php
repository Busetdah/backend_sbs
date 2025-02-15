<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CounterTotalController;
use App\Http\Controllers\EwsController;
use App\Http\Controllers\HopperAirPressureController;
use App\Http\Controllers\HopperWeigher1Controller;
use App\Http\Controllers\HopperWeigher2Controller;
use App\Http\Controllers\M712d1Controller;
use App\Http\Controllers\M712d2Controller;
use App\Http\Controllers\M713dController;
use App\Http\Controllers\M714dController;
use App\Http\Controllers\M2379Controller;
use App\Http\Controllers\MonitoringBlowerController;
use App\Http\Controllers\MonitoringRoomController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductTemperatureController;
use App\Http\Controllers\QcController;
use App\Http\Controllers\SewingController;
use App\Http\Controllers\VariableCtqController;
use App\Http\Controllers\VariableCtq2Controller;
use App\Http\Controllers\VariableCtq3Controller;
use App\Http\Controllers\PredictController;
use App\Http\Controllers\DataTrainingController;
use App\Http\Controllers\RealTimeController;

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

Route::get('/realtime', [RealTimeController::class, 'stream']);
Route::post('/store-data-training', [DataTrainingController::class, 'store']);
Route::get('/predict', [PredictController::class, 'predict']);
Route::get('/countertotal', [CounterTotalController::class, 'index']);
Route::post('/countertotal', [CounterTotalController::class, 'store']);
Route::get('/ews', [EwsController::class, 'index']);
Route::post('/ews', [EwsController::class, 'store']);
Route::get('/hopperairpressure', [HopperAirPressureController::class, 'index']);
Route::post('/hopperairpressure', [HopperAirPressureController::class, 'store']);
Route::get('/hopperweigher1', [HopperWeigher1Controller::class, 'index']);
Route::post('/hopperweigher1', [HopperWeigher1Controller::class, 'store']);
Route::get('/hopperweigher2', [HopperWeigher2Controller::class, 'index']);
Route::post('/hopperweigher2', [HopperWeigher2Controller::class, 'store']);
Route::get('/m712d1', [M712d1Controller::class, 'index']);
Route::post('/m712d1', [M712d1Controller::class, 'store']);
Route::get('/m712d2', [M712d2Controller::class, 'index']);
Route::post('/m712d2', [M712d2Controller::class, 'store']);
Route::get('/m713d', [M713dController::class, 'index']);
Route::post('/m713d', [M713dController::class, 'store']);
Route::get('/m714d', [M714dController::class, 'index']);
Route::post('/m714d', [M714dController::class, 'store']);
Route::get('/m2379', [M2379Controller::class, 'index']);
Route::post('/m2379', [M2379Controller::class, 'store']);
Route::get('/monitoringblower', [MonitoringBlowerController::class, 'index']);
Route::post('/monitoringblower', [MonitoringBlowerController::class, 'store']);
Route::get('/monitoringhumidity', [MonitoringHumidityController::class, 'index']);
Route::post('/monitoringhumidity', [MonitoringHumidityController::class, 'store']);
Route::get('/monitoringroom', [MonitoringRoomController::class, 'index']);
Route::post('/monitoringroom', [MonitoringRoomController::class, 'store']);
Route::get('/productcolor', [ProductColorController::class, 'index']);
Route::post('/productcolor', [ProductColorController::class, 'store']);
Route::get('/producttemperature', [ProductTemperatureController::class, 'index']);
Route::post('/producttemperature', [ProductTemperatureController::class, 'store']);
Route::get('/qc', [QcController::class, 'index']);
Route::post('/qc', [QcController::class, 'store']);
Route::get('/sewing', [SewingController::class, 'index']);
Route::post('/sewing', [SewingController::class, 'store']);
Route::get('/variablectq1', [VariableCtqController::class, 'index']);
Route::post('/variablectq1', [VariableCtqController::class, 'store']);
Route::get('/variablectq2', [VariableCtq2Controller::class, 'index']);
Route::post('/variablectq2', [VariableCtq2Controller::class, 'store']);
Route::get('/variablectq3', [VariableCtq3Controller::class, 'index']);
Route::post('/variablectq3', [VariableCtq3Controller::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
