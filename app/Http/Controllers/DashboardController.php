<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FinancialEvent;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = 2;

        // total balance semua account
        $totalBalance = Account::where('user_id', $userId)
            ->where('is_active', true)
            ->sum('balance');

        // income bulan ini
        $incomeThisMonth = FinancialEvent::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('event_date', now()->month)
            ->sum('amount');

        // expense bulan ini
        $expenseThisMonth = FinancialEvent::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('event_date', now()->month)
            ->sum('amount');

        // recent activity
        $recentEvents = FinancialEvent::where('user_id', $userId)
            ->orderBy('event_date', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'total_balance' => $totalBalance,
            'income_this_month' => $incomeThisMonth,
            'expense_this_month' => $expenseThisMonth,
            'recent_events' => $recentEvents
        ]);
    }
}