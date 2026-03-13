<?php

namespace App\Services;

use App\Models\Account;
use App\Models\FinancialEvent;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;

class ExpenseService
{
    public function createExpense($userId, $accountId, $amount, $categoryId, $note = null)
    {
        return DB::transaction(function () use ($userId, $accountId, $amount, $categoryId, $note) {

            if ($amount <= 0) {
                throw new \Exception("Amount must be positive");
            }

            $account = Account::where('id', $accountId)
                ->where('user_id', $userId)
                ->where('is_active', true)
                ->first();

            if (!$account) {
                throw new \Exception("Account not found");
            }

            if ($account->balance < $amount) {
                throw new \Exception("Insufficient balance");
            }
            if ($account->type === 'wallet') {
                throw new \Exception("Wallet cannot be used for expense. Allocate first.");
            }

            $event = FinancialEvent::create([
                'user_id' => $userId,
                'type' => 'expense',
                'amount' => $amount,
                'category_id' => $categoryId,
                'event_date' => now(),
                'note' => $note ?? "Expense"
            ]);

            AccountTransaction::create([
                'account_id' => $account->id,
                'financial_event_id' => $event->id,
                'type' => 'debit',
                'amount' => $amount
            ]);

            $account->balance -= $amount;
            $account->save();

            return $event;
        });
    }
}