<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\PaymentAccount;


class PaymentAccountController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['document', 'name', 'coporateName', 'cnpj', 'celphone', 'birthday', 'email', 'site', 'zip', 'street', 'number', 'complement', 'district', 'city', 'state']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return PaymentAccount::create($request);
    }

    public function list($id = null)
    {
        return PaymentAccount::list($id);
    }

    public function edit($id, Request $request)
    {
        if(!Validation::validate($request, ['name', 'coporateName', 'celphone', 'email', 'site', 'zip', 'street', 'number', 'complement', 'district', 'city', 'state']) 
        && $id != null )
            return ApiReturn::ErrorMessage("Dados invalidos");

        $request->request->add(['id' => $id]); 
        return PaymentAccount::edit($request);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return PaymentAccount::deletePaymentAccount($id);
    }
}