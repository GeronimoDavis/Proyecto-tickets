<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportTicketController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //rutas de ticket
    Route::get('/tickets', [SupportTicketController::class, 'index'])->name('index_ticket');
    Route::post('/tickets',[SupportTicketController::class, 'store'])->name('store_ticket');
    Route::get('/tickets/{ticket}/image', [SupportTicketController::class, 'showImage'])->name('ticket_image');
    Route::patch('/tickets/{id}', [SupportTicketController::class, 'updateStatus'])->name('ticket_update_status');
    Route::patch('/tickets/{id}/cancelar', [SupportTicketController::class, 'updateCancelado'])->name('ticket_cancelar');

});

require __DIR__.'/auth.php';
