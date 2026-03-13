<?php

namespace App\Services;

use App\Models\AllocationRule;

class AllocationEngine
{
    public function process($profileId, $amount)
    {
        $rules = AllocationRule::where('allocation_profile_id', $profileId)->get();

        if ($rules->isEmpty()) {
            throw new \Exception("Allocation rules not found");
        }

        $totalPercentage = $rules->sum('percentage');

        if ($totalPercentage != 100) {
            throw new \Exception("Allocation percentage must equal 100%");
        }

        $results = [];

        foreach ($rules as $rule) {

            $value = ($rule->percentage / 100) * $amount;

            $results[$rule->target_account_id] = $value;
        }

        return $results;
    }
}