<?php

use App\Http\Controllers\TourController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalVidController;
use App\Http\Controllers\PicGalController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\WhyUsController;
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
Route::get('/addnewstudio', [StudioController::class, 'addnewstudio']);

Route::get('/galleryvideo', [GalVidController::class, 'index']);
Route::get('/galleryphotos', [PicGalController::class, 'index']);
Route::get('/teamcontrol', [TeamController::class, 'index']);
Route::get('/testimoni', [TestimoniController::class, 'index']);
Route::get('/whyuscontrol', [WhyUsController::class, 'index']);
Route::get('/faqcontrol', [FaqController::class, 'index']);
Route::get('/facility', [FacilityController::class, 'index']);
