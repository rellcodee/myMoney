<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    public function transactions($accountId)
{
    $transactions = AccountTransaction::with('financialEvent')
        ->where('account_id', $accountId)
        ->whereHas('account', function ($q) {
        $q->where('user_id', auth()->id());
        })
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
    $accounts = Account::where('user_id', auth()->id())
        ->where('is_active', true)
        ->get(['id','name','type','balance']);

    return response()->json($accounts);
}
public function summary()
{
    $accounts = Account::where('user_id', auth()->id())
        ->where('is_active', true)
        ->get(['id','name','type','balance']);

    $total = $accounts->sum('balance');

    return response()->json([
        'total_balance' => $total,
        'accounts' => $accounts
    ]);
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:saving,investment,goal',
        'target_amount' => 'required_if:type,goal|numeric|min:0',
        'target_date' => 'nullable|date'
    ]);


      if ($request->type === 'wallet') {
        $existingWallet = Account::where('user_id', auth()->id())
            ->where('type', 'wallet')
            ->exists();

        if ($existingWallet) {
            return response()->json([
                'message' => 'Wallet already exists'
            ], 400);
        }
    }


    $account = Account::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'type' => $request->type,
        'balance' => 0,
        'is_active' => true,
        'target_amount' => $request->type === 'goal' ? $request->target_amount : null,
        'target_date' => $request->type === 'goal' ? $request->target_date : null,
    ]);

    return response()->json($account, 201);
}

public function showById($id)
{
    $account = Account::where('id', $id)
        ->where('user_id', auth()->id())
        ->first();
    if (!$account) {
        return response()->json(['message' => 'Account not found'], 404);
    };

    return response()->json($account);

}
public function toggle(Request $request, $id)
{
    $account = Account::where('user_id', $request->user()->id)
        ->findOrFail($id);

    $account->is_active = !$account->is_active;
    $account->save();

    return response()->json([
        'message' => 'Account updated',
        'data' => $account
    ]);
}
}