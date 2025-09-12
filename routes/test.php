<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebugController;

// Test route to check authentication
Route::get('/test-auth', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'user_id' => auth()->id(),
        'user' => auth()->user() ? auth()->user()->toArray() : null,
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token(),
    ]);
});

// Test route to create item without auth middleware
Route::post('/test-item', function (\Illuminate\Http\Request $request) {
    try {
        \Log::info('Test Item Request', [
            'user_id' => auth()->id(),
            'user_authenticated' => auth()->check(),
            'request_data' => $request->all(),
            'session_id' => session()->getId(),
            'headers' => $request->headers->all()
        ]);

        if (!auth()->check()) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $item = auth()->user()->items()->create([
            'name' => $request->name ?? 'Test Item',
            'quantity' => 1,
            'quantity_unit' => 'পিস',
            'price' => 0,
            'month' => '2025-01',
            'synced_at' => now(),
        ]);

        return response()->json(['success' => true, 'item' => $item]);
    } catch (\Exception $e) {
        \Log::error('Test Item Error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Debug routes
Route::middleware(['auth'])->prefix('debug')->group(function () {
    // Frontend error logging
    Route::post('/log', [DebugController::class, 'logFrontendError']);
    
    // Cart and Item relationship debugging
    Route::get('/cart-item-relationship', [DebugController::class, 'debugCartItemRelationship']);
    
    // Test marking an item as done
    Route::post('/test-mark-item-done', [DebugController::class, 'testMarkAsDone']);
    
    // Test marking a cart item as done
    Route::post('/test-mark-cart-item-done', [DebugController::class, 'testMarkCartItemAsDone']);
});

// Legacy route for backwards compatibility
Route::post('/debug-log', [DebugController::class, 'logFrontendError']);
