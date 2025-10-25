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
        $user = $request->user();

        // Get all grocery items for current user
        $totalItems = GroceryList::where('user_id', $user->id)->count();

        // Get purchased items count
        $purchasedItems = GroceryList::where('user_id', $user->id)
            ->where('purchased', true)
            ->count();

        // Get remaining items count
        $remainingItems = $totalItems - $purchasedItems;

        // Get this month's total expense
        $monthlyExpense = GroceryList::where('user_id', $user->id)
            ->where('purchased', true)
            ->whereMonth('purchase_date', now()->month)
            ->whereYear('purchase_date', now()->year)
            ->get()
            ->sum(function ($item) {
                return $item->price * $item->quantity;
            });

        // Get top expense categories for this month
        $topExpenseItems = GroceryList::where('user_id', $user->id)
            ->where('purchased', true)
            ->whereMonth('purchase_date', now()->month)
            ->whereYear('purchase_date', now()->year)
            ->with('item')
            ->get()
            ->groupBy('grocery_item_id')
            ->map(function ($items) {
                $total = $items->sum(function ($item) {
                    return $item->price * $item->quantity;
                });

                return [
                    'name' => $items->first()->item->name_bn,
                    'total' => $total,
                ];
            })
            ->sortByDesc('total')
            ->take(2)
            ->values();

        // Get last week's finished item (for suggestion)
        $lastWeekFinishedItem = GroceryList::where('user_id', $user->id)
            ->where('purchased', true)
            ->whereBetween('purchase_date', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->with('item')
            ->orderBy('purchase_date', 'desc')
            ->first();

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalItems' => $totalItems,
                'purchasedItems' => $purchasedItems,
                'remainingItems' => $remainingItems,
                'monthlyExpense' => number_format($monthlyExpense, 0),
                'topExpenseItems' => $topExpenseItems,
                'lastWeekFinishedItem' => $lastWeekFinishedItem ? $lastWeekFinishedItem->item->name_bn : null,
            ],
        ]);
    }
}
