<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TorobApiController;

Route::group(['prefix' => 'shared', 'as' => 'shared.'], function () {
    Route::get('/torob', [TorobApiController::class, 'index'])->name('torob_products_list');
    Route::post('/torob', [TorobApiController::class, 'torob_products'])->name('torob_products');
});
