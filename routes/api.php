<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1/')->group(function () {
    require __DIR__ . '/group_v1/product.php';
    require __DIR__ . '/group_v1/user.php';
});

// Route::prefix('v2/')->group(function () {
//
// });
