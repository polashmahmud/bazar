<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\PinAuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// PIN Authentication Routes
Route::get('/', [PinAuthController::class, 'showPinForm'])->name('pin.form');
Route::post('/pin-verify', [PinAuthController::class, 'verifyPin'])->name('pin.verify');
Route::post('/pin-logout', [PinAuthController::class, 'logout'])->name('pin.logout');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Items routes
Route::middleware(['auth'])->group(function () {
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::post('/items/bulk-sync', [ItemController::class, 'bulkSync'])->name('items.bulk-sync');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
