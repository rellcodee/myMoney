<?php

namespace App\Services;

use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\FinancialEvent;
use Illuminate\Support\Facades\DB;
use App\Services\AllocationEngine;
 use App\Models\Allocation;
use App\Models\AllocationItem;

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

        // 🔥 NEW → simpan allocation
        $allocation = Allocation::create([
            'user_id' => $userId,
            'allocation_profile_id' => $profileId,
            'amount' => $amount
        ]);

        // 🔥 event tetap dipakai
        $event = FinancialEvent::create([
            'user_id' => $userId,
            'type' => 'allocation', // 🔥 ubah dari income
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

            // 🔥 NEW → simpan breakdown
            AllocationItem::create([
                'allocation_id' => $allocation->id,
                'account_id' => $accountId,
                'amount' => $value
            ]);

            // credit account
            $account->balance += $value;
            $account->save();

            AccountTransaction::create([
                'account_id' => $account->id,
                'financial_event_id' => $event->id,
                'type' => 'credit',
                'amount' => $value
            ]);
        }

        return $allocation;
    });
}
}