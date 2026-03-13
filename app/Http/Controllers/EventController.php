<?php

namespace App\Http\Controllers;

use App\Models\FinancialEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = FinancialEvent::where('user_id', 2)
            ->orderBy('event_date', 'desc')
            ->get();

        return response()->json($events);
    }
}