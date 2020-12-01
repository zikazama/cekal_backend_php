<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\BotController;

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


Route::get('/kalori',[ApiController::class,'cek_kalori']);
Route::post('/kalori',[ApiController::class,'cek_kalori']);
Route::get('/bot',[BotController::class,'index']);
Route::post('/bot',[BotController::class,'index']);