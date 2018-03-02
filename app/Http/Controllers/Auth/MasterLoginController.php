<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Master;
use App\Company;
use Log;

class MasterLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:master');
    }

    public function showLoginForm()
    {
        return view('Auth.master-login');
    }

    public function login(Request $request)
    {
        // validate the request.
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $companyID = Company::where('deleted', 0)->where('company_name', $request->company_name)->select('id')->first();

        /* fail attempts (type 1).
         * company id does not exist.
        */
        if (empty($companyID)) {
            // mail wrong
            return $this->loginFailResponse('company_name', $request);
        }

        // save requests to the credential array.
        $credential = array(
            'company_id' => $companyID->id,
            'email' => $request->email,
            'password' => $request->password,
            'deleted' => 0
        );

        /* login authentication
         * if success, redirect to the home page.
         * if fail, redirect back to the login page with error messages.
        */
        if (Auth::guard('master')->attempt($credential, $request->filled('remember'))) {
            // success, redirect to the home page.
            return redirect()
                ->route('users.index');
        }

        /* fail attempts (type 2).
         * email or password does not match or wrong.
        */
        if (empty(Master::where('email', $request->email)->where('deleted', 0)->exists())) {
            // mail wrong
            return $this->loginFailResponse('email', $request);
        }

        if (empty(Master::where('email', $request->email)->where('password', bcrypt($request->password))->where('deleted', 0)->exists()))
        {
            // password wrong.
            return $this->loginFailResponse('password', $request);
        }
    }

    /**
     * Redirect back to the login page with error message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function loginFailResponse($type, Request $request)
    {
        return redirect()
            ->back()
            ->withInput($request->only('company_name', 'email'))
            ->withErrors([
                $type => trans('auth.master_failed'),
            ]);
    }
}
