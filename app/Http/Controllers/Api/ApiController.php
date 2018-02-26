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
        $companies = Company::all();
Log::info($companies);

    }

    public function add()
    {

    }
}
