<?php

namespace App\Http\Controllers;

use App\Models\FinancialEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = FinancialEvent::where('user_id', auth()->id())
            ->orderBy('event_date', 'desc')
            ->get();

        return response()->json($events);
    }
}