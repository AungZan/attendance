<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
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

        $attendances = Attendance::where('deleted', 0)->select('id', 'in', 'out')->get();

        return view('home', compact('hours', 'minutes', 'attendances'));
    }

    /**
     * Update A Attendance Record
     *
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::find($id);
        $date = date('Y-m-d', strtotime(now()));

        if (empty($attendance)) {
            return redirect()
                ->back()
                ->with('error', 'The attendance is cannot be updated.');
        }

        // compute attendances

        // save attendances
        $request['origin_in'] = $date . ' ' . $request['inHours'] . ':' . $request['inMinutes'] . ':00';
        $request['origin_out'] = $date . ' ' . $request['outHours'] . ':' . $request['outMinutes'] . ':00';
        $request['in'] = $request['origin_in'];
        $request['out'] = $request['origin_out'];

        $attendance->update($request->all());

        return redirect()
            ->route('home.index')
            ->with('success', 'The attendance has been updated.');
    }
}
