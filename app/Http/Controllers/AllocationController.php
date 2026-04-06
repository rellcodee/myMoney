<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AllocationService;
use App\Models\Allocation;

class AllocationController extends Controller
{
    // ✅ POST (CREATE ALLOCATION)
    public function store(Request $request, AllocationService $service)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'profile_id' => 'required|exists:allocation_profiles,id'
        ]);

        $allocation = $service->allocate(
            $request->user()->id,
            $request->amount,
            $request->profile_id
        );

        return response()->json([
            'message' => 'Allocation success',
            'data' => $allocation
        ]);
    }

    // ✅ GET LIST (HISTORY)
    public function index(Request $request)
    {
        $allocations = Allocation::with('items.account')
            ->where('user_id', $request->user()->id)
            ->latest() // 🔥 terbaru dulu
            ->get();

        return response()->json($allocations);
    }

    // ✅ GET DETAIL
    public function show(Request $request, $id)
    {
        $allocation = Allocation::with('items.account')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($allocation);
    }
}