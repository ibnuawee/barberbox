<?php

namespace App\Http\Controllers;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DateController extends Controller
{
    //
    public function index()
    {
        return view('uas_rpl.uas');
    }

    public function findWeekends(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $period = CarbonPeriod::create($start_date, $end_date);

        $weekends = [];
        foreach ($period as $date) {
            if ($date->isSaturday() || $date->isSunday()) {
                $weekends[] = $date->format('l, Y-m-d');
            }
        }

        return view('uas_rpl.uas', ['weekends' => $weekends]);
    }
}
