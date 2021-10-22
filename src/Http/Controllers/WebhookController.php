<?php

namespace Caiocesar173\Aprobank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\Validation; 
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Models\BankSlip;
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

    public static function webhook(Request $request)
    {
        if(isset($request['modulo']))
        {
            if(isset($request['tipo']))
                if($request['tipo'] === 'boleto')
                    return (new BankSlip())->BankSlipHook($request);
        }

        return [];
    }
}