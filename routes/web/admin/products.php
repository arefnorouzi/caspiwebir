<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

Route::delete('/products/bulk', [ProductController::class, 'bulkDestroy'])->name('products.bulk.destroy');
Route::delete('/products/bulk-restore', [ProductController::class, 'bulkRestore'])->name('products.bulk.restore')->withTrashed();
Route::patch('/products/bulk/deactivate', [ProductController::class, 'bulkDeactivate'])->name('products.bulk.deactivate');
Route::patch('/products/bulk/activate', [ProductController::class, 'bulkActivate'])->name('products.bulk.activate');
Route::patch('/products/bulk/soldout', [ProductController::class, 'bulkSoldOut'])->name('products.bulk.soldout');
Route::patch('/products/bulk/instock', [ProductController::class, 'bulkInstock'])->name('products.bulk.instock');
Route::get('/products', [ProductController::class, 'products_list'])->name('products_list');
Route::patch('/products/group-discount', [ProductController::class, 'group_discount'])->name('group_discount');
Route::patch('/products/remove-group-discount', [ProductController::class, 'remove_group_discount'])->name('remove_group_discount');


Route::get('/products-search', [ProductController::class, 'search'])->name('products_search');

Route::put('/product-publish/{product}', [ProductController::class, 'product_publish'])
    ->name('product_publish');
Route::patch('/product-seo/{product}', [ProductController::class, 'product_seo'])
    ->name('product_seo');
Route::patch('/product-size/{product}', [ProductController::class, 'product_size'])
    ->name('product_size');
Route::patch('/update-product/{product}', [ProductController::class, 'fast_update'])
    ->name('product.fast_update')->withTrashed();

Route::delete('/restore-product/{product}', [ProductController::class, 'restore'])
    ->name('product.restore')->withTrashed();
