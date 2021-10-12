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
        if(!Validation::validate($request, ['payerId', 'parcel', 'value', 'capture', 'name', 'number', 'cvv', 'month', 'year']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return CreditCard::create($request);
    }

    public function createSimple(Request $request)
    {
        if(!Validation::validate($request, ['document', 'cellphone', 'parcel', 'value', 'capture', 'name', 'number', 'cvv', 'month', 'year']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return CreditCard::createSimple($request);
    }

    public function list($id = null)
    {
        return CreditCard::list($id);
    }

    public function charge(Request $request)
    {
        if(!Validation::validate($request, ['value', 'id']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return CreditCard::charge($request);
    }

    public function chargeback(Request $request)
    {
        if(!Validation::validate($request, ['id']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return CreditCard::chargeback($request);
    }
}