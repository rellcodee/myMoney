<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IncomeService;

class IncomeController extends Controller
{
    public function store(Request $request, IncomeService $incomeService)
    {
         $request->validate([
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string'
        ]);

        $incomeService->createIncome(
            2,
            $request->amount,
            $request->note
        );

        return back()->with('success', 'Income added');
    }
}