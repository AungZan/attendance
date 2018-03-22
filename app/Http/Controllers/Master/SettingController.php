<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, App\Master, App\Setting, Auth, Log;


class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:master');
    }

    public function index()
    {
        $masterInfo = Master::find(Auth::id());
        $companyID = $masterInfo->company_id;

        $roundTimes = Config('constant.roundTime');

        $setting = Setting::where('deleted', 0)->where('company_id', $companyID)->get()->first();

        $header = 'Setting';

        return view('settings.index', compact('setting', 'header', 'roundTimes'));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::Make($request->all(), [
            'check_in' => 'required',
            'check_out' => 'required',
            'working_hours' => 'required',
            'break_time' => 'required',
        ]);

        if ($validation->fails()) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation)
                    ->with('error', 'The settings cannot be updated.');
        }

        $setting = Setting::find($id);
        $masterInfo = Master::find(Auth::id());

        $data = $request->all();
        $data['company_id'] = $masterInfo->company_id;

        $setting->update($data);

        return redirect()
                ->route('settings.index')
                ->with('success', 'The settings has been updated.');
    }
}
