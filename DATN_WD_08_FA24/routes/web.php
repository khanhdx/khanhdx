<?php

use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')
    // middlware check auth and admin
    ->as('admin.')
    ->group(function () {

        Route::prefix('colors')
            ->as('colors.')
            ->group(function () {
                Route::get('/', [ColorController::class, 'index'])->name('index');
                // Route::get('/create', [ColorController::class, 'create'])->name('create');
                Route::post('/store', [ColorController::class, 'store'])->name('store');
                // Route::get('/show/{id}', [ColorController::class, 'show'])->name('show');
                // Route::get('{id}/edit', [ColorController::class, 'edit'])->name('edit');
                Route::put('{id_color}/update', [ColorController::class, 'update'])->name('update');
                Route::delete('{id}/delete', [ColorController::class, 'destroy'])->name('delete');
            });

        Route::prefix('sizes')
            ->as('sizes.')
            ->group(function () {
                Route::get('/', [SizeController::class, 'index'])->name('index');
                // Route::get('/create', [SizeController::class, 'create'])->name('create');
                Route::post('/store', [SizeController::class, 'store'])->name('store');
                // Route::get('/show/{id}', [SizeController::class, 'show'])->name('show');
                // Route::get('{id}/edit', [SizeController::class, 'edit'])->name('edit');
                Route::put('{id_color}/update', [SizeController::class, 'update'])->name('update');
                Route::delete('{id}/delete', [SizeController::class, 'destroy'])->name('delete');
            });
    });
