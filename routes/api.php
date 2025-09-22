<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\PaymentController;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::get('match',[ApiController::class,'matches']);
Route::get('match/{id}',[ApiController::class,'matchbyID']);
Route::get('prize',[ApiController::class,'prizeTools']);
Route::get('prize/{id}',[ApiController::class,'prizebyID']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('profile',[AuthController::class,'profile']);

    Route::post('/checkout', [PaymentController::class, 'paymentInit']);

    Route::post('logout',[AuthController::class,'logout']);
});
