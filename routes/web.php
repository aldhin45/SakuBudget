<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // ⬅️ HARUS DI ATAS
    Route::get('/transactions/export', [TransactionController::class, 'export'])
        ->name('transactions.export');

    Route::get('/transactions/pdf', [TransactionController::class, 'exportPdf'])
        ->name('transactions.pdf');

    Route::resource('transactions', TransactionController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('transactions', TransactionController::class);

});
Route::get('/transactions/export', [TransactionController::class, 'export'])
    ->name('transactions.export');

require __DIR__.'/auth.php';

Route::post('/update-balance', [DashboardController::class, 'updateBalance'])
    ->name('update.balance');


