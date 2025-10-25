<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroceryListResource;
use App\Models\GroceryList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GroceryListController extends Controller
{
    /**
     * Display the grocery list.
     */
    public function index(Request $request)
    {
        $items = GroceryListResource::collection(
            $request->user()
                ->groceryLists()
                ->with('item')
                ->orderBy('purchased')
                ->get()
        );

        return Inertia::render('groceries/List', [
            'items' => $items,
        ]);
    }

    /**
     * Store a new grocery item to the user's list.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'grocery_item_id' => 'required|exists:grocery_items,id',
            'quantity' => 'required|numeric|min:0.01',
            'unit' => 'required|string|max:50',
        ]);

        $groceryList = GroceryList::create([
            'user_id' => Auth::id(),
            'grocery_item_id' => $validated['grocery_item_id'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
        ]);

        return redirect()->back()->with('success', 'আইটেম সফলভাবে যুক্ত হয়েছে!');
    }

    /**
     * Remove an item from the grocery list.
     */
    public function destroy(GroceryList $groceryList)
    {
        // Ensure user can only delete their own items
        if ($groceryList->user_id !== Auth::id()) {
            abort(403);
        }

        $groceryList->delete();

        return redirect()->back()->with('success', 'আইটেম মুছে ফেলা হয়েছে!');
    }

    /**
     * Mark an item as purchased.
     */
    public function purchase($id)
    {
        $item = GroceryList::findOrFail($id);
        $item->purchased = ! $item->purchased;
        $item->save();

        return back();
    }
}
