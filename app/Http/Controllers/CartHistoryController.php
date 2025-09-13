<?php

namespace App\Http\Controllers;

use App\Models\CartHistory;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartHistoryController extends Controller
{
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
        $cartItem->update(array_filter($validated));
        
        // If price is updated and there's a linked item, update the item's price too
        if (isset($validated['price']) && $cartItem->item_id) {
            $item = $cartItem->item;
            if ($item) {
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
        $cartItems = CartHistory::where('is_done', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($cartItems);
    }
}
