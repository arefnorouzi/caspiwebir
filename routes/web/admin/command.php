<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandController;


Route::get('/cache-clear', [CommandController::class, 'cache_clear'])->name('cache_clear');
Route::get('/route-clear', [CommandController::class, 'route_clear'])->name('route_clear');
Route::get('/config-clear', [CommandController::class, 'config_clear'])->name('config_clear');
Route::get('/db-migrate', [CommandController::class, 'db_migrate'])->name('db_migrate');
Route::get('/db-backup', [CommandController::class, 'db_backup'])->name('db_backup');
