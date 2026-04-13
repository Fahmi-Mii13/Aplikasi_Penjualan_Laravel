<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PosController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // POS Routes (operator)
    Route::middleware(['role:operator'])->group(function() {
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('/pos/add', [PosController::class, 'addToCart'])->name('pos.add');
        Route::delete('/pos/remove/{id}', [PosController::class, 'removeFromCart'])->name('pos.remove');
        Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
    });

    // Admin & Superadmin routes (manage products, users, history)
    Route::middleware(['role:admin,superadmin'])->group(function() {
        Route::resource('products', ProductController::class);
        Route::get('/history', [PosController::class, 'history'])->name('pos.history');
    });

    // Superadmin only
    Route::middleware(['role:superadmin'])->group(function() {
        Route::resource('users', UserController::class);
    });
});
