<?php

namespace App\Http\Controllers;

use App\Models\CartHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with expense analytics
     */
    public function index(Request $request): Response
    {
        $month = $request->get('month', now()->format('Y-m'));
        
        // Get done cart items for the selected month
        $doneItems = CartHistory::forMonth($month)
            ->done()
            ->orderBy('done_at', 'desc')
            ->get();

        // Calculate monthly summary
        $monthlySummary = $this->calculateMonthlySummary($month);
        
        // Calculate yearly comparison
        $yearlyComparison = $this->calculateYearlyComparison();

        return Inertia::render('Dashboard/Index', [
            'doneItems' => $doneItems,
            'currentMonth' => $month,
            'monthlySummary' => $monthlySummary,
            'yearlyComparison' => $yearlyComparison,
        ]);
    }

    /**
     * Calculate monthly expense summary
     */
    private function calculateMonthlySummary(string $month): array
    {
        $doneItems = CartHistory::forMonth($month)
            ->done()
            ->get();

        $totalAmount = $doneItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $totalItems = $doneItems->count();
        $totalQuantity = $doneItems->sum('quantity');

        // Calculate average per item
        $averagePerItem = $totalItems > 0 ? $totalAmount / $totalItems : 0;

        return [
            'total_amount' => $totalAmount,
            'total_items' => $totalItems,
            'total_quantity' => $totalQuantity,
            'average_per_item' => $averagePerItem,
            'month' => $month,
            'month_name' => Carbon::createFromFormat('Y-m', $month)->format('F Y'),
        ];
    }

    /**
     * Calculate yearly comparison data
     */
    private function calculateYearlyComparison(): array
    {
        $months = [];
        $currentYear = now()->year;
        
        for ($i = 1; $i <= 12; $i++) {
            $month = sprintf('%d-%02d', $currentYear, $i);
            
            $monthlyExpense = CartHistory::forMonth($month)
                ->done()
                ->get()
                ->sum(function ($item) {
                    return $item->price * $item->quantity;
                });

            $months[] = [
                'month' => $month,
                'month_name' => Carbon::createFromFormat('Y-m', $month)->format('M'),
                'expense' => $monthlyExpense,
            ];
        }

        return $months;
    }
}
