<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\AttendeedController;
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

//Route::group(['middleware'=>"auth:sanctum"],function(){
    Route::post('storeEvent', [EventController::class, 'store']);
    Route::get('eventList/{id}', [EventController::class, 'index']);
    Route::put('updateEvent', [EventController::class, 'update']);
    Route::delete('deleteEvent/{id}', [EventController::class, 'destroy']);
    Route::post('storeGift', [GiftController::class, 'store']);
    Route::delete('deleteGift/{id}', [GiftController::class, 'destroy']);
    Route::post('storeAttendeed', [AttendeedController::class, 'store']);
    Route::post('published', [EventController::class, 'published']);
    Route::get('eventAccepted/{id}', [EventController::class, 'show']);
//});
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('/cmd/{command}',function($command){
    Artisan::call($command);
    dd(Artisan::output());
});