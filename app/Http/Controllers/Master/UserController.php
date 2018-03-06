<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\User;
use App\Master;
use Log;

class UserController extends Controller
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
    public function index()
    {
        $masterInfo = Master::find(Auth::id());
        $companyID = $masterInfo['company_id'];

        $users = User::where('deleted', 0)->where('company_id', $companyID)->get();
        $header = 'Staff List';
        return view('users.index', compact('header', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $header = 'Create A New Staff';
        return view('users.create', compact('header'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validation($request, 'add');

        if ($validation->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($validation)
                    ->withInput()
                    ->with('error', 'A Staff cannot be created.');
        }

        $masterID = Auth::id();
        $masterInfo = Master::find($masterID);

        $data = $request->all();
        $data['company_id'] = $masterInfo->company_id;

        if (!empty($request->image)) {

            if (!is_dir(public_path('img/staff'))) {
                mkdir(public_path('img/staff'), 0777, true);
            }

            $destionationPath = public_path('img/staff');
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();

            $request->image->move($destionationPath, $imageName);

            $data['image'] = $imageName;
        }

        User::create($data);

        return redirect()
                ->route('users.index')
                ->with('success', 'A Staff has been created.');
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
        $user = User::find($id);
        $header = 'Edit A Staff';

        return view('users.edit', compact('user', 'header'));
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
        $validation = $this->validation($request, 'edit');

        if ($validation->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($validation)
                    ->withInput()
                    ->with('error', 'A Staff cannot be updated.');
        }

        $user = User::find($id);
        $data = $request->all();
        $image = $request->only('image');

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (empty($image)) {
            unset($data['image']);
        } else {

            if (!is_dir(public_path('img/staff'))) {
                mkdir(public_path('img/staff'), 0777, true);
            }

            $destionationPath = public_path('img/staff');

            if (!empty($user->image)) {
                unlink($destionationPath . '/' . $user->image);
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move($destionationPath, $imageName);

            $data['image'] = $imageName;
        }

        $user->update($data);

        return redirect()
                ->route('users.index')
                ->with('success', 'A Staff has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect()
                    ->back()
                    ->with('error', 'A Staff cannot be deleted.');
        }

        $user->deleted = 1;
        $user->save();

        return redirect()
                ->route('users.index')
                ->with('success', 'A Staff has been deleted.');
    }

    /**
     * Validate Requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $type (to check create or update method)
     * @return $validator
     */
    public function validation($request, $type)
    {
        switch ($type) {
            case 'add':
                return $validator = Validator::Make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'image' => 'nullable|image|mimes:jpg,png,jpeg',
                    'password' => 'required|min:6',
                ]);
                break;

            case 'edit':
                return $validator = Validator::Make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $request->get('id'),
                    'image' => 'nullable|image|mimes:jpg,png,jpeg',
                    'password' => 'nullable|min:6',
                ]);
                break;

            default:
                break;
        }
    }
}
