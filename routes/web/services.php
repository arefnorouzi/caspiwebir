<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicesController;

Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
    Route::get('/ecommerce-builder', [ServicesController::class, 'ecommerce_builder'])
        ->name('ecommerce_builder');

    Route::get('/seo', [ServicesController::class, 'seo'])
        ->name('seo');

    Route::get('/dedicated-website', [ServicesController::class, 'website'])
        ->name('website');

    Route::get('/host', [ServicesController::class, 'host_page'])
        ->name('host');

    Route::get('/wordpress', [ServicesController::class, 'wordpress_page'])
        ->name('wordpress');

    Route::get('/digital-marketing', [ServicesController::class, 'digital_marketing'])
        ->name('digital_marketing');
});
