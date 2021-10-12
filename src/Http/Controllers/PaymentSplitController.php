<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Aprobank\Libraries\Utils;
use Aprobank\Libraries\Validation; 
use Aprobank\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\PaymentSplit;


class PaymentSplitController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['billingId', 'accountId', 'percentage', 'value', 'responsable', 'liquidValue']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return PaymentSplit::create($request);
    }

    public function list($id = null)
    {
        return PaymentSplit::list($id);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return PaymentSplit::deletePaymentSplit($id);
    }
}