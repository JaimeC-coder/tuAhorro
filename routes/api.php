<?php

use App\Http\Controllers\Api\CoinApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Auth\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Route::post('register', [UserController::class, 'store'])->name('register1');


Route::prefix('admin')->group(function () {
    Route::prefix('coins')->group(function () {
        Route::get('/', [CoinApiController::class, 'listar'])->name('admin.coins.index');
        Route::post('/', [CoinApiController::class, 'register'])->name('admin.coins.store');
        Route::put('/',[CoinApiController::class, 'actualizar'])->name('admin.coins.update');
        Route::delete('/',[CoinApiController::class, 'eliminar'])->name('admin.coins.destroy');
    });
    Route::prefix('users')->group(function () {
        Route::get('/', [UserApiController::class, 'listar'])->name('admin.users.index');
        Route::post('/', [UserApiController::class, 'register'])->name('admin.users.store');
        Route::put('/',[UserApiController::class, 'actualizar'])->name('admin.users.update');
        Route::delete('/',[UserApiController::class, 'eliminar'])->name('admin.users.destroy');
        Route::post('login', [ApiController::class, 'login'])->name('admin.user.login');
    });

    // Route::prefix('users')->group(function () {
    //     Route::get('/', [UserApiController::class, 'listar'])->name('admin.users.index');
    //     Route::post('/', [UserApiController::class, 'register'])->name('admin.users.store');
    //     Route::put('/',[UserApiController::class, 'actualizar'])->name('admin.users.update');
    //     Route::delete('/',[UserApiController::class, 'eliminar'])->name('admin.users.destroy');
    // });


});


Route::middleware([IsUserAuth::class])->group(function () {
    Route::prefix('admin')->group(function () {
        // Route::prefix('coins')->group(function () {
        //     Route::get('/', [CoinApiController::class, 'listar'])->name('admin.coins.index');
        //     Route::post('/', [CoinApiController::class, 'register'])->name('admin.coins.store');
        //     Route::put('/',[CoinApiController::class, 'actualizar'])->name('admin.coins.update');
        //     Route::delete('/',[CoinApiController::class, 'eliminar'])->name('admin.coins.destroy');
        // });
        // Route::prefix('users')->group(function () {
        //     Route::get('/', [UserApiController::class, 'listar'])->name('admin.users.index');
        //     Route::post('/', [UserApiController::class, 'register'])->name('admin.users.store');
        //     Route::put('/',[UserApiController::class, 'actualizar'])->name('admin.users.update');
        //     Route::delete('/',[UserApiController::class, 'eliminar'])->name('admin.users.destroy');
        // });

        Route::prefix('users')->group(function () {
            Route::post('me', [ApiController::class, 'authUser'])->name('admin.users.auth.me');
            Route::post('logout', [ApiController::class, 'logout'])->name('admin.users.auth.logout');
            // Route::get('/', [UserApiController::class, 'listar'])->name('admin.users.index');
            // Route::put('/',[UserApiController::class, 'actualizar'])->name('admin.users.update');
            // Route::delete('/',[UserApiController::class, 'eliminar'])->name('admin.users.destroy');
        });


    });



});

