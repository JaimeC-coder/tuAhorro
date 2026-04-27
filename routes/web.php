<?php

use App\Http\Controllers\web\CoinController;
use App\Http\Controllers\web\LoanController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    Log::info('Welcome page accessed');
        $coints = [
            ['name' => 'Bitcoin', 'symbol' => 'BTC', 'price' => 50000],
            ['name' => 'Ethereum', 'symbol' => 'ETH', 'price' => 4000],
            ['name' => 'Cardano', 'symbol' => 'ADA', 'price' => 2.5],
        ];
    return $coints;
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::view('product', 'product')
    ->middleware(['auth', 'verified'])
    ->name('product');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');


    Route::resource('coins', CoinController::class)->except(['update', 'destroy', 'store']);
     Route::resource('loans', LoanController::class)->except(['update', 'destroy', 'store']);
    // Route::resource('savings', SavingController::class)->except(['update', 'destroy', 'store']);




});

require __DIR__ . '/auth.php';
