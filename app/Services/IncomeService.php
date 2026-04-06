<?php

namespace App\Services;

use App\Models\FinancialEvent;
use App\Models\Account;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;

class IncomeService
{
    public function createIncome($userId, $amount, $note = null)
    {
        return DB::transaction(function () use ($userId, $amount, $note) {

            $wallet = Account::where('user_id', $userId)
                ->where('type', 'wallet')
                ->where('is_active', true)
                ->first();

            if (!$wallet) {
                $wallet = Account::create([
                    'user_id' => $userId,
                    'name' => 'Wallet',
                    'type' => 'wallet',
                    'balance' => 0,
                    'is_active' => true
                ]);
            }
            if ($amount <= 0) {
                throw new \Exception("Amount must be positive");
            }
            $event = FinancialEvent::create([
                'user_id' => $userId,
                'type' => 'income',
                'amount' => $amount,
                'event_date' => now(),
                'note' => $note ?? "Income"
            ]);

            AccountTransaction::create([
                'account_id' => $wallet->id,
                'financial_event_id' => $event->id,
                'type' => 'credit',
                'amount' => $amount
            ]);

            $wallet->balance += $amount;
            $wallet->save();

            return $event;
        });
    }
}