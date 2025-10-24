<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroceryItemResource;
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

        return Inertia::render('groceries/Create', [
            'items' => $items,
        ]);
    }
}
