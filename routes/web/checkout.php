<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CheckoutController;

Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('checkout/{uuid}', [CheckoutController::class, 'show'])
    ->name('show_checkout');
Route::post('checkout', [CheckoutController::class, 'store'])->name('generate_order');
