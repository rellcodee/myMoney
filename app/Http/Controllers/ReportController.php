<?php

namespace App\Http\Controllers;

use App\Models\FinancialEvent;

class ReportController extends Controller
{
    public function monthly()
    {
        $userId = 2;

        $income = FinancialEvent::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('event_date', now()->year)
            ->whereMonth('event_date', now()->month)
            ->sum('amount');

        $expense = FinancialEvent::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('event_date', now()->year)
            ->whereMonth('event_date', now()->month)
            ->sum('amount');

        return response()->json([
            'month' => now()->format('Y-m'),
            'income' => $income,
            'expense' => $expense,
            'saving' => $income - $expense
        ]);
    }
    public function expenseByCategory()
{
    $userId = 2;

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