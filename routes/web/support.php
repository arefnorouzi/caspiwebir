<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Support\SupportController;
use App\Http\Controllers\Support\PostsController;

Route::group(['prefix' => 'support', 'as' => 'support.', 'middleware' => ['auth', 'verified', 'is_support']], function () {
    Route::get('/', [SupportController::class, 'index'])->name('index');
    Route::resources([
        'post' => PostsController::class,
    ]);

});
