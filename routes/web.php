<?php

use App\Http\Controllers\web\CoinWebController;
use App\Http\Controllers\web\LoanWebController;
use App\Http\Controllers\web\SavingWebController;
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

    Route::resource('coins', CoinWebController::class)->except(['update', 'destroy', 'store']);
    Route::resource('loans', LoanWebController::class)->except(['update', 'destroy', 'store', 'show']);
    Route::resource('savings', SavingWebController::class)->except(['update', 'destroy', 'store']);
});

Route::get('loans/{loan}', [LoanWebController::class, 'show'])->name('loans.show');

require __DIR__ . '/auth.php';
