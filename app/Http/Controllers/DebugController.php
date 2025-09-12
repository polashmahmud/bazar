<?php

namespace App\Http\Controllers;

use App\Models\CartHistory;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DebugController extends Controller
{
    public function logFrontendError(Request $request)
    {
        Log::info('Frontend Debug Info', [
            'type' => $request->type,
            'message' => $request->message,
            'data' => $request->data,
            'timestamp' => now(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json(['logged' => true]);
    }
    
    /**
     * Debug the relationship between cart histories and items
     */
    public function debugCartItemRelationship(Request $request): JsonResponse
    {
        $cartId = $request->input('cart_id');
        $itemId = $request->input('item_id');
        
        $result = [];
        
        // Check cart item if cart_id is provided
        if ($cartId) {
            $cartItem = CartHistory::where('cart_id', $cartId)->first();
            if ($cartItem) {
                $result['cart_item'] = $cartItem->toArray();
                
                // Get related item
                $relatedItem = $cartItem->item;
                $result['related_item'] = $relatedItem ? $relatedItem->toArray() : null;
                
                // Check relationship integrity
                $result['relationship_status'] = [
                    'has_valid_item_id' => !empty($cartItem->item_id),
                    'related_item_exists' => $relatedItem !== null,
                    'item_link_valid' => $relatedItem && $relatedItem->id == $cartItem->item_id
                ];
            } else {
                $result['error'] = "Cart item with cart_id {$cartId} not found";
            }
        }
        
        // Check item if item_id is provided
        if ($itemId) {
            $item = Item::find($itemId);
            if ($item) {
                $result['item'] = $item->toArray();
                
                // Get related cart histories
                $relatedCartHistories = CartHistory::where('item_id', $itemId)->get();
                $result['related_cart_histories'] = $relatedCartHistories->toArray();
                
                // Check relationship integrity
                $result['relationship_status'] = [
                    'related_cart_history_count' => $relatedCartHistories->count(),
                    'cart_histories_with_same_done_status' => $relatedCartHistories->where('is_done', $item->is_done)->count(),
                    'cart_histories_with_different_done_status' => $relatedCartHistories->where('is_done', '!=', $item->is_done)->count(),
                ];
            } else {
                $result['error'] = "Item with id {$itemId} not found";
            }
        }
        
        // If neither provided, return some general statistics
        if (!$cartId && !$itemId) {
            $result['statistics'] = [
                'total_items' => Item::count(),
                'done_items' => Item::where('is_done', true)->count(),
                'not_done_items' => Item::where('is_done', false)->count(),
                'total_cart_histories' => CartHistory::count(),
                'done_cart_histories' => CartHistory::where('is_done', true)->count(),
                'not_done_cart_histories' => CartHistory::where('is_done', false)->count(),
            ];
            
            // Check for potential inconsistencies
            $inconsistentItems = Item::whereHas('cartHistory', function ($query) {
                $query->whereColumn('items.is_done', '!=', 'cart_histories.is_done');
            })->count();
            
            $result['inconsistencies'] = [
                'items_with_inconsistent_done_status' => $inconsistentItems,
            ];
        }
        
        return response()->json($result);
    }
    
    /**
     * Test marking an item as done and check if related cart histories are updated
     */
    public function testMarkAsDone(Request $request): JsonResponse
    {
        $itemId = $request->input('item_id');
        
        if (!$itemId) {
            return response()->json(['error' => 'Item ID is required'], 400);
        }
        
        $item = Item::find($itemId);
        
        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }
        
        // Get before state
        $beforeState = [
            'item' => $item->toArray(),
            'cart_histories' => CartHistory::where('item_id', $itemId)->get()->toArray()
        ];
        
        // Mark item as done
        $item->markAsDone($request->input('price'));
        
        // Get after state
        $afterState = [
            'item' => Item::find($itemId)->toArray(),
            'cart_histories' => CartHistory::where('item_id', $itemId)->get()->toArray()
        ];
        
        return response()->json([
            'before' => $beforeState,
            'after' => $afterState,
            'price_updated' => $request->has('price'),
            'price_value' => $request->input('price')
        ]);
    }
    
    /**
     * Test marking a cart item as done and check if related item is updated
     */
    public function testMarkCartItemAsDone(Request $request): JsonResponse
    {
        $cartId = $request->input('cart_id');
        
        if (!$cartId) {
            return response()->json(['error' => 'Cart ID is required'], 400);
        }
        
        $cartItem = CartHistory::where('cart_id', $cartId)->first();
        
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }
        
        // Get before state
        $beforeState = [
            'cart_item' => $cartItem->toArray(),
            'related_item' => $cartItem->item ? $cartItem->item->toArray() : null
        ];
        
        // Mark cart item as done
        $cartItem->markAsDone();
        
        // Update related item if exists
        if ($cartItem->item_id && $cartItem->item) {
            $cartItem->item->update([
                'is_done' => true,
                'price' => $cartItem->price
            ]);
        }
        
        // Get after state
        $afterState = [
            'cart_item' => CartHistory::where('cart_id', $cartId)->first()->toArray(),
            'related_item' => $cartItem->item ? Item::find($cartItem->item_id)->toArray() : null
        ];
        
        return response()->json([
            'before' => $beforeState,
            'after' => $afterState
        ]);
    }
}
