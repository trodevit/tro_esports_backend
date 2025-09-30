<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WithdrawMoneyController;
use App\Http\Controllers\BkashController;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('phoneCheck',[AuthController::class,'phoneCheck']);
Route::post('forgotPassword',[AuthController::class,'forgotPassword']);

//Route::post('/refund', [PaymentController::class, 'refund'])->name('uddoktapay.refund');

Route::get('match/history',[ApiController::class,'matchHistory']);

//Route::post('query/balance',[BkashController::class,'queryBalance']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('profile',[AuthController::class,'profile']);

    Route::post('profile/update',[AuthController::class,'profileUpdate']);

    Route::post('profile/delete',[AuthController::class,'delete']);

    Route::post('changePassword',[AuthController::class,'changePassword']);
    Route::get('match',[ApiController::class,'matches']);
    Route::get('match/{id}',[ApiController::class,'matchbyID']);
    Route::get('prize',[ApiController::class,'prizeTools']);
    Route::get('prize/{id}',[ApiController::class,'prizebyID']);

    Route::post('withdraw',[WithdrawMoneyController::class,'store']);

    Route::post('/checkout', [PaymentController::class, 'paymentInit']);

    Route::get('payment/history',[PaymentController::class, 'paymentHistory']);

    Route::get('withdraw/history',[ApiController::class,'withdrawList']);

    Route::post('logout',[AuthController::class,'logout']);
});
