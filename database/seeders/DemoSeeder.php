<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Account;
use App\Models\AllocationProfile;
use App\Models\AllocationRule;

class DemoSeeder extends Seeder
{
    public function run(): void
    {

        $user = User::create([
            'name' => 'Demo User',
            'email' => 'demo@mymoney.app',
            'password' => bcrypt('password')
        ]);

        $wallet = Account::create([
            'user_id' => $user->id,
            'name' => 'Wallet',
            'type' => 'wallet',
            'balance' => 0,
            'is_active' => true
        ]);

        $saving = Account::create([
            'user_id' => $user->id,
            'name' => 'Tabungan',
            'type' => 'saving',
            'balance' => 0,
            'is_active' => true
        ]);

        $invest = Account::create([
            'user_id' => $user->id,
            'name' => 'Investasi',
            'type' => 'investment',
            'balance' => 0,
            'is_active' => true
        ]);

        $remaining = Account::create([
            'user_id' => $user->id,
            'name' => 'Sisa',
            'type' => 'goal',
            'balance' => 0,
            'is_active' => true
        ]);
        
        $profile = AllocationProfile::create([
            'user_id' => $user->id,
            'version' => 1,
            'is_active' => true
        ]);

        AllocationRule::create([
            'allocation_profile_id' => $profile->id,
            'name' => 'Tabungan',
            'percentage' => 50,
            'target_account_id' => $saving->id
        ]);

        AllocationRule::create([
            'allocation_profile_id' => $profile->id,
            'name' => 'Investasi',
            'percentage' => 30,
            'target_account_id' => $invest->id
        ]);

        AllocationRule::create([
            'allocation_profile_id' => $profile->id,
            'name' => 'Sisa',
            'percentage' => 20,
            'target_account_id' => $remaining->id
        ]);
    }
}