<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroceryItemResource;
use App\Models\GroceryItem;
use Illuminate\Http\Request;

class GrocerySearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $query = $request->input('query', '');

        $groceryItems = GroceryItem::search($query)
            ->limit(20)
            ->get();

        return GroceryItemResource::collection($groceryItems);
    }
}
