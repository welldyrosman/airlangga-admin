<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalVidController;
use App\Http\Controllers\StudioAPIController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\TourAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/package', [TourAPIController::class, 'newpack']);
Route::get('/package', [TourAPIController::class, 'getpack']);
//Route::get('/package/{id}', [TourAPIController::class, 'getpackbyid']);
Route::post('/package/{id}', [TourAPIController::class, 'updpack']);
Route::delete('/package/{id}', [TourAPIController::class, 'delpack']);
Route::post('/dispackage/{id}', [TourAPIController::class, 'disabledpack']);

Route::post('/facility', [TourAPIController::class, 'addfacility']);


Route::post('/studiopackage', [StudioAPIController::class, 'newpack']);


Route::post('/faq', [FaqController::class, 'newfaq']);
Route::post('/faq/{id}', [FaqController::class, 'updfaq']);
Route::delete('/faq/{id}', [FaqController::class, 'deletefaq']);

Route::post('/galvid', [GalVidController::class, 'addnewvid']);
Route::post('/galvid/{id}', [GalVidController::class, 'updvid']);
Route::delete('/galvid/{id}', [GalVidController::class, 'deletevid']);


Route::post('/facilitystudio', [StudioAPIController::class, 'addfacility']);

