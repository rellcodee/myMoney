<?php

namespace App\Services;

use App\Models\Account;
use App\Models\FinancialEvent;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;

class TransferService {
    public function createTransfer($userId, $fromAccountId, $toAccountId, $amount, $note = null){
            return DB::transaction(function () use ($userId, $fromAccountId, $toAccountId, $amount, $note){
            if ($amount <= 0) {
                throw new \Exception("Amount must be positive");
                }
            $fromAccount = Account::where('id', $fromAccountId)
                ->where('user_id', $userId)
                ->where('is_active', true)
                ->first();
            $toAccount = Account::where('id', $toAccountId)
                ->where('user_id', $userId)
                ->where('is_active', true)
                ->first();

            if (!$fromAccount || !$toAccount) {
                throw new \Exception("One or both accounts not found");
                }
            if ($fromAccount->id === $toAccount->id) {
                throw new \Exception("Cannot transfer to the same account");
                }

            if ($fromAccount->balance < $amount) {
                throw new \Exception("Insufficient balance in source account");
                }

            $event = FinancialEvent::create([
                'user_id' => $userId,
                'type' => 'transfer',
                'amount' => $amount,
                'event_date' => now(),
                'note' => $note
            ]);

            AccountTransaction::create([
                'account_id' => $fromAccount->id,
                'financial_event_id' => $event->id,
                'type' => 'debit',
                'amount' => $amount
            ]);
            AccountTransaction::create([
                'account_id' => $toAccount->id,
                'financial_event_id' => $event->id,
                'type' => 'credit',
                'amount' => $amount
            ]);
            $fromAccount->balance -= $amount;
            $toAccount->balance += $amount;
            $fromAccount->save();
            $toAccount->save();
            return $event;
            });
        
    }
}