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
    
    public function extract(Request $request)
    {
        return Document::extract($request);
    }

    public function future(Request $request)
    {
        return Document::future($request);
    }

    public function history(Request $request)
    {
        return Document::history($request);
    }

    public function transaction(Request $request, $id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Document::transaction($request);    
    }

}