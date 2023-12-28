<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ReportScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::orderBy('datetime', 'DESC')->get();

        return view('Report.Schedule.list', [
            'schedules' => $schedules
        ]);
    }

    public function filter(Request $request)
    {
        $query = Schedule::orderBy('datetime', 'ASC');

        if($request->year !== '0') {
            $query = $query->whereYear('datetime', $request->year);
        }

        $schedules = $query->get();

        return view('Report.Schedule.list', [
            'searched_year' => $request->year,
            'schedules' => $schedules
        ]);
    }
}
