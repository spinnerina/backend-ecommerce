<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'destroy']);

Route::prefix('products')->group(function () {
    // Random products
    Route::get('/random', [ProductsController::class, 'showRandomProduct'])->name('products.random');
    // Get all products
    Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    // Create a new product
    Route::post('/', [ProductsController::class, 'store'])->name('products.store');
    // Get a specific product by ID
    Route::get('{product}', [ProductsController::class, 'show'])->name('products.show');
    // Update product by ID
    Route::put('{product}', [ProductsController::class, 'update'])->name('products.update');
    // Delete product by ID
    Route::delete('{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
});

Route::prefix('categories')->group(function () {
    // Get all categories
    Route::get('/', [CategoryController::class, 'index']);
    // Create a new category
    Route::post('/', [CategoryController::class, 'store']);
    // Get a specific category by ID
    Route::get('{category}', [CategoryController::class, 'show']);
    // Update category by ID
    Route::put('{category}', [CategoryController::class, 'update']);
    // Delete category by ID
    Route::delete('{category}', [CategoryController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/orders/history', [OrderController::class, 'getHistoryUser']);
Route::middleware('auth:sanctum')->post('/orders', [OrderController::class, 'store']);
Route::middleware('auth:sanctum')->get('/orders/{order}', [OrderController::class, 'show']);
Route::middleware('auth:sanctum')->put('/orders/{order}/cancel', [OrderController::class, 'cancel']);
