<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    //
    public function index()
    {
        $paymentMethods = PaymentMethod::paginate(10);
        return view('payments.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        PaymentMethod::create($validated);

        return redirect()->route('payments.index')->with('success', 'Payment method added successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return back()->with('success', 'Payment method deleted successfully.');
    }
}
