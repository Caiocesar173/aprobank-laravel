<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Aprobank\Libraries\Utils;
use Aprobank\Libraries\Validation; 
use Aprobank\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Withdraw;


class WithdrawController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {        
        if(!Validation::validate($request, ['bankAccountId', 'value', 'description']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Withdraw::create($request);
    }

    public function list($id = null)
    {
        return Withdraw::list($id);
    }
}