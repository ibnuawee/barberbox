<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeapYearController extends Controller
{
    public function index()
    {
        return view('leapyear');
    }

    public function check(Request $request)
    {
        $startYear = $request->input('start_year');
        $endYear = $request->input('end_year');
        $leapYears = [];

        for ($year = $startYear; $year <= $endYear; $year++) {
            if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
                $leapYears[] = $year;
            }
        }

        return view('leapyear', ['leapYears' => $leapYears, 'startYear' => $startYear, 'endYear' => $endYear]);
    }
};