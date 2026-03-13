<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AllocationService;

class AllocationController extends Controller
{
    public function allocate(Request $request, AllocationService $service)
    {
        $request->validate([
        'amount' => 'required|numeric|min:1',
        'profile_id' => 'required|exists:allocation_profiles,id'
    ]);
    
        $service->allocate(
            2,
            $request->amount,
            $request->profile_id
        );

        return back()->with('success', 'Money allocated');
    }
}