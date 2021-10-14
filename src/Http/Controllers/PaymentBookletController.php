<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\PaymentBooklet;


class PaymentBookletController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['payerId', 'value', 'description', 'instruction1', 'instruction2', 'instruction3', 'dueDate', 'penaltyType', 'penltyValue', 'feeType', 'feeValue', 'discountType', 'discountValue', 'dueDateDiscount']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return PaymentBooklet::create($request);
    }

    public function list($id = null)
    {
        return PaymentBooklet::list($id);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return PaymentBooklet::deletePaymentBooklet($id);
    }
}