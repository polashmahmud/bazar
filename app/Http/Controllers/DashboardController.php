<?php

namespace App\Http\Controllers;

use App\Models\CartHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with analytics
     */
    public function index(Request $request): Response
    {
        $month = $request->get('month', now()->format('Y-m'));
        
        // Get done cart items for the selected month (only for authenticated user)
        $doneItems = CartHistory::where('user_id', Auth::id())
            ->forMonth($month)
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
            'user' => $request->user()->only(['id', 'name', 'email', 'pin_code']),
        ]);
    }

    /**
     * Calculate monthly summary
     */
    private function calculateMonthlySummary(string $month): array
    {
        $doneItems = CartHistory::where('user_id', Auth::id())
            ->forMonth($month)
            ->done()
            ->get();

        $totalItems = $doneItems->count();
        $totalQuantity = $doneItems->sum('quantity');

        return [
            'total_items' => $totalItems,
            'total_quantity' => $totalQuantity,
            'month' => $month,
            'month_name' => Carbon::createFromFormat('Y-m', $month)->format('F Y'),
        ];
    }

    /**
     * Calculate yearly comparison data (item counts)
     */
    private function calculateYearlyComparison(): array
    {
        $months = [];
        $currentYear = now()->year;
        
        for ($i = 1; $i <= 12; $i++) {
            $month = sprintf('%d-%02d', $currentYear, $i);
            
            $monthlyItems = CartHistory::where('user_id', Auth::id())
                ->forMonth($month)
                ->done()
                ->count();

            $months[] = [
                'month' => $month,
                'month_name' => Carbon::createFromFormat('Y-m', $month)->format('M'),
                'items' => $monthlyItems,
            ];
        }

        return $months;
    }
}
