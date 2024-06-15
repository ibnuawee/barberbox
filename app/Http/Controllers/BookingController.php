<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Booking::with('user')
        ->where('user_id', $user->id);

        if ($search = $request->input('search')) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        });
        }
        $mybookings = $query->paginate(10);
        return view('bookings.index', compact('mybookings'));
    }

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

        $barber = Barber::findOrFail($validated['barber_id']);
        $service = $barber->services()->where('service_id', $validated['service_id'])->first();

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'barber_id' => $validated['barber_id'],
            'service_id' => $validated['service_id'],
            'haircut_name' => $validated['haircut_name'],
            'booking_date' => $validated['booking_date'],
            'gender' => $validated['gender'],
            'status' => 'pending',
            'invoice_number' => strtoupper(uniqid('INV-')),
            'total_price' => $service->pivot->price,
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

    public function availableServices(Request $request)
    {
        try {
            DB::enableQueryLog(); // Enable query logging

            $barber = Barber::with(['services' => function($query) use ($request) {
                $query->select('services.id', 'services.name', 'barber_service.price as price')
                    ->join('barber_service as bs', 'services.id', '=', 'bs.service_id')
                    ->where('bs.barber_id', $request->barber_id);
            }])->find($request->barber_id);

            Log::info(DB::getQueryLog()); // Log the query

            if ($barber) {
                return response()->json($barber->services);
            }

            return response()->json([]);
        } catch (\Exception $e) {
            Log::error('Error fetching available services: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

}
