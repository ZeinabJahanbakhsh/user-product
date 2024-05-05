<?php

use App\Http\Controllers\Api\Product\OrderController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {

    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

});

Route::prefix('dashboard')->middleware(['auth:api'])->group(function () {

    Route::resource('products', ProductController::class)->except('edit', 'create');
    Route::resource('orders', OrderController::class)->except('edit', 'create');

});



