<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Document;


class DocumentController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['category', 'file', 'description', 'meta']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Document::create($request);
    }

    public function list($id = null)
    {
        return Document::list($id);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Document::deleteDocument($id);
    }
}