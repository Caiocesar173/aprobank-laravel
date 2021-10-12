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

    public function list($id = null)
    {
        return Document::list($id);
    }

    public function edit(Request $request)
    {
        if(!Validation::validate($request, ['name', 'celphone', 'corporateName', 'email', 'site', 'zip', 'street', 'number', 'complement', 'district', 'city', 'state']) )
            return ApiReturn::ErrorMessage("Dados invalidos");

        $request->request->add(['id' => $id]); 
        return Document::edit($request);
    }
}