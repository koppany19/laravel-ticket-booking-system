<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScanRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index(){
        return view('components.scanner');
    }

    public function scan(ScanRequest $request)
    {
        $barcode = $request->validated();
        $ticket = Ticket::where('barcode', $barcode)->first();

        if ($ticket->admission_time !== null) {
            return back()->withErrors([
                'err' => 'Ezt a jegyet már felhasználták ekkor: ' . $ticket->admission_time->format('Y. m. d.')
            ]);
        }

        $ticket->update(['admission_time' => now()]);


        return back()->with('success', 'Sikeres belépés! A jegy érvényes: ' . now()->format('Y. m. d.'));
    }
}
