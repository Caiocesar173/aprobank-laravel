<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Aprobank\Libraries\Utils;
use Aprobank\Libraries\Validation; 
use Aprobank\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Users;


class UsersController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Users::create($request);
    }

    public function list($id = null)
    {
        return Users::list($id);
    }

    public function createPassword($id, Request $request)
    {
        if(!Validation::validate($request, ['']) 
        && $id != null )
            return ApiReturn::ErrorMessage("Dados invalidos");

        $request->request->add(['id' => $id]); 
        return Users::changePassword($request);
    }

    public function changePassword($id, Request $request)
    {
        if(!Validation::validate($request, ['']) 
        && $id != null )
            return ApiReturn::ErrorMessage("Dados invalidos");

        $request->request->add(['id' => $id]); 
        return Users::changePassword($request);
    }

}