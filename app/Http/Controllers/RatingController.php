<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'barber_id' => 'required|exists:barbers,id',
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string',
        ]);

        $user = Auth::user();

        Rating::create([
            'user_id' => $user->id,
            'booking_id' => $request->booking_id,
            'barber_id' => $request->barber_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('booking.show', $request->booking_id)->with('success', 'Rating submitted successfully.');
    }
}