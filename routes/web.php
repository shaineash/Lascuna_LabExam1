<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return redirect('/rices');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Rice Routes
Route::resource('rices', RiceController::class)->middleware('auth');

// Order Routes
Route::resource('orders', OrderController::class)->middleware('auth')->only(['index', 'create', 'store', 'show']);

// Payment Routes
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index')->middleware('auth');
Route::get('/orders/{order}/pay', [PaymentController::class, 'pay'])->name('payments.pay')->middleware('auth');
Route::post('/orders/{order}/process-payment', [PaymentController::class, 'processPayment'])->name('payments.processPayment')->middleware('auth');

