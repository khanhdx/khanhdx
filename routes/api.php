<?php

use App\Http\Controllers\Admin\DashbroadController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

Route::get('/product/{product}', [ProductController::class, 'show_modal'])->name('product.show');

Route::get('/get-color', [ProductController::class, 'getColor'])->name('get.color');
Route::get('/get-stock', [ProductController::class, 'getInStock'])->name('get.stock');

Route::get('/revenue', [StatisticalController::class, 'getRevenueData']);
Route::get('/order', [StatisticalController::class, 'getOrderData']);
Route::get('/order-by-status', [StatisticalController::class, 'showOrderStatusChart']);
