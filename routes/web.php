<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\DashboardController;


Route::get('/', [LoginController::class, 'loginForm'])->name('login');

Route::get('register', [RegisterController::class, 'registerForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'loginForm'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Delete routes
    Route::delete('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk_delete');
    Route::delete('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk_delete');
    Route::delete('suppliers/bulk-delete', [SupplierController::class, 'bulkDelete'])->name('suppliers.bulk_delete');
    Route::delete('customers/bulk-delete', [SupplierController::class, 'bulkDelete'])->name('customers.bulk_delete');

    // Resource Routes
    Route::resource('products', ProductController::class)->names('products');
    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class)->names('customers');
    Route::resource('purchases', PurchaseController::class)->names('purchases');
});


// Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])
//         ->name('dashboard');
//     Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
// });