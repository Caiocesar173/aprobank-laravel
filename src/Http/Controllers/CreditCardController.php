<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Aprobank\Libraries\Utils;
use Aprobank\Libraries\Validation; 
use Aprobank\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\CreditCard;


class CreditCardController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return CreditCard::create($request);
    }

    public function list($id = null)
    {
        return CreditCard::list($id);
    }

    public function edit($id, Request $request)
    {
        if(!Validation::validate($request, ['']) 
        && $id != null )
            return ApiReturn::ErrorMessage("Dados invalidos");

        $request->request->add(['id' => $id]); 
        return CreditCard::edit($request);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return CreditCard::deleteCreditCard($id);
    }

    public function charge(Request $request)
    {
        if(!Validation::validate($request, ['']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return CreditCard::charge($request);
    }

    public function chargeback(Request $request)
    {
        if(!Validation::validate($request, ['']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return CreditCard::chargeback($request);
    }

}