<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->update([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);
        $barber = Barber::findOrFail($validated['barber_id']);
        $service = $barber->services()->where('service_id', $validated['service_id'])->first();

        // Periksa apakah saldo pengguna mencukupi
        if ($user->balance < $service->pivot->price) {
            return back()->withErrors(['balance' => 'Saldo tidak mencukupi untuk melakukan booking ini.']);
        }

        // Saldo sebelum transaksi
        $balanceBefore = $user->balance;

        // Kurangi saldo pengguna
        /** @var \App\Models\User $user **/
        $user->balance -= $service->pivot->price;
        $user->save();

        // Saldo setelah transaksi
        $balanceAfter = $user->balance;

        // Buat riwayat transaksi untuk booking
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'booking',
            'amount' => -$service->pivot->price,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'description' => 'Booking for service: ' . $service->name,
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
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

    public function accept(Booking $booking){
        if ($booking->status !== 'confirmed') {
            $booking->status = 'confirmed';
            $booking->save();
        }
        return redirect()->route('barber.index', $booking->id)->with('success', 'Booking telah dikonfirmasi.');
    }

    public function complete(Booking $booking)
    {
        if ($booking->status !== 'completed') {
            $booking->status = 'completed';
            $booking->save();

            // // Set timer untuk auto-konfirmasi setelah 1 hari
            // $this->scheduleAutoConfirm($booking);
        }

        return redirect()->route('barber.index', $booking->id)->with('success', 'Booking marked as completed. Awaiting user confirmation.');
    }

    // private function scheduleAutoConfirm(Booking $booking)
    // {
    //     // Jadwalkan tugas untuk auto-konfirmasi setelah 1 hari
    //     $booking->update(['confirmed_at' => Carbon::now()->addDay()]);
    //     // Ini adalah tempat untuk menambahkan logika untuk menjadwalkan tugas di background (gunakan queue/job scheduler)
    // }

    public function confirm(Booking $booking)
    {
        if ($booking->status === 'completed' && is_null($booking->confirmed_at)) {
            $booking->confirmed_at = now();
            $booking->confirmation_token = Str::random(40); // Generate random token
            $booking->status = 'success';
            $booking->save();
    
            // Kreditkan saldo ke akun barber
            $barber = $booking->barber->user;

            // Ambil persentase biaya admin dari pengaturan
            $adminFeePercentage = Setting::first()->admin_fee_percentage;
            $adminFee = ($booking->total_price * $adminFeePercentage) / 100;
            $netAmount = $booking->total_price - $adminFee;

            // Saldo sebelum transaksi
            $balanceBefore = $barber->balance;

            // Tambahkan saldo barber
            $barber->balance += $netAmount;
            $barber->save();

            // Saldo setelah transaksi
            $balanceAfter = $barber->balance;

            // Buat riwayat transaksi untuk konfirmasi
            Transaction::create([
                'user_id' => $barber->id,
                'type' => 'booking',
                'amount' => $netAmount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Booking confirmed: ' . $booking->invoice_number,
            ]);

            return redirect()->route('booking.show', $booking->id)->with('success', 'Booking confirmed and balance transferred to barber.');
        }

        return redirect()->route('booking.show', $booking->id)->with('error', 'Booking was already confirmed.');
    }

    public function autoConfirm()
    {
        $bookings = Booking::where('status', 'completed')
            ->where('confirmed_at', '<=', now())
            ->get();

        foreach ($bookings as $booking) {
            $booking->status = 'success';
            $booking->save();

            // Kreditkan saldo ke akun barber
            $barber = $booking->barber->user;
            $barber->balance += $booking->total_price;
            $barber->save();

            // Buat riwayat transaksi untuk konfirmasi
            Transaction::create([
                'user_id' => $barber->id,
                'type' => 'booking',
                'amount' => $booking->total_price,
                'description' => 'Booking confirmed: ' . $booking->invoice_number,
            ]);
        }
    }


    public function cancel(Booking $booking)
    {
        if ($booking->status !== 'cancelled') {
            $booking->status = 'cancelled';
            $booking->save();

            // Saldo sebelum transaksi
            $balanceBefore = $booking->user->balance;

            // Kembalikan saldo ke pengguna
            $user = $booking->user;
            $user->balance += $booking->total_price;
            $user->save();

            // Saldo setelah transaksi
            $balanceAfter = $user->balance;

            // Buat riwayat transaksi untuk pembatalan
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'canceled',
                'amount' => $booking->total_price,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Cancelled booking: ' . $booking->invoice_number,
            ]);
        }

        return redirect()->route('barber.index', $booking->id)->with('success', 'Booking cancelled and balance returned to user.');
    }

    public function showRoute(Booking $booking)
    {
        $user = Auth::user();
        $barber = $booking->barber;

        return view('bookings.rute', compact('user', 'barber'));
    }



}