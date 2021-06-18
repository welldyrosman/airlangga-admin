<?php

use App\Http\Controllers\TourController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\StudioController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home',[AuthController::class, 'home']);
Route::post('/loginservice',[AuthController::class, 'loginservice']);
Route::get('/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
// Route::get('/managetour', function () {
//     return view('pages/tourManage');
// });
Route::get('/managetour', [TourController::class, 'index']);
Route::get('/addnewtour', [TourController::class, 'addnewtour']);
Route::get('/editpack/{id}',[TourController::class,'editTour']);

Route::get('/managestudio', [StudioController::class, 'index']);

Route::get('/facility', [FacilityController::class, 'index']);
