<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('profile',[AuthController::class,'profile']);

    Route::post('logout',[AuthController::class,'logout']);
});
