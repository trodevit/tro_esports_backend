<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\MatchController;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\Web\PrizeController;
use App\Http\Controllers\Web\PlayerController;
use App\Http\Controllers\PaymentController;

Route::get('/',[WebsiteController::class,'index'])->name('home');

Route::get('/matches',[WebsiteController::class,'matchList'])->name('matches');

Route::get('/login',[AuthController::class,'loginPage'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('loggedIn');


Route::get('/verify', [PaymentController::class, 'verify'])->name('uddoktapay.verify');
Route::get('/cancel', [PaymentController::class, 'cancel'])->name('uddoktapay.cancel');
Route::post('/ipn', [PaymentController::class, 'ipn'])->name('uddoktapay.ipn');
Route::post('/refund', [PaymentController::class, 'refund'])->name('uddoktapay.refund');

Route::middleware(AdminAuth::class)->group(function () {
    Route::get('/dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    Route::resource('matches',MatchController::class);
    Route::resource('prizes',PrizeController::class);
    Route::resource('players',PlayerController::class);

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});
