<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Aprobank\Libraries\Utils;
use Aprobank\Libraries\Validation; 
use Aprobank\Libraries\ApiReturn;

use Caiocesar173\Aprobank\Models\Webhook;


class WebhookController extends Controller
{
    public function __construct() 
    { 
    }

    public function create(Request $request)
    {
        if(!Validation::validate($request, ['accountId', 'url', 'description']))
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Webhook::create($request);
    }

    public function list($id = null)
    {
        return Webhook::list($id);
    }

    public function delete($id)
    {
        if(!empty($id) && $id != null)
            return ApiReturn::ErrorMessage("Dados invalidos");

        return Webhook::deleteWebhook($id);
    }
}