<?php

use App\Http\Controllers\PricingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PricingController::class, 'index'])->name('pricing');
Route::post('/checkout', [PricingController::class, 'checkout'])->name('checkout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/portal', [DashboardController::class, 'portal'])->name('portal');

// Webhook handling is already provided by the package at /creem/webhook
// We can listen to events in our application (e.g., dynamic logic)
