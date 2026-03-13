<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function transactions($accountId)
{
    $transactions = AccountTransaction::with('financialEvent')
        ->where('account_id', $accountId)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($tx) {
            return [
                'type' => $tx->financialEvent->type,
                'direction' => $tx->type == 'debit' ? 'out' : 'in',
                'amount' => $tx->amount,
                'note' => $tx->financialEvent->note,
                'date' => $tx->financialEvent->event_date
            ];
        });

    return response()->json($transactions);
}
public function index()
{
    $accounts = \App\Models\Account::where('user_id', 2)
        ->where('is_active', true)
        ->get(['id','name','type','balance']);

    return response()->json($accounts);
}
public function summary()
{
    $accounts = \App\Models\Account::where('user_id', 2)
        ->where('is_active', true)
        ->get(['id','name','type','balance']);

    $total = $accounts->sum('balance');

    return response()->json([
        'total_balance' => $total,
        'accounts' => $accounts
    ]);
}
}