<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialEvent;

class FinancialEventsController extends Controller
{
    
    public function index(Request $request) {
    $query = FinancialEvent::where('user_id', auth()->id());
    if ($request->query('type')) {
    $query->where('type', $request->query('type'));
}
   
    return $query
    ->orderByRaw('event_date DESC')
    ->orderBy('id', 'desc')
    ->get();
}

}