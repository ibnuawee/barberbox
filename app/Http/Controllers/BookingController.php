<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    //
    public function create()
    {
        $barbers = Barber::all();
        return view('bookings.create', compact('barbers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'booking_time' => 'required|date|after:now',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'barber_id' => $request->barber_id,
            'booking_time' => $request->booking_time,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking successfully created');
    }

    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->get();
        return view('bookings.index', compact('bookings'));
    }
}
