<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\UserInvoiceController;
use App\Http\Controllers\Dashboard\UserTicketController;
use App\Http\Controllers\Dashboard\DashboardNotificationController;
use App\Http\Controllers\Dashboard\UserDocumentController;


Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {
    Route::get('/', [PanelController::class, 'index'])->name('index');
    Route::get('/profile', [PanelController::class, 'profile'])->name('profile');
    Route::post('/profile', [PanelController::class, 'update_profile'])->name('update_profile');

    Route::get('/document/check', [UserDocumentController::class, 'check_page'])
        ->name('check_page');
    Route::get('/document/receipt', [UserDocumentController::class, 'receipt_page'])
        ->name('receipt_page');

    Route::post('/document/check', [UserDocumentController::class, 'store_check'])
        ->name('store_check');

    Route::post('/document/receipt', [UserDocumentController::class, 'store_receipt'])
        ->name('store_receipt');

    Route::resource('/invoice', UserInvoiceController::class);

    Route::delete('/invoice-item/{invoice_item}', [UserInvoiceController::class, 'delete_item'])
        ->name('invoice_item.delete');

    Route::put('/invoice-item-increase/{invoice_item}', [UserInvoiceController::class, 'increase_item_qty'])
        ->name('invoice_item.increase_item_qty');
    Route::put('/invoice-item-decrease/{invoice_item}', [UserInvoiceController::class, 'decrease_item_qty'])
        ->name('invoice_item.decrease_item_qty');

    Route::get('/factor/{invoice}', [UserInvoiceController::class, 'factor']);


    Route::get('/ticket', [UserTicketController::class, 'index'])->name('ticket.index');
    Route::get('/ticket/create', [UserTicketController::class, 'create'])->name('ticket.create');
    Route::get('/ticket/show/{ticket}', [UserTicketController::class, 'show'])->name('ticket.show');
    Route::post('/ticket', [UserTicketController::class, 'store'])->name('ticket.store');
    Route::patch('/ticket/{ticket}', [UserTicketController::class, 'update'])->name('ticket.update');



    Route::get('/notification', [DashboardNotificationController::class, 'index'])->name('notification.index');
    Route::get('/notification/{notification}', [DashboardNotificationController::class, 'show'])->name('notification.show');

});
