<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\BkashController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\MatchController;
use App\Http\Controllers\Web\MatchHistoryController;
use App\Http\Controllers\Web\PlayerController;
use App\Http\Controllers\Web\PrizeController;
use App\Http\Controllers\Web\RegisterMatchController;
use App\Http\Controllers\Web\WebsiteController;
use App\Http\Controllers\Web\WithdrawMoneyController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebMatchJoinController;

Route::get('/',[WebsiteController::class,'index'])->name('home');

Route::get('/download-apk', function () {
    $file = public_path('app-release.apk');
    return response()->download($file, 'TroESports.apk', [
        'Content-Type' => 'application/vnd.android.package-archive',
    ]);
})->name('download-apk');

Route::get('leaderboard',[WebsiteController::class,'leaderboard'])->name('leaderboard');
Route::get('leaderboard/{id}',[WebsiteController::class,'matchHistoryByID'])->name('leaderboard.history');

Route::get('match/join/{id}',[WebMatchJoinController::class,'index'])->name('match.join');

Route::post('match/payment/checkout', [WebMatchJoinController::class, 'paymentInit'])->name('webMatch.checkout');
Route::get('match/payment/verify', [WebMatchJoinController::class, 'verify'])->name('webMatch.verify');
Route::get('match/payment/cancel', [WebMatchJoinController::class, 'cancel'])->name('webMatch.cancel');

Route::get('myMatch',[WebsiteController::class,'myMatch'])->name('myMatch');
Route::get('payment/history',[WebsiteController::class,'paymentHistory'])->name('payment.history');
Route::get('match/result',[WebsiteController::class,'matchResult'])->name('match.result');

Route::post('withdraw/money',[WebsiteController::class,'withDrawMoneyStore'])->name('withdraw.money');
Route::get('change/password',[WebsiteController::class,'changePassword'])->name('change.password');
Route::post('change/password',[WebsiteController::class,'passwordChange'])->name('password.change');
Route::get('edit/profile',[WebsiteController::class,'editProfile'])->name('edit.profile');
Route::post('edit/profile',[WebsiteController::class,'profileUpdate'])->name('profile.edit');

Route::get('phone/check',[WebsiteController::class,'checkPhone'])->name('phone.check');
Route::post('/forgot/phone-check', [WebsiteController::class, 'phoneCheck'])->name('check.phone');
Route::get('/forgot/reset',       [WebsiteController::class, 'passwordForget'])->name('forgot.password');
Route::post('forget/password',[WebsiteController::class,'forgotPassword'])->name('password.forget');

Route::post('contact',[WebsiteController::class,'contactUs'])->name('contact');

Route::get('/matches',[WebsiteController::class,'matchList'])->name('matches');

Route::get('/login',[AuthController::class,'loginPage'])->name('login');
Route::get('/register',[AuthController::class,'registerPage'])->name('register');
Route::post('/register',[AuthController::class,'register'])->name('registration');
Route::post('/login',[AuthController::class,'login'])->name('loggedIn');

Route::get('getToken',[BkashController::class,'getToken']);
Route::get('create/agreement',[BkashController::class,'createAgreement']);
Route::get('excute/agreement',[BkashController::class,'executeAgreement'])->name('excute.agreement');

Route::get('/verify', [PaymentController::class, 'verify'])->name('uddoktapay.verify');
Route::get('/cancel', [PaymentController::class, 'cancel'])->name('uddoktapay.cancel');
Route::post('/ipn', [PaymentController::class, 'ipn'])->name('uddoktapay.ipn');
Route::post('/refund', [PaymentController::class, 'refund'])->name('uddoktapay.refund');

Route::get('profile',[AuthController::class,'profile'])->name('profile');

Route::post('userLayouts/logout',[AuthController::class,'userLogout'])->name('users.logout');

Route::middleware(AdminAuth::class)->group(function () {
    Route::get('/dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    Route::resource('matches',MatchController::class);
    Route::patch('matches/{id}/toggle-hidden', [MatchController::class, 'toggleHidden'])->name('matches.toggleHidden');
    Route::resource('prizes',PrizeController::class);
    Route::resource('players',PlayerController::class);
    Route::resource('match/history',MatchHistoryController::class)->names('match.history');

    Route::get('payments',[PaymentController::class,'index'])->name('payments');
    Route::get('register/match/{id}',[RegisterMatchController::class,'show'])->name('register.match');
    Route::put('add/balance/{id}',[RegisterMatchController::class,'addBalance'])->name('add.balance');

    Route::get('/withdraw/money',[WithdrawMoneyController::class,'index'])->name('withdraw.money');
    Route::put('/withdraw/money/{id}',[WithdrawMoneyController::class,'update'])->name('withdraw.money.update');

    Route::get('contact/us',[WebsiteController::class,'contact_us'])->name('contact.us');

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});
