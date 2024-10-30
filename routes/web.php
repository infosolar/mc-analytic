<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    abort(404);
});

Route::middleware('auth')->prefix('/dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'getIndex'])->name('index');
    Route::get('/articles', [\App\Http\Controllers\DashboardController::class, 'getArticles'])->name('articles');
    Route::get('/logs', [\App\Http\Controllers\DashboardController::class, 'getLogs'])->name('logs');
});

Auth::routes(['register' => false]);
