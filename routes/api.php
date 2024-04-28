<?php

use App\Http\Controllers\Api\Product\OrderController;
use App\Http\Controllers\Api\Product\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('products', ProductController::class)->except('edit', 'create');
Route::resource('orders', OrderController::class)->except('edit', 'create');
