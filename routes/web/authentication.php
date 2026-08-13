<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileAuthController;
use App\Http\Controllers\Api\AuthenticationController;
use Illuminate\Http\Request;

Route::group(['prefix' => 'authentication', 'as' => 'authentication.'], function () {
    Route::post('/login', [MobileAuthController::class, 'login'])
        ->name('login')->middleware('guest');
    Route::post('/register', [MobileAuthController::class, 'register'])
        ->name('register')->middleware('guest');

    Route::get('/otp', [MobileAuthController::class, 'otp_login'])
        ->name('otp_login')->middleware('guest');


    Route::post('/mobile', [MobileAuthController::class, 'authenticate'])
        ->name('mobile')->middleware('guest');
    Route::post('/verify-code', [MobileAuthController::class, 'verify_code'])
        ->name('verify_code')->middleware('guest');

    Route::post('/simple-login', [AuthenticationController::class, 'login'])
        ->name('simple_login')->middleware('guest');
    Route::post('/simple-register', [AuthenticationController::class, 'register'])
        ->name('simple_register')->middleware('guest');

    Route::get('logout', function (Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();
        return redirect('/');
    })->name('logout');

});
