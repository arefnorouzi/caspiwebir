<?php
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\InvoiceController;

Route::post('/add-invoice-item/{invoice}', [InvoiceController::class, 'add_item'])
    ->name('add_invoice_item');

Route::delete('/invoice-item/{invoice_item}', [InvoiceController::class, 'delete_item'])
    ->name('invoice_item.delete');

Route::put('/invoice-item-increase/{invoice_item}', [InvoiceController::class, 'increase_item_qty'])
    ->name('invoice_item.increase_item_qty');
Route::put('/invoice-item-decrease/{invoice_item}', [InvoiceController::class, 'decrease_item_qty'])
    ->name('invoice_item.decrease_item_qty');


Route::get('/factor/{invoice}', [InvoiceController::class, 'factor'])->name('factor');
Route::patch('/invoice-item-status/{item}', [InvoiceController::class, 'update_invoice_item_status'])
    ->name('update_invoice_item_status');

Route::delete('/restore-invoice/{invoice}', [InvoiceController::class, 'restore'])
    ->name('invoice.restore')->withTrashed();
