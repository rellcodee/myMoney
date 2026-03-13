<?php

namespace App\Services;

use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\FinancialEvent;
use Illuminate\Support\Facades\DB;
use App\Services\AllocationEngine;

class AllocationService
{
    public function allocate($userId, $amount, $profileId)
    {
        return DB::transaction(function () use ($userId, $amount, $profileId) {
            
            if ($amount <= 0) {
                throw new \Exception("Amount must be positive");
            }

            $wallet = Account::where('user_id', $userId)
                ->where('type', 'wallet')
                ->where('is_active', true)
                ->first();

            if (!$wallet) {
                throw new \Exception("Wallet not found");
            }

            if ($wallet->balance < $amount) {
                throw new \Exception("Insufficient wallet balance");
            }

            $event = FinancialEvent::create([
                'user_id' => $userId,
                'type' => 'income',
                'amount' => $amount,
                'allocation_profile_id' => $profileId,
                'event_date' => now()
            ]);

            $engine = new AllocationEngine();

            $results = $engine->process($profileId, $amount);

            // debit wallet
            $wallet->balance -= $amount;
            $wallet->save();

            AccountTransaction::create([
                'account_id' => $wallet->id,
                'financial_event_id' => $event->id,
                'type' => 'debit',
                'amount' => $amount
            ]);

            foreach ($results as $accountId => $value) {

                $account = Account::find($accountId);

                if (!$account) {
                    throw new \Exception("Target account not found");
                }

                $account->balance += $value;
                $account->save();

                AccountTransaction::create([
                    'account_id' => $account->id,
                    'financial_event_id' => $event->id,
                    'type' => 'credit',
                    'amount' => $value
                ]);
            }

            return $event;
        });
    }

    
}