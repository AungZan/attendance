<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, App\Attendance, App\AttendanceChanges;
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
     * Send attendance changes.
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

        $result = array(
            'user_id' => $request['user_id'],
            'attendance_id' => $request['id'],
            'origin_in' => $request['inDate'] . ' ' . $request['origin_in_time'],
            'origin_out' => $request['outDate'] . ' ' . $request['origin_out_time'],
        );

        // save attendance changes
        AttendanceChanges::create($result);

        return redirect()
                ->route('home.index')
                ->with('success', 'The attendance changes has been notified.');
    }
}
