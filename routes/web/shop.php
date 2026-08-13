<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShoppingCartController;

Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::post('/search', [ShopController::class, 'search'])->name('search');
    Route::get('/filter', [ShopController::class, 'filter'])->name('filter');
    Route::get('/off', [ShopController::class, 'off'])->name('off');
    Route::get('/featured', [ShopController::class, 'featured'])->name('featured');
    Route::get('/popular', [ShopController::class, 'popular'])->name('popular');
    Route::get('/product/{slug}', [ShopController::class, 'show_product'])->name('show_product');
    Route::get('/p/{id}', [ShopController::class, 'single_product'])->name('single_product');
    Route::get('/category/{slug}', [ShopController::class, 'category'])->name('category');
});


Route::get('/cart', [ShoppingCartController::class, 'index'])
    ->name('cart_page');

Route::patch('/cart-item-qty', [ShoppingCartController::class, 'update_qty'])
    ->name('update_qty');

Route::patch('/cart/increase-qty', [ShoppingCartController::class, 'increase_qty'])
    ->name('increase_qty');
Route::patch('/cart/decrease-qty', [ShoppingCartController::class, 'decrease_qty'])
    ->name('decrease_qty');

Route::post('/cart/remove', [ShoppingCartController::class, 'remove_item'])
    ->name('remove_cart_item');

Route::post('/cart', [ShoppingCartController::class, 'add_to_cart'])
    ->name('add_to_cart');

Route::post('/coupon', [ShoppingCartController::class, 'applyCoupon'])
    ->name('apply_coupon');
Route::delete('/coupon', [ShoppingCartController::class, 'removeCoupon'])
    ->name('remove_coupon');

Route::get('/cart/summary', [ShoppingCartController::class, 'summary'])
    ->name('cart_summary');
