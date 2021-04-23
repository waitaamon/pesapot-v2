<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

   Route::get('dashboard', fn()=> view('dashboard'))->name('dashboard');

    Route::get('customers', App\Http\Controllers\CustomersController::class)->name('customers');

    Route::get('cash-receipts', App\Http\Controllers\CashReceiptController::class)->name('cashReceipt');

    Route::get('suppliers', App\Http\Controllers\SuppliersController::class)->name('suppliers');

    Route::get('cash-payments', App\Http\Controllers\CashPaymentController::class)->name('cashPayment');
});
