<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;

class RatingController extends Controller
{
    public function create(){

        return view('bookings.rating');
    }
    public function store(Request $request)
    {
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'rating' => 'required|integer|min=1|max=5',
            'comment' => 'nullable|string',
        ]);

        Rating::create([
            'user_id' => Auth::id(),
            'barber_id' => $request->barber_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('barber.show', $request->barber_id)->with('success', 'Rating submitted successfully');
    }
}