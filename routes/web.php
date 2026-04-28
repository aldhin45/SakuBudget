<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TopUpController;


/*
|--------------------------------------------------------------------------
| Public (Landing)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Protected (Login Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */
    Route::get('/transactions/export', [TransactionController::class, 'export'])
        ->name('transactions.export');

    Route::get('/transactions/pdf', [TransactionController::class, 'exportPdf'])
        ->name('transactions.pdf');

    Route::resource('transactions', TransactionController::class);

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    /*
    |--------------------------------------------------------------------------
    | Top Up
    |--------------------------------------------------------------------------
    */
    Route::get('/topup', [TopUpController::class, 'index'])->name('topup');
    Route::post('/topup', [TopUpController::class, 'store'])->name('topup.store');

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    // READ 1 NOTIF
Route::post('/notifications/{id}/read', function ($id) {
    $notif = auth()->user()->notifications()->findOrFail($id);
    $notif->markAsRead();
    return back();
})->name('notifications.read.single');

// READ ALL
Route::post('/notifications/read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('notifications.read');

});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';