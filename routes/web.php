<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return '<h1>Hello World</h1>';
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])
//         ->name('dashboard');
//     Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
// });