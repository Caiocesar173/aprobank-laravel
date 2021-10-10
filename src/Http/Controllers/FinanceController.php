<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Aprobank\Libraries\Utils;
use Aprobank\Libraries\Validation; 
use Aprobank\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Document;


class DocumentController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Document::create($request);
    }

    
    public function extract(Request $request)
    {
        if(!Validation::validate($request, ['']))
        return ApiReturn::ErrorMessage("Dados invalidos");

        return Document::extract($request);
    }

    public function future(Request $request)
    {
        if(!Validation::validate($request, ['']))
        return ApiReturn::ErrorMessage("Dados invalidos");

        return Document::future($request);
    }

    public function history(Request $request)
    {
        if(!Validation::validate($request, ['']))
        return ApiReturn::ErrorMessage("Dados invalidos");

        return Document::history($request);
    }

    public function transaction(Request $request)
    {
        if(!Validation::validate($request, ['']))
        return ApiReturn::ErrorMessage("Dados invalidos");

        return Document::transaction($request);    
    }

}