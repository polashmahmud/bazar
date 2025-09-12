<?php

use App\Http\Controllers\CartHistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PinAuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// PIN Authentication Routes
Route::get('/', [PinAuthController::class, 'showPinForm'])->name('pin.form');
Route::post('/pin-verify', [PinAuthController::class, 'verifyPin'])->name('pin.verify');
Route::post('/pin-logout', [PinAuthController::class, 'logout'])->name('pin.logout');

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
    Route::get('/cart', function() {
        return Inertia::render('Cart/Index');
    })->name('cart.index');
    
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
