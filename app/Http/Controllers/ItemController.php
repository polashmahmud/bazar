<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $items = Item::orderBy('created_at', 'desc')->get();

        return Inertia::render('Items/Index', [
            'items' => $items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'sometimes|numeric|min:0',
            'quantity_unit' => 'sometimes|string|max:50',
            'image' => 'nullable|string', // Base64 encoded image or URL
            'price' => 'sometimes|numeric|min:0',
            'month' => 'required|string|date_format:Y-m',
        ]);

        // Set defaults for missing fields
        $validated['quantity'] = $validated['quantity'] ?? 1;
        $validated['quantity_unit'] = $validated['quantity_unit'] ?? 'পিস';
        $validated['price'] = $validated['price'] ?? 0;

        $item = auth()->user()->items()->create([
            ...$validated,
            'synced_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        // Ensure user can only update their own items
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|numeric|min:0',
            'quantity_unit' => 'sometimes|string|max:50',
            'image' => 'nullable|string', // Base64 encoded image or URL
            'price' => 'sometimes|numeric|min:0',
            'month' => 'sometimes|string|date_format:Y-m',
            'is_done' => 'sometimes|boolean',
        ]);

        $item->update([
            ...$validated,
            'synced_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'item' => $item->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        // Ensure user can only delete their own items
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Bulk sync items from offline storage
     */
    public function bulkSync(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string|max:255',
            'items.*.quantity' => 'sometimes|numeric|min:0',
            'items.*.quantity_unit' => 'sometimes|string|max:50',
            'items.*.image' => 'nullable|string', // Base64 encoded image or URL
            'items.*.price' => 'sometimes|numeric|min:0',
            'items.*.month' => 'required|string|date_format:Y-m',
            'items.*.is_done' => 'sometimes|boolean',
            'items.*.offline_id' => 'required|string', // Temporary ID from offline storage
        ]);

        $syncedItems = [];
        
        foreach ($validated['items'] as $itemData) {
            $offlineId = $itemData['offline_id'];
            unset($itemData['offline_id']);
            
            // Set defaults for missing fields
            $itemData['quantity'] = $itemData['quantity'] ?? 1;
            $itemData['quantity_unit'] = $itemData['quantity_unit'] ?? 'পিস';
            $itemData['price'] = $itemData['price'] ?? 0;
            
            $item = auth()->user()->items()->create([
                ...$itemData,
                'synced_at' => now(),
            ]);
            
            $syncedItems[] = [
                'offline_id' => $offlineId,
                'server_item' => $item,
            ];
        }

        return response()->json([
            'success' => true,
            'synced_items' => $syncedItems,
        ]);
    }
}
