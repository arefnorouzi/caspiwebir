<?php

use App\Http\Controllers\LearningPathController;
use Illuminate\Support\Facades\Route;

Route::get('/learning-paths', [LearningPathController::class, 'index'])
    ->name('learning-paths.index');

Route::get('/learning-paths/{slug}', [LearningPathController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('learning-paths.show');
