<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::
    middleware('auth:sanctum')->
    apiResource('products',\App\Http\Controllers\Api\Product\ProductController::class);

Route::
    middleware('auth:sanctum')->
    controller(\App\Http\Controllers\Api\Product\ProductController::class)
    ->prefix('products')
    ->group(function () {
        Route::post('/{product}/review', 'addReview')->name('product.review.store');
});

Route::controller(\App\Http\Controllers\Api\User\UserController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
});
