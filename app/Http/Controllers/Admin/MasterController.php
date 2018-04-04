<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Master;
use App\Company;
use Log;

class MasterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Master::select();

        $query->where('deleted', 0);

        if ($request->has('search')) {

            $query->where(function($q) use($request){
                $q->where('name', 'LIKE', "%{$request['search']}%")
                    ->orWhere('email', 'LIKE', "%{$request['search']}%");
            });
        }

        $masters = $query->paginate(1);

        $header = 'Master List';
        return view('masters.index', compact('header', 'masters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // pluck method is used for lists.
        $companies = Company::where('deleted', 0)->pluck('id', 'name');
        $header = 'Create A New Master';
        return view('masters.create', compact('header', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validation($request, 'create');

        if ($validation->fails()) {
            return redirect()
                ->back()
                ->withErrors($validation)
                ->withInput()
                ->with('error', 'Master cannot be saved.');
        }

        Master::create($request->all());
        return redirect(route('masters.index'))->with('success', 'A Master has been created.');
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
        $master = Master::find($id);
        // pluck method is used for lists.
        $companies = Company::where('deleted', 0)->pluck('id', 'name');
        $header = 'Edit A Master';
        return view('masters.edit', compact('master', 'companies', 'header'));
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
        $master = Master::find($id);

        $validation = $this->validation($request, 'edit');

        if ($validation->fails()) {
            return redirect()
                ->back()
                ->withErrors($validation)
                ->with('error', 'Master cannot be updated.');
        }

        if ($request->get('password') == null) {

            // remove password field from the input array.
            $request = $request->except('password');
        } else {
            $request = $request->all();
        }

        $master->update($request);

        return redirect(route('masters.index'))->with('success', 'A Master has been updated.');
    }

    /**
     * Remove the specified resource from storage. (soft delete)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $master = Master::find($id);
        $master->deleted = 1;

        if ($master->save()) {
            return redirect(route('masters.index'))->with('success', 'A Master has been deleted.');
        }

        return redirect()
            ->back()
            ->with('error', 'A Master cannot be deleted.');
    }

    /**
     * Validate Requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $type (to check create or update method)
     * @return $validator
     */
    protected function validation($request, $type)
    {
        switch ($type) {
            case 'create':
                return $validator = Validator::Make($request->all(), [
                    'company_id' => 'required',
                    'name' => 'required',
                    'email' => 'required|email|unique:masters,email,,id,deleted,0',
                    'password' => 'required|min:6',
                ]);
                break;

            case 'edit':
                return $validator = Validator::Make($request->all(), [
                    'company_id' => 'required',
                    'name' => 'required',
                    'email' => 'required|email|unique:masters,email,' . $request->get('id') . ',id,deleted,0',
                    'password' => 'nullable|min:6',
                ]);
                break;

            default:
                break;
        }
    }
}
