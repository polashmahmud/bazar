<?php

namespace App\Http\Controllers;

use App\Models\GroceryList;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $items = $request->user()->groceryLists()->get();

        return Inertia::render('Dashboard', [
            'items'=> $items
        ]);
    }
}
