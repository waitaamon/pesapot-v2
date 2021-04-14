<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

   Route::get('/dashboard', fn()=> view('dashboard'))->name('dashboard');

    Route::get('cash-receipt', [\App\Http\Controllers\CashReceiptController::class, 'index'])->name('cashReceipt');
});
