<?php

use App\Http\Controllers\Auth\PinLoginController;
use App\Http\Controllers\CartHistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

// Landing Page
Route::get('/', LandingController::class)->name('landing');

// Pin Login Routes (for registered users)
Route::middleware('guest')->group(function () {
    Route::get('/pin-login', [PinLoginController::class, 'show'])->name('pin.login.show');
    Route::post('/pin-login', [PinLoginController::class, 'store'])->name('pin.login.store');
});

// Pin Setup Routes (for authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/pin-setup', [PinLoginController::class, 'showSetup'])->name('pin.setup.show');
    Route::post('/pin-setup', [PinLoginController::class, 'setup'])->name('pin.setup.store');
    Route::post('/pin-remove', [PinLoginController::class, 'remove'])->name('pin.remove');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Items routes
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::post('/items/bulk-sync', [ItemController::class, 'bulkSync'])->name('items.bulk-sync');
    
    // Cart routes
    Route::get('/cart', [CartHistoryController::class, 'index'])->name('cart.index');
    
    // Cart History API routes
    Route::post('/cart/add', [CartHistoryController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/{cartId}', [CartHistoryController::class, 'updateCartItem'])->name('cart.update');
    Route::post('/cart/{cartId}/done', [CartHistoryController::class, 'markAsDone'])->name('cart.done');
    Route::delete('/cart/{cartId}', [CartHistoryController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/active', [CartHistoryController::class, 'getActiveCartItems'])->name('cart.active');
    
    // Debug page
    Route::get('/debug-cart-relations', function () {
        return Inertia::render('Debug/CartItemRelations');
    })->name('debug.cart-relations');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/test.php';

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/test.php';
