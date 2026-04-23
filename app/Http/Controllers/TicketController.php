<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function create(Event $event)
    {
        $seats = Seat::all();
        $allTickets = $event->tickets;

        $takenSeat = [];
        $count = 0;

        foreach ($allTickets as $ticket) {
            $takenSeat[] = $ticket->seat_id;
            if ($ticket->user_id == auth()->id()) {
                $count++;
            }
        }

        $l = $event->max_number_allowed - $count;
        $limit = max(0, $l);

        $prod = 1.0;
        if ($event->is_dynamic_price) {
            $daysUntil = now()->diffInDays($event->event_date_at);
            $soldTickets = $allTickets->count();
            $totalSeats = Seat::count();

            $occupancy = ($totalSeats > 0) ? ($soldTickets / $totalSeats) : 0;

            $resz1 = 1 - 0.5 * (1 / ($daysUntil + 1));
            $resz2 = 1 + 0.5 * $occupancy;

            $prod = $resz1 * $resz2;
        }

        return view('components.buy-ticket', ['event' => $event, 'seats' => $seats, 'takenSeat' => $takenSeat, 'limit' => $limit, 'prod' => $prod]);
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'seats' => 'required|array',
        ]);
        $selectedSeat = $request->input('seats');

        $allTickets = $event->tickets;
        $countTicket = 0;

        foreach ($allTickets as $ticket) {
            if ($ticket->user_id == auth()->id()) {
                $countTicket++;
            }
        }

        if ($countTicket + count($selectedSeat) > $event->max_number_allowed) {
            return back()->withErrors(['seats' => "Tul sok jegy! Maximum {$event->max_number_allowed} megengedett"]);
        }


        $prod = 1;
        if ($event->is_dynamic_price) {
            $daysUntil = now()->diffInDays($event->event_date_at);
            $soldTickets = $allTickets->count();
            $totalSeats = Seat::count();

            $occupancy = ($totalSeats > 0) ? ($soldTickets / $totalSeats) : 0;

            $resz1 = 1 - 0.5 * (1 / ($daysUntil + 1));
            $resz2 = 1 + 0.5 * $occupancy;

            $prod = $resz1 * $resz2;
        }

        foreach ($selectedSeat as $seat) {
            $occupied = Ticket::where('event_id', $event->id)->where('seat_id', $seat)->exists();
            if ($occupied) {
                return back()->withErrors(['seats' => 'Elkelt ez a hely']);
            }
            $findSeat = Seat::find($seat);
            $finalPrice = $findSeat->base_price * $prod;

            $barcode = '';
            for ($i = 0; $i < 9; $i++) {
                $barcode .= rand(0, 9);
            }

            Ticket::create([
                'user_id' => auth()->id(),
                'event_id' => $event->id,
                'seat_id' => $seat,
                'price' => $finalPrice,
                'barcode' => $barcode,
                'admission_time' => null,
            ]);
        }
        return redirect()->route('my-tickets')->with('message', 'Sikeres vásárlás!');;
    }

    public function myTickets(){
        $tickets = auth()->user()->tickets()->with(['event', 'seat'])->get()->sortBy('event.event_date_at');
        $groupByTitle = $tickets->groupBy('event.title');
        return view('components.my-tickets', ['groupByTitle' => $groupByTitle]);
    }

}
