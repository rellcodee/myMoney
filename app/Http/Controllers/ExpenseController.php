<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExpenseService;
use Illuminate\Validation\Rule;
use App\Models\FinancialEvent;
use App\Models\Account;
class ExpenseController extends Controller
{
    public function store(Request $request, ExpenseService $service)
    {
        $account = Account::findOrFail($request->account_id);

        if ($request->amount > $account->balance) {
            return response()->json([
                'message' => 'Saldo tidak cukup'
            ], 422);
        }
        $userId = $request->user()->id; // Replace with actual authenticated user ID
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'category_id' => ['required',Rule::exists('categories','id')->where('user_id', $userId)],
            'note' => 'nullable|string'
        ]);

        $service->createExpense(
            $request->user()->id,
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