<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    //
    public function create()
    {
        $services = Service::all();
        $barbers = Barber::with('user')->get();
        return view('bookings.create', compact('services', 'barbers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'barber_id' => 'required|exists:barbers,id',
            'haircut_name' => 'required|string',
            'booking_date' => 'required|date|after:now',
            'gender' => 'required|string|in:pria,wanita',
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'barber_id' => $validated['barber_id'],
            'service_id' => $validated['service_id'],
            'haircut_name' => $validated['haircut_name'],
            'booking_date' => $validated['booking_date'],
            'gender' => $validated['gender'],
            'status' => 'pending',
            'invoice_number' => strtoupper(uniqid('INV-')),
            'total_price' => Barber::find($validated['barber_id'])->price,
        ]);

        return redirect()->route('booking.show', $booking->id);
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function availableSchedule(Request $request)
    {
        $schedules = Schedule::where('barber_id', $request->barber_id)
            ->whereNotIn('available_date', function($query) use ($request) {
                $query->select('booking_date')
                      ->from('bookings')
                      ->where('barber_id', $request->barber_id);
            })->get();

        return response()->json($schedules);
    }
}
