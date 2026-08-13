<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Excel\ExportController;

Route::group(['prefix' => 'excel', 'as' => 'excel.', 'middleware' => ['auth']], function () {
    Route::get('/products', [ExportController::class, 'export_products'])
        ->name('export_products')->middleware('is_admin');

    Route::get('/users', [ExportController::class, 'export_users'])
        ->name('export_users')->middleware('is_admin');

    Route::get('/invoices', [ExportController::class, 'export_invoices'])
        ->name('export_invoices')->middleware('is_admin');
});
