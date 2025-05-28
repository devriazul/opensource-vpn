<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VpnController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // VPN Routes
    Route::prefix('vpn')->name('vpn.')->group(function () {
        Route::get('/', [VpnController::class, 'index'])->name('index');
        Route::post('/connect', [VpnController::class, 'connect'])->name('connect');
        Route::post('/disconnect', [VpnController::class, 'disconnect'])->name('disconnect');
        Route::post('/create-configuration', [VpnController::class, 'createConfiguration'])->name('create-configuration');
    });
});

require __DIR__.'/auth.php';
