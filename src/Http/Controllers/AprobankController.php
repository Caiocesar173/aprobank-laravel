<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    public function create()
    {
        return view('aprobank::welcome');
    }

    public function store(Request $request)
    {
        dd($request);
    }
}