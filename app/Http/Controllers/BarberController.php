<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarberController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('barber_id', Auth::user()->barber->id)->get();
        return view('barbers.index', compact('bookings'));
    }

    public function setSchedule(Request $request)
    {
        $validated = $request->validate([
            'available_date' => 'required|date|after:now',
        ]);

        $barber = Auth::user()->barber;
        Schedule::create([
            'barber_id' => $barber->id,
            'available_date' => $validated['available_date'],
        ]);

        return back();
    }

    public function setPrice(Request $request)
    {
        $validated = $request->validate([
            'price' => 'required|numeric',
        ]);

        $barber = Auth::user()->barber;
        $barber->price = $validated['price'];
        $barber->save();

        return back();
    }
}
