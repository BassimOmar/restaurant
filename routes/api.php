<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('menu')->group(function () {
    Route::get('categories', [App\Http\Controllers\Api\MenuCategoryApiController::class, 'index']);
    Route::get('categories/{category}', [App\Http\Controllers\Api\MenuCategoryApiController::class, 'show']);

    Route::get('items', [App\Http\Controllers\Api\MenuItemApiController::class, 'index']);
    Route::get('items/{menuItem}', [App\Http\Controllers\Api\MenuItemApiController::class, 'show']);
    Route::get('items/featured', [App\Http\Controllers\Api\MenuItemApiController::class, 'featured']);
});