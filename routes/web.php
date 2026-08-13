<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Api\CommentApiController;

Route::get('/', [HomeController::class, 'landing'])->name('home');
Route::get('/enamad', [HomeController::class, 'enamad'])->name('enamad');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/partner', [HomeController::class, 'partner'])->name('partner');
Route::get('/page/{slug}', [HomeController::class, 'page_detail'])->name('page_detail');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/article/{Slug}', [BlogController::class, 'show'])->name('blog_show');


Route::post('/comment/product', [CommentApiController::class, 'store_product_comment'])
    ->name('store_product_comment');
Route::post('/comment/post', [CommentApiController::class, 'store_post_comment'])
    ->name('store_post_comment');

Route::post('/upload', [UploadController::class, 'store'])
    ->name('upload')->middleware('auth');
Route::post('/uploader', [UploadController::class, 'uploader'])
    ->name('uploader')->middleware('auth');

Route::post('/upload-editor-image', [UploadController::class, 'editorImage'])
    ->name('upload_editor_image')->middleware('auth');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

require __DIR__.'/web/authentication.php';
require __DIR__.'/web/shop.php';
require __DIR__.'/web/checkout.php';
require __DIR__.'/web/payment.php';
require __DIR__.'/web/dashboard.php';
#require __DIR__.'/web/support.php';
require __DIR__.'/web/admin.php';
require __DIR__.'/web/excel.php';
