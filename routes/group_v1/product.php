<?php

use Illuminate\Support\Facades\Route;

Route::
    apiResource('products',\App\Http\Controllers\Api\Product\ProductController::class);

Route::
    middleware('auth:sanctum')->
    controller(\App\Http\Controllers\Api\Product\ProductController::class)
    ->prefix('products')
    ->group(function () {
        Route::post('/{product}/review', 'addReview')->name('product.review.store');
});

