<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllocationProfile;
use App\Models\AllocationRule;
use Illuminate\Support\Facades\DB;

class AllocationProfileController extends Controller
{
    public function store(Request $req)
    {
        $req->validate([
            'rules' => 'required|array|min:1',
            'rules.*.account_id' => 'required|exists:accounts,id',
            'rules.*.percentage' => 'required|numeric|min:1'
        ]);

        DB::transaction(function () use ($req) {

            $old = AllocationProfile::where('user_id', $req->user()->id)
                ->where('is_active', true)
                ->first();

            if ($old) {
                $old->update(['is_active' => false]);
            }

            $profile = AllocationProfile::create([
                'user_id' => $req->user()->id,
                'version' => ($old->version ?? 0) + 1,
                'is_active' => true
            ]);

            foreach ($req->rules as $r) {

                $account = \App\Models\Account::find($r['account_id']);

                AllocationRule::create([
                    'allocation_profile_id' => $profile->id,
                    'target_account_id' => $r['account_id'],
                    'percentage' => $r['percentage'],
                    'name' => $account->name // 🔥 FIX AUTO NAME
                ]);
            }
        });

        return response()->json(['message' => 'Profile created']);
    }

    public function active(Request $req)
    {
        return AllocationProfile::with('rules')
            ->where('user_id', $req->user()->id)
            ->where('is_active', true)
            ->first();
    }
}