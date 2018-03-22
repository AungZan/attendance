<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth, Validator, App\Master, App\Attendance, App\User, App\Setting, Log;

class AttendanceController extends Controller
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

        $masterInfo = Master::find(Auth::id());
        $attendances = Attendance::where('deleted', 0)
                                ->where('company_id', $masterInfo->company_id)
                                ->where('origin_in', 'LIKE', "%{$date}%")
                                ->get();

        $header = 'Attendances List';

        return view('attendances.index', compact('attendances', 'header', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $masterInfo = Master::find(Auth::id());
        $staffs = User::where('deleted', 0)->where('company_id', $masterInfo->company_id)->pluck('name', 'id');

        $header = 'Create A New Attendance';

        return view('attendances.create', compact('header', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validation($request);

        if ($validation->fails()) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation)
                    ->with('error', 'The Attendance cannot be created.');
        }

        $attendanceObj = new Attendance();

        $validationError = $attendanceObj->validation($request);

        if (!empty($validationError)) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validationError)
                    ->with('error', 'The Attendance cannot be created.');
        }

        $masterInfo = Master::find(Auth::id());

        $result = $attendanceObj->calculate($request);
        $result['company_id'] = $masterInfo->company_id;

        Attendance::create($result);

        return redirect()->route('attendances.index')->with('success', 'The Attendance has been created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance = Attendance::find($id)->toArray();

        $header = 'Edit A Attendance';

        return view('attendances.edit', compact('attendance', 'header'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $this->validation($request);

        if ($validation->fails()) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation)
                    ->with('error', 'The attenadance cannot be updated.');
        }

        $masterInfo = Master::find(Auth::id());
        $setting = Setting::where('company_id', $masterInfo->company_id)->get()->first()->toArray();

        $attendanceObj = new Attendance();
        $validationError = $attendanceObj->validation($request);

        if (!empty($validationError)) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validationError)
                    ->with('error', 'The Attendance cannot be updated.');
        }

        $attendance = Attendance::find($id);
        $result = $attendanceObj->calculate($request, $setting);

        $attendance->update($result);

        return redirect()
                ->route('attendances.index')
                ->with('success', 'The Attendance has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendance = Attendance::find($id);

        $attendance->deleted = 1;

        $attendance->save();

        return redirect()->route('attendances.index')->with('success', 'The attendance has been deleted.');
    }

    /**
     * Validate Requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $validator
     */
    public function validation($request)
    {
        return $validator = Validator::Make($request->all(), [
            'user_id' => 'required',
            'inDate' => 'required',
            'origin_in_time' => 'required',
        ]);
    }
}
