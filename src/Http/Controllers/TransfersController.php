<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Transfers;


class TransfersController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['destinationAccountId', 'value', 'discription']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Transfers::create($request);
    }

    public function list($id = null)
    {
        return Transfers::list($id);
    }
}