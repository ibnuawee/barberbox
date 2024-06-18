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

        return redirect()->back()->with('success', 'Rating submitted successfully');
    }
}