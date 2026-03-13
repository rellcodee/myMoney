<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransferService;

class TransferController extends Controller {
    public function transfer(Request $request, TransferService $service)
    {
       $request->validate([
       'from_account_id' => 'required|exists:accounts,id',
       'to_account_id' => 'required|exists:accounts,id',
       'amount' => 'required|numeric|min:1',
       'note' => 'nullable|string'
       ]);

       $service->createTransfer(
        2,
        $request->from_account_id,
        $request->to_account_id,
        $request->amount,
        $request->note
       );
         return response()->json([
          'message' => 'Transfer successful'
         ]);

    }
}