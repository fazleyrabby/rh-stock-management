<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/users', [AuthController::class, 'users']);

Route::apiResource('products', ProductController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
