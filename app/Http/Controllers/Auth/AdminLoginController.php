<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Auth;

class AdminLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        // Validate the login request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // save $request data in credentials array.
        $credentials = array(
            'email' => $request->email,
            'password' => $request->password,
        );

        /* Logging in
         * if successful, redirect to the intended page.
         */
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            return redirect(route('admin.home'));
        }

        // if fail, redirect back to the login page.
        return redirect()->back()->withInput($request->only('email'));
    }
}
