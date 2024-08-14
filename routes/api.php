<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::
    // middleware('auth:sanctum')->
    controller(\App\Http\Controllers\Api\Product\ProductController::class)
    ->prefix('products')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{product}', 'show');
        Route::post('/', 'store');
        Route::post('/{product}/review', 'review')->name('product.review.store');
        Route::put('/{product}', 'update')->name('product.update');
        Route::patch('/{product}', 'update')->name('product.update');
});
