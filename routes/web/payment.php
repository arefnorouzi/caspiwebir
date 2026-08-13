<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\SepController;
use App\Http\Controllers\Payment\TorobPayController;
use App\Http\Controllers\Payment\BehpardakhtController;
use App\Http\Controllers\Payment\SadadController;
use App\Http\Controllers\Payment\SepehrController;
use App\Http\Controllers\Payment\ZibalController;
use App\Http\Controllers\Payment\ZarinpalController;


Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {

    Route::post('/', [PaymentController::class, 'choose_payment_method'])
        ->name('choose_payment_method');

    Route::get('/sep/pay/{id}', [SepController::class, 'pay'])->name('sep.pay');
    Route::get('/sep/callback', [SepController::class, 'verify'])->name('sep.callback');

    Route::get('/sepehr/pay/{id}', [SepehrController::class, 'pay'])->name('sepehr.pay');
    Route::get('/sepehr/callback', [SepController::class, 'verify'])->name('sepehr.callback');

    Route::get('/sadad/pay/{id}', [SadadController::class, 'pay'])->name('sedad.pay');
    Route::post('/sadad/callback', [SadadController::class, 'verify'])->name('sedad.callback');

    Route::get('/bpm/pay/{id}', [BehpardakhtController::class, 'pay'])->name('bpm.pay');
    Route::post('/bpm/callback', [BehpardakhtController::class, 'verify'])->name('bpm.callback');


    Route::get('/torob/pay/{id}', [TorobPayController::class, 'pay'])->name('torob.pay');
    Route::post('/torob/callback', [TorobPayController::class, 'verify'])->name('torob.callback');

    Route::get('/zarinpal/pay/{id}', [ZarinpalController::class, 'pay'])->name('zarinpal.pay');
    Route::get('/zarinpal/callback', [ZarinpalController::class, 'verify'])->name('zarinpal.callback');

    Route::get('/zibal/pay/{id}', [ZibalController::class, 'pay'])->name('zibal.pay');
    Route::get('/zibal/callabck', [ZibalController::class, 'verify'])->name('zibal.callback');

    Route::get('/error', [PaymentController::class, 'error_payment'])
        ->name('fail');

    Route::get('/success', [PaymentController::class, 'success_payment'])
        ->name('success');
});
