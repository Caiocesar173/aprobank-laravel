<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Aprobank\Libraries\Utils;
use Aprobank\Libraries\Validation; 
use Aprobank\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\PaymentLink;


class PaymentLinkController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['value', 'pacelLimit', 'password', 'dueDate']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return PaymentLink::create($request);
    }

    public function list($id = null)
    {
        return PaymentLink::list($id);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return PaymentLink::deletePaymentLink($id);
    }

    public function checkPassword(Request $reques)
    {
        if(!Validation::validate($request, ['paymentLinkId', 'password']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return PaymentLink::checkPassword($request);
    }

    public function pay(Request $reques)
    {
        if(!Validation::validate($request, ['payerId', 'parcel', 'name', 'number', 'cvv', 'month', 'year']))
            return ApiReturn::ErrorMessage("Dados invalidos");
    
        return PaymentLink::pay($request);
    }
}