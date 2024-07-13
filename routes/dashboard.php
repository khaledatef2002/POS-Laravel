<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrderController as DashboardOrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [DashboardController::class, 'index'])->name('index');

Route::resource('users', UserController::class)->except('show');

Route::resource('roles', RoleController::class)->except('show');

Route::controller(ProfileController::class)->group(function(){
    Route::get('profile', 'edit')->name('profile');
    Route::put('profile', 'update');
});

Route::resource('categories', CategoryController::class)->except('show');

Route::resource('products', ProductController::class)->except('show');

Route::resource('clients', ClientController::class)->except('show');
Route::resource('clients.orders', OrderController::class)->only('create','store');
Route::resource('orders', DashboardOrderController::class);
Route::get('/order/{order}', [DashboardOrderController::class, 'getOrderDetails'])->name('getOrderDetails');
