<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('event_date_at', '>', now())->orderBy('event_date_at', 'asc')->simplePaginate(5);
        return view('welcome', ['events' => $events]);
    }

    public function show(Event $event)
    {
        return view('show', ['event' => $event]);
    }
}
