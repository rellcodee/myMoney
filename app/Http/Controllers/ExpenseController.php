<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExpenseService;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    public function store(Request $request, ExpenseService $service)
    {
        $userId = 2; // Replace with actual authenticated user ID
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'category_id' => ['required',Rule::exists('categories','id')->where('user_id', $userId)],
            'note' => 'nullable|string'
        ]);

        $service->createExpense(
            2,
            $request->account_id,
            $request->amount,
            $request->category_id,
            $request->note
        );

        return response()->json([
            'message' => 'Expense recorded'
        ]);
    }
}