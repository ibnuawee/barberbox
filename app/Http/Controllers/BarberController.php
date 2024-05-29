<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barber;
use App\Models\User;

class BarberController extends Controller
{
    //
    public function index()
    {
        $barbers = Barber::all();
        return view('barbers.index', compact('barbers'));
    }

    public function create()
{
    return view('barbers.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    Barber::create([
        'name' => $request->name,
    ]);

    return redirect()->route('barbers.index')->with('success', 'Barber added successfully');
}
}
