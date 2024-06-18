<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function settings()
    {
        $settings = Setting::first();
        if (!$settings) {
            // Create default setting if not exists
            $settings = Setting::create([
                'admin_fee_percentage' => 0, // default value
            ]);
        }
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'admin_fee_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $settings = Setting::first();
        $settings->admin_fee_percentage = $request->admin_fee_percentage;
        $settings->save();

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}
