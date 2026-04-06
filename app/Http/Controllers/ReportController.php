<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FinancialEvent;
use App\Models\Account;
class ReportController extends Controller
{
    public function monthly()
    {
        $userId = auth()->id(); // Replace with actual authenticated user ID

        $data = FinancialEvent::selectRaw("
            DATE_FORMAT(event_date, '%Y-%m') as month,
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense
        ")
        ->where('user_id', $userId)
        ->whereYear('event_date', now()->year)
        ->groupBy('month')
        ->get();

    $result = $data->map(function ($item) {
        return [
            'month' => $item->month,
            'income' => (int) $item->income,
            'expense' => (int) $item->expense,
            'saving' => (int) $item->income - (int) $item->expense,
        ];
        
});
        return response()->json($result);
    }

    public function now() {
    $userId = auth()->id(); // Replace with actual authenticated user ID
    
        $data = FinancialEvent::selectRaw(
            "SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense"
        )
        ->where('user_id', $userId)
        ->whereYear('event_date', now()->year)
        ->whereMonth('event_date', now()->month)
        ->first();

        $balance = Account::where('user_id', $userId)->sum('balance');

  return response()->json([
        'month' => now()->format('Y-m'),
        'income' => (int) $data->income,
        'expense' => (int) $data->expense,
        'balance' => (int) $balance
    ]);

    }
    public function expenseByCategory()
{
    $userId = auth()->id(); // Replace with actual authenticated user ID

    $data = FinancialEvent::selectRaw('categories.name, SUM(financial_events.amount) as total')
    ->join('categories', 'categories.id', '=', 'financial_events.category_id')
    ->where('financial_events.user_id', $userId)
    ->where('financial_events.type', 'expense')
    ->whereYear('event_date', now()->year)
    ->whereMonth('event_date', now()->month)
    ->groupBy('categories.name')
    ->get();

    return response()->json($data);
}
    
}