<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Subscrition;


class SubscritionController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['planId', 'payerId']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Subscrition::create($request);
    }

    public function list($id = null)
    {
        return Subscrition::list($id);
    }

    public function edit($id, Request $request)
    {
        if(!Validation::validate($request, ['']) 
        && $id != null )
            return ApiReturn::ErrorMessage("Dados invalidos");

        $request->request->add(['id' => $id]); 
        return Subscrition::edit($request);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Subscrition::deleteSubscrition($id);
    }
}