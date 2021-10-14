<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Payer;


class PayerController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        

        if(!Validation::validate($request, ['name', 'document', 'celphone', 'birthday', 'email', 'address']))
            return ApiReturn::ErrorMessage("Dados invalidos");
        
        if(!Validation::validateArray($request['address'], ['zip', 'street', 'number', 'complement', 'district', 'city', 'state']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Payer::create($request);
    }

    public function list($id = null)
    {
        return Payer::list($id);
    }

    public function edit($id, Request $request)
    {
        if(!Validation::validate($request, ['name', 'celphone', 'email', 'zip', 'street', 'number', 'complement', 'district', 'city', 'state']) 
        && $id != null )
            return ApiReturn::ErrorMessage("Dados invalidos");

        $request->request->add(['id' => $id]); 
        return Payer::edit($request);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Payer::deletePayer($id);
    }

    public function associate(Request $request) 
    {
        if(!Validation::validate($request, ['payerId', 'name', 'number', 'cvv', 'month', 'year']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Payer::associate($request);
    }
}