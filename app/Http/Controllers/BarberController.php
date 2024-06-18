<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Transaction;
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
        $barber = Auth::user()->barber;
        $query = Booking::with('user')
        ->where('barber_id', $barber->id);

        if ($search = $request->input('search')) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        });
    }

    $bookings = $query->paginate(10);
        return view('barbers.index', compact('bookings'));
    }

    public function schedule(Request $request)
    {
        if(Gate::denies('barber-schedule')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $barber = Auth::user()->barber;
        $schedules = Schedule::paginate(5);
        $schedules= DB::table('schedules')
        ->where('barber_id', $barber->id)
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

    public function Price(Request $request)
    {
        if(Gate::denies('barber-price')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $barber = Auth::user()->barber;
        $allservices = Service::all(); 
        $query = $barber->services()->withPivot('price');
    
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $services = $query->paginate(10);

        return view('barbers.price', compact('services', 'allservices'));
    }

    public function setPrice(Request $request)
    {
        if(Gate::denies('barber-setprice')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric',
        ]);

        $barber = Auth::user()->barber;
        $barber->services()->syncWithoutDetaching([
        $validated['service_id'] => ['price' => $validated['price']]
        ]);

        return back()->with('success', 'Price set successfully for the service.');
    }

}
