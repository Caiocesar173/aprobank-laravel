<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Users;


class UsersController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['accountId', 'email']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Users::create($request);
    }

    public function list($id = null)
    {
        return Users::list($id);
    }

    public function createPassword($id, Request $request)
    {
        if(!Validation::validate($request, ['email', 'token', 'password', 'passwordConfirmation']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Users::changePassword($request);
    }

    public function changePassword($id, Request $request)
    {
        if(!Validation::validate($request, ['password', 'passwordConfirmation']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Users::changePassword($request);
    }

}