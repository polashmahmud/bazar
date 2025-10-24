<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroceryItemResource;
use App\Http\Resources\GroceryListResource;
use App\Models\GroceryItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroceryIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $items = GroceryItemResource::collection(GroceryItem::inRandomOrder()->limit(6)->get());
        $addedItems = GroceryListResource::collection($request->user()->groceryLists()->with('item')->get());

        return Inertia::render('groceries/Create', [
            'items' => $items,
            'addedItems' => $addedItems,
        ]);
    }
}
