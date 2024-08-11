<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(\App\Http\Controllers\Api\Product\ProductController::class)
    ->prefix('api/products')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{product}', 'show');
    });
