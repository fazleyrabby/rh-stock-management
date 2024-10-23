<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return '<h1>Hello World</h1>';
});


Route::get('register', [RegisterController::class, 'registerForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'loginForm'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('supplier', SupplierController::class);

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function(){
});


// Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])
//         ->name('dashboard');
//     Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
// });