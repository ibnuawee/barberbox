<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class BarberController extends Controller
{
    public function index(Request $request)
    {
        if(Gate::denies('barber-booking')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $bookings = Booking::paginate(5);
        $bookings = DB::table('bookings')
            ->when($request->input('search'), function($query,$search){
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            })->paginate(10);
        // $bookings = Booking::where('barber_id', Auth::user()->barber->id)->get();
        return view('barbers.index', compact('bookings'));
    }

    public function schedule(Request $request)
    {
        if(Gate::denies('barber-schedule')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $schedules = Schedule::paginate(5);
        $schedules= DB::table('schedules')
            ->when($request->input('search'), function($query,$search){
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            })->paginate(10);

        return view('barbers.schedule', compact('schedules'));
    }

    public function setSchedule(Request $request)
    {
        if(Gate::denies('barber-Setschedule')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
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
        if(Gate::denies('barber')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $validated = $request->validate([
            'price' => 'required|numeric',
        ]);

        $barber = Auth::user()->barber;
        $barber->price = $validated['price'];
        $barber->save();

        return back();
    }
}
