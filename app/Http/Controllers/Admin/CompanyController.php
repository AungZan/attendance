<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Validator;
use Log;

class CompanyController extends Controller
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
    public function index()
    {
        $companies = Company::where('deleted', 0)->get();
        $header = 'Company List';
        return view('companies.index', compact('header', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $header = 'Create A New Company';
        return view('companies.create', compact('header'));
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
                ->with('error', 'A Company cannot be saved.');
        }

        Company::create($request->all());
        return redirect(route('companies.index'))->with('success', 'A Company has been created.');
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
        $company = Company::find($id);
        $header = 'Edit A Company';
        return view('companies.edit', compact('company', 'header'));
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
        $company = Company::find($id);

        $validation = $this->validation($request, 'edit');

        if ($validation->fails()) {
            return redirect()
                ->back()
                ->withErrors($validation)
                ->with('error', 'A Company cannot be updated.');
        }

        $company->update($request->all());

        return redirect(route('companies.index'))
            ->with('success', 'A Company has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        $company->deleted = 1;

        if ($company->save()) {
            return redirect(route('companies.index'))
                ->with('success', 'A Company has been deleted.');
        }

        return redirect()
            ->back()
            ->with('error', 'A Company cannot be deleted.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $type (to check create or update method)
     * @return $validator
     */
    protected function validation(Request $request, $type)
    {
        switch ($type) {
            case 'create':
                return $validator = Validator::Make($request->all(), [
                    'company_name' => 'required|unique:companies,company_name',
                    'name' => 'required',
                ]);
                break;

            case 'edit':
                return $validator = Validator::Make($request->all(), [
                    'company_name' => 'required|unique:companies,company_name,' . $request->get('id'),
                    'name' => 'required',
                ]);
                break;

            default:
                break;
        }
    }
}
