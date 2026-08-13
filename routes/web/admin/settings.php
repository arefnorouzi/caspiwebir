<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


Route::get('/', [AdminController::class, 'index'])->name('index');
Route::get('/system', [AdminController::class, 'system'])->name('system');
Route::get('/setting', [AdminController::class, 'setting'])->name('setting');
Route::get('/setting/website', [AdminController::class, 'website_setting'])->name('website_setting');
Route::post('/setting/website', [AdminController::class, 'update_website_setting'])->name('update_website_setting');
Route::get('/setting/shop', [AdminController::class, 'shop_setting'])->name('shop_setting');
Route::post('/setting/shop', [AdminController::class, 'update_shop_setting'])->name('update_shop_setting');
