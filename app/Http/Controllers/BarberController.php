<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BarberController extends Controller
{
    public function dashboard()
    {
        return view('barbers.dashboard');
    }
    public function index(Request $request)
    {
        if (Gate::denies('barber-booking')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $barber = Auth::user()->barber;
        $query = Booking::with('user')
        ->where('barber_id', $barber->id)
        ->orderBy('created_at', 'desc');

        if ($search = $request->input('search')) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('invoice_number', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('haircut_name', 'like', '%' . $search . '%')
                    ->orWhere('gender', 'like', '%' . $search . '%')
                    ->orWhere('booking_date', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $bookings = $query->paginate(10);
        return view('barbers.index', compact('bookings'));
    }

    public function schedule(Request $request)
    {
        if (Gate::denies('barber-schedule')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $barber = Auth::user()->barber;
        $schedules = DB::table('schedules')
            ->leftJoin('bookings', function($join) {
                $join->on('schedules.available_date', '=', 'bookings.booking_date')
                    ->on('schedules.barber_id', '=', 'bookings.barber_id');
            })
            ->where('schedules.barber_id', $barber->id)
            ->whereNull('bookings.id') // Only select schedules that are not booked
            ->orderBy('schedules.available_date', 'asc')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('schedules.name', 'like', '%' . $search . '%')
                    ->orWhere('schedules.email', 'like', '%' . $search . '%')
                    ->orWhere('schedules.phone', 'like', '%' . $search . '%')
                    ->orWhere('schedules.role', 'like', '%' . $search . '%');
            })->select('schedules.*')->paginate(10);

        return view('barbers.schedule', compact('schedules'));
    }


    public function setSchedule(Request $request)
    {
        if (Gate::denies('barber-Setschedule')) {
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

    public function destroy($id)
    {
        // if (Gate::denies('delete-user')) {
        //     abort(403, 'Anda tidak memiliki cukup hak akses');
        // }
        $schedule = Schedule::find($id);
        $schedule->delete();

        // Kembali dengan pesan sukses
        return back()->with('success', 'Jadwal berhasil dihapus');
    }

    public function Price(Request $request)
    {
        if (Gate::denies('barber-price')) {
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
        if (Gate::denies('barber-setprice')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric',
        ]);

        $barber = Auth::user()->barber;
        $barber->services()->syncWithoutDetaching([
            $validated['service_id'] => ['price' => $validated['price']],
        ]);

        return back()->with('success', 'Price set successfully for the service.');
    }

    // TAK TAMBAH
    public function showProfile($barberId)
    {
        $barber = Barber::findOrFail($barberId);
        $averageRating = $barber->ratings()->avg('rating'); // Menghitung rata-rata rating
    
        return view('bookings.profile', compact('barber', 'averageRating'));
    }
    

    // rata2 ratings
    public function show($id)
    {
        // Mengambil booking dengan relasi ke barber, user barber, services barber, dan ratings barber
        $booking = Booking::with('barber.user', 'barber.services', 'barber.ratings.user')->findOrFail($id);

        $barber = $booking->barber;
        $averageRating = $barber->ratings->avg('rating');

        // Menghitung rating rata-rata untuk setiap layanan
        foreach ($barber->services as $service) {
            $service->average_rating = $service->ratings->avg('rating');
        }

        return view('bookings.show', compact('barber', 'averageRating', 'booking'));
    }

    public function report(Request $request)
    {
        $barber = Auth::user()->barber;

        $filter = $request->input('filter', 'daily'); // Default filter is daily
        $date = Carbon::now();

        switch ($filter) {
            case 'daily':
                $startDate = $date->copy()->startOfDay();
                $endDate = $date->copy()->endOfDay();
                break;
            case 'weekly':
                $startDate = $date->copy()->startOfWeek();
                $endDate = $date->copy()->endOfWeek();
                break;
            case 'monthly':
                $startDate = $date->copy()->startOfMonth();
                $endDate = $date->copy()->endOfMonth();
                break;
            case 'yearly':
                $startDate = $date->copy()->startOfYear();
                $endDate = $date->copy()->endOfYear();
                break;
            default:
                $startDate = $date->copy()->startOfDay();
                $endDate = $date->copy()->endOfDay();
                break;
        }

        Log::info('Start Date: ' . $startDate);
        Log::info('End Date: ' . $endDate);

        $bookings = Booking::where('barber_id', $barber->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        
        Log::info('Bookings: ' . $bookings);

        $totalBookings = $bookings->count();
        $successfulBookings = $bookings->where('status', 'success')->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $canceledBookings = $bookings->where('status', 'cancelled')->count();
        $totalEarnings = $bookings->where('status', 'success')->sum('total_price');

        // Mengambil pengaturan biaya admin
        $settings = Setting::first();
        $adminFeePercentage = $settings ? $settings->admin_fee_percentage : 0;
        $netEarnings = $totalEarnings - ($totalEarnings * ($adminFeePercentage / 100));

        Log::info('Total Bookings: ' . $totalBookings);
        Log::info('Successful Bookings: ' . $successfulBookings);
        Log::info('Pending Bookings: ' . $pendingBookings);
        Log::info('Canceled Bookings: ' . $canceledBookings);
        Log::info('Total Earnings: ' . $totalEarnings);
        Log::info('Net Earnings (after admin fee): ' . $netEarnings);

        return view('barbers.laporan', compact('totalBookings', 'successfulBookings', 'pendingBookings', 'canceledBookings', 'totalEarnings', 'netEarnings', 'filter'));
    }

    public function location()
    {
        return view('barbers.lokasi');
    }

    public function updateLocation(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $barber = Auth::user()->barber;
        $barber->latitude = $request->latitude;
        $barber->longitude = $request->longitude;
        $barber->save();

        return back()->with('success', 'Location updated successfully.');
    }
}