<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Finance;


class FinanceController extends Controller
{
    public function __construct() 
    { 
    }
    
    public function extract(Request $request)
    {
        return Finance::extract($request);
    }

    public function future(Request $request)
    {
        return Finance::future($request);
    }

    public function history(Request $request)
    {
        return Finance::history($request);
    }

    public function transaction(Request $request, $id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Finance::transaction($request);    
    }

}