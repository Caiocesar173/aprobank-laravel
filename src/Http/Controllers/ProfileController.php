<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Profile;


class ProfileController extends Controller
{
    public function __construct() 
    { 
    }

    public function list()
    {
        return Profile::list();
    }

    public function edit(Request $request)
    {
        if(!Validation::validate($request, ['name', 'celphone', 'corporateName', 'email']) )
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Profile::edit($request);
    }
}