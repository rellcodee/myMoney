<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IncomeService;
use App\Models\FinancialEvent;
class IncomeController extends Controller
{
    public function store(Request $request, IncomeService $incomeService)
    {
         $request->validate([
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string'
        ]);

        $incomeService->createIncome(
            $request->user()->id,
            $request->amount,
            $request->note
        );

        return response()->json([
            'message' => 'Income added'
        ]);
    }

}