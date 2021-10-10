<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Aprobank\Libraries\Utils;
use Aprobank\Libraries\Validation; 
use Aprobank\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\BankSlip;


class BankSlipController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!isset($request['payerId']))
        {
            if(!Validation::validate($request, ['']))
                return ApiReturn::ErrorMessage("Dados invalidos");

            return BankSlip::create($request);
        }

        return self::createPayer($request);
    }

    public function createPayer($request)
    {
          if(!Validation::validate($request, ['']))
                return ApiReturn::ErrorMessage("Dados invalidos");

            return BankSlip::createPayer($request);
    }

    public function list($id = null)
    {
        return BankSlip::list($id);
    }

    public function edit($id, Request $request)
    {
        if(!Validation::validate($request, ['']) 
        && $id != null )
            return ApiReturn::ErrorMessage("Dados invalidos");

        $request->request->add(['id' => $id]); 
        return BankSlip::edit($request);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return BankSlip::deleteBankSlip($id);
    }
}