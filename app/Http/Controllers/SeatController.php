<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeatRequest;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SeatController extends Controller
{
    public function index(Seat $seat)
    {
        $seats = Seat::with('tickets')->get();

        foreach ($seats as $seat) {
            $seat->ticket_count = $seat->tickets->count();
        }

        return view('components.edit-seat', ['seats' => $seats]);
    }

    public function store(Seat $seat, SeatRequest $seatRequest)
    {
        $validated = $seatRequest->validated();
        Seat::create($validated);


        return redirect()->route('seat.index');
    }

    public function edit(Seat $seat){
        return view('components.update-seat', ['seat' => $seat]);
    }

    public function update(Seat $seat, SeatRequest $seatRequest){
        $validated = $seatRequest->validated();
        $seat->update($validated);


        return redirect()->route('seat.index');
    }

    public function destroy(Seat $seat)
    {

        $hasTicet = $seat->tickets()->exists();

        if ($hasTicet) {
            return back()->withErrors(['err' => 'Ez a szék nem törölhető, mert már vettek rá jegyet']);
        }

        $seat->delete();

        return redirect()->route('seat.index');


    }

    public function show(Seat $seat)
    {
        Gate::authorize('update', $seat);
        return redirect()->route('seat.edit', $seat);
    }
}
