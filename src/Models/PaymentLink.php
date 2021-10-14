<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;

class PaymentLink extends Model
{
    private static $url = 'link-pagamento';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];

    
    public static function create($data)
    {
        $payload = [
            "valor" => $data['value'],
            "limite_parcelas" => $data['parcelLimit'],
            "senha" => $data['password'],
            "vencimento" => $data['dueDate']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o link de pagamento');

        return $response;
    }

    public static function list($id = null)
    {
        $url = self::$url;
        if($id != null)
            $url = self::$url.'/'.$id;

        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }

    public static function deletePaymentLink($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluia o link de pagamento');
        
        return $response;
    } 

    public static function checkPassword($data)
    {
        $payload = [
            "link_pagamento_id" => $data['paymentLinkId'],
            "senha" => $data['password']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o link de pagamento');

        return $response;
    }

    public static function pay($data)
    {
        $payload = [
            "pagador_id" => $data['payerId'],
            "parcelas" => $data['parcel'],
            "cartao" => [
                "nome" => $data['name'],
                "numero" => $data['number'],
                "cvv" => $data['cvv'],
                "mes" => $data['month'],
                "ano" => $data['year']
            ]
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o link de pagamento');

        return $response;
    }
}