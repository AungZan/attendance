<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AttendanceChanges, App\Attendance, App\Setting, App\Master, Auth;
use Log;

class AttendanceChangesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:master');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getRequest = $request->all();
        if (array_key_exists('date', $getRequest)) {
            $date = $getRequest['date'];
        } else {
            $date = date('Y-m-d');
        }

        $changes = AttendanceChanges::with('attendance')->where('deleted', 0)->where('origin_in', 'LIKE', "%{$date}%")->get()->toArray();

        $header = 'Attendance Changes';

        return view('attendance_changes.index', compact('header', 'date', 'changes'));
    }

    /**
     * Approve the request attendance changes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        $changes = AttendanceChanges::find($id);
        $data = $changes->toArray();

        if (empty($changes)) {
            return redirect()->route('attendance_changes.index')->with('error', 'The request changes could not be found.');
        }

        $masterInfo = Master::find(Auth::id());
        $setting = Setting::where('company_id', $masterInfo->company_id)->get()->first()->toArray();

        $attendanceObj = new Attendance();
        $result = $attendanceObj->calculate($data, $setting);

        $attendance = Attendance::find($data['attendance_id']);
        $attendance->update($result);

        $changes->status = 1;
        $changes->save();

        return redirect()->route('attendance_changes.index')->with('success', 'The request change has been approved.');
    }

    /**
     * Decline the request attendance changes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function decline(Request $request, $id)
    {
        $changes = AttendanceChanges::find($id);

        if (empty($changes)) {
            return redirect()->route('attendance_changes.index')->with('error', 'The request change could not be found.');
        }

        $changes->status = 2;

        $changes->save();

        return redirect()->route('attendance_changes.index')->with('success', 'The request change has been declined.');
    }

    /**
     * Revoke the decline attendance changes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function revokeDecline(Request $request, $id)
    {
        $changes = AttendanceChanges::find($id);

        if (empty($changes)) {
            return redirect()->route('attendance_changes.index')->with('error', 'The request change could not be found.');
        }

        $changes->status = 0;

        $changes->save();

        return redirect()->route('attendance_changes.index')->with('success', 'The request change has been revoked.');
    }
}
