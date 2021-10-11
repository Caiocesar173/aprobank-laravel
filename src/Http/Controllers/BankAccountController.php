<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Aprobank\Libraries\Utils;
use Aprobank\Libraries\Validation; 
use Aprobank\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\BankAccount;


class BankAccountController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['bankCode', 'agency', 'type', 'account']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return BankAccount::create($request);
    }

    public function list($id = null)
    {
        return BankAccount::list($id);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return BankAccount::deleteBankAccount($id);
    }
}