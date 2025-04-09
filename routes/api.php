<?php

use App\Http\Controllers\Api\CoinApiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [UserController::class, 'store'])->name('register1');

Route::prefix('admin')->group(function () {
    Route::prefix('coins')->group(function () {
        Route::get('/', [CoinApiController::class, 'index'])->name('admin.coins.index');
        Route::post('/', [CoinApiController::class, 'register'])->name('admin.coins.store');
    });
});
