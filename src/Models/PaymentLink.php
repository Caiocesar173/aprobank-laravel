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
            return ['Não foi possivel criar o link de pagamento', false];

        return [$response, true];
    }

    public static function list($id = null)
    {
        $url = ($id != null) ? self::$url."/$id" : self::$url;
        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', false];
    }

    public static function deletePaymentLink($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ['Não foi possivel excluia o link de pagamento', false];
        
        return [$response, true];
    } 

    public static function checkPassword($data)
    {
        $payload = [
            "link_pagamento_id" => $data['paymentLinkId'],
            "senha" => $data['password']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ['Não foi possivel criar o link de pagamento', false];

        return [$response, true];
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
            return ['Não foi possivel criar o link de pagamento', false];

        return [$response, true];
    }
}