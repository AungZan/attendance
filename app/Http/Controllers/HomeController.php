<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, App\Attendance, App\Setting;
use Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hours = config('constant.hours');
        $minutes = config('constant.minutes');

        $attendances = Attendance::where('deleted', 0)
                                ->where('user_id', Auth::id())
                                ->select('id', 'user_id', 'origin_in', 'origin_out', 'in', 'out')
                                ->get();

        return view('home', compact('hours', 'minutes', 'attendances'));
    }

    /**
     * Update A Attendance Record
     *
     */
    public function update(Request $request, $id)
    {
        // validate attendances
        $attendance = Attendance::find($id);
        if (empty($attendance)) {
            return redirect()
                    ->back()
                    ->with('error', 'The attendance cannot be updated.');
        }

        $attendanceObj = new Attendance();
        $validationErrors = $attendanceObj->validation($request);

        if (!empty($validationErrors)) {
            return redirect()
                    ->back()
                    ->with('error', 'The attendance cannot be updated.');
        }

        // compute attendances
        $settings = Setting::where('company_id', $attendance->company_id)->get()->first()->toArray();
        $result = $attendanceObj->calculate($request, $settings);

        // save attendances
        $attendance->update($result);

        return redirect()
                ->route('home.index')
                ->with('success', 'The attendance has been updated.');
    }
}
