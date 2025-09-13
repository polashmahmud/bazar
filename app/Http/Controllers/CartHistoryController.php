<?php

namespace App\Http\Controllers;

use App\Models\CartHistory;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartHistoryController extends Controller
{
    /**
     * Display the cart page with active cart items
     */
    public function index()
    {
        $activeCartItems = CartHistory::where('user_id', Auth::id())
            ->where('is_done', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Cart/Index', [
            'initialCartItems' => $activeCartItems,
            'user' => Auth::user()
        ]);
    }

    /**
     * Add item to cart history
     */
    public function addToCart(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'cart_id' => 'required|string|unique:cart_histories,cart_id',
            'quantity' => 'numeric|min:0.01',
            'quantity_unit' => 'string|max:50',
            'price' => 'numeric|min:0',
            'month' => 'required|string|date_format:Y-m',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        $cartHistory = CartHistory::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(), // Add user_id to cart history
            'cart_id' => $validated['cart_id'],
            'name' => $item->name,
            'image' => $item->image,
            'quantity' => $validated['quantity'] ?? 1,
            'quantity_unit' => $validated['quantity_unit'] ?? 'পিস',
            'price' => $validated['price'] ?? 0,
            'month' => $validated['month'],
        ]);

        return response()->json([
            'success' => true,
            'cart_item' => $cartHistory
        ], 200, [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Update cart item
     */
    public function updateCartItem(Request $request, string $cartId): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => 'nullable|numeric|min:0.01',
            'quantity_unit' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
        ]);

        $cartItem = CartHistory::where('cart_id', $cartId)->firstOrFail();
        
        // Ensure user can only update their own cart items
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'You can only update your own cart items');
        }
        
        $cartItem->update(array_filter($validated));
        
        // If price is updated and there's a linked item, update the item's price too
        if (isset($validated['price']) && $cartItem->item_id) {
            $item = $cartItem->item;
            if ($item && $item->user_id === Auth::id()) {
                $item->update([
                    'price' => $validated['price']
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'cart_item' => $cartItem
        ]);
    }

    /**
     * Mark cart item as done
     */
    public function markAsDone(string $cartId): JsonResponse
    {
        $cartItem = CartHistory::where('cart_id', $cartId)->firstOrFail();
        
        // Ensure user can only mark their own cart items as done
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'You can only mark your own cart items as done');
        }
        
        $cartItem->markAsDone();

        return response()->json([
            'success' => true,
            'cart_item' => $cartItem
        ]);
    }

    /**
     * Remove cart item
     */
    public function removeFromCart(string $cartId): JsonResponse
    {
        $cartItem = CartHistory::where('cart_id', $cartId)->firstOrFail();
        
        // Ensure user can only remove their own cart items
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'You can only remove your own cart items');
        }
        
        $cartItem->delete();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Get active cart items
     */
    public function getActiveCartItems(): JsonResponse
    {
        // Only show cart items belonging to the authenticated user
        $cartItems = CartHistory::where('user_id', Auth::id())
            ->where('is_done', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($cartItems);
    }
}
