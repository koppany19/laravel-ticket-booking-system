<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Seat;
use Illuminate\Http\Request;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index() {
        $numberOfEvents = Event::count();

        $numberOfSoldTickets = Ticket::count();

        $numberOfIncome = Ticket::sum('price');

        $topSeats = Seat::all()->map(function ($seat) {
            $seat->total = Ticket::where('seat_id', $seat->id)->count();
            return $seat;
        })->sortByDesc('total')->take(3)->values();

        $events = Event::orderBy('event_date_at', 'desc')->simplePaginate(5);

        $totalSeats = Seat::count();

        return view('components.dashboard', [
            'numberOfEvents' => $numberOfEvents,
            'numberOfSoldTickets' => $numberOfSoldTickets,
            'numberOfIncome' => $numberOfIncome,
            'topSeats' => $topSeats,
            'events' => $events,
            'totalSeats' => $totalSeats,
        ]);
    }

    public function create() {
        Gate::authorize('create', Event::class);
        return view('components.create-event');
    }

    public function store(EventStoreRequest $request) {
        Gate::authorize('create', Event::class);
        $validated = $request->validated();
        $validated['is_dynamic_price'] = $request->has('is_dynamic_price');

        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('img/'. $fileName, $file->getContent());
            $validated['image'] = 'img/' . $fileName;
        }

        Event::create($validated);


        return redirect()->route('dashboard');
    }

    public function edit(Event $event) {
        Gate::authorize('update', $event);
        return view('components.edit-event', ['event' => $event]);
    }

    public function update(EventStoreRequest $request, Event $event) {
        Gate::authorize('update', $event);
        $validated = $request->validated();

        if($event->sale_start_at <= now())
        {
            unset($validated['event_date_at']);
            unset($validated['sale_start_at']);
            unset($validated['sale_end_at']);
            unset($validated['max_number_allowed']);
        } else{
            $validated['is_dynamic_price'] = $request->has('is_dynamic_price');
        }

        if ($request->hasFile('image')) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
            $file = $request->file('image');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('images/' . $fileName, $file->getContent());

            $validated['image'] = 'images/' . $fileName;
        }
        $event->update($validated);


        return redirect()->route('dashboard');

    }

    public function destroy(Event $event) {
        if($event->tickets()->count() > 0){
            return back()->withErrors(['err' => 'Nem törölhető, mert erre az eseményre már vettek jegyet']);
        }
        if($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }


        $event->delete();
        return redirect()->route('dashboard');
    }

    public function show(Event $event)
    {
        Gate::authorize('view', $event);
        return redirect()->route('events.edit', $event);
    }
}
