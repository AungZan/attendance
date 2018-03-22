<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Log;

class ApiController extends Controller
{

    public function login()
    {

    }

    public function list()
    {
        $companies = Company::where('deleted', 0)->get();
        return $companies;

    }

    public function add()
    {

    }
}
