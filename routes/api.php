<?php

use App\Http\Controllers\Api\CoinApiController;
use App\Http\Controllers\Api\LoanApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Auth\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('admin')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('login', [ApiController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('admin.user.login');
        Route::post('register', [UserApiController::class, 'register'])
        ->name('admin.users.store');
    });
});


Route::middleware([IsUserAuth::class])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('coins')->group(function () {
            Route::get('/', [CoinApiController::class, 'listar'])->name('admin.coins.index');
            Route::post('/', [CoinApiController::class, 'register'])->name('admin.coins.store');
            Route::put('/', [CoinApiController::class, 'actualizar'])->name('admin.coins.update');
            Route::delete('/', [CoinApiController::class, 'eliminar'])->name('admin.coins.destroy');
        });

        Route::prefix('loans')->group(function () {
            Route::get('/', [LoanApiController::class, 'listar'])->name('admin.loans.index');
            Route::post('/', [LoanApiController::class, 'register'])->name('admin.loans.store');
            Route::put('/', [LoanApiController::class, 'actualizar'])->name('admin.loans.update');
            Route::patch('/', [LoanApiController::class, 'actualizarDetalle'])->name('admin.loans.updateDetalle');
            Route::delete('/', [LoanApiController::class, 'eliminar'])->name('admin.loans.destroy');
        });

        Route::prefix('users')->group(function () {
            Route::post('me', [ApiController::class, 'authUser'])->name('admin.users.auth.me');
            Route::post('logout', [ApiController::class, 'logout'])->name('admin.users.auth.logout');
            Route::put('/', [UserApiController::class, 'actualizar'])->name('admin.users.update');
            Route::get('/', [UserApiController::class, 'listar'])->name('admin.users.index');
            Route::delete('/', [UserApiController::class, 'eliminar'])->name('admin.users.destroy');
        });
    });
});
