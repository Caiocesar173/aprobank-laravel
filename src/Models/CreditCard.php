<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;
use Caiocesar173\Aprobank\Http\Libraries\Utils;

class CreditCard extends Model
{
    private static $url = 'conta-bancaria';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            "pagador_id" => $data['payerId'],
            "parcelas" => $data['parcel'],
            "valor" => $data['value'],
            "captura" => $data['capture'],
            "cartao" => [
                "nome" => $data['name'],
                "numero" => $data['number'],
                "cvv" => $data['cvv'],
                "mes" => $data['month'],
                "ano" => $data['year'],
            ]
        ];

        $response = Aprobank::post(self::$url, $payload);
        if(!isset($response['conta_id']))
            return ['Não foi possivel criar o Cartão', false];

        return [$response, true];
    }

    public static function createSimple($data)
    {
        $payload = [
            "documento" => Utils::clean($data['document']),
            "celular" => $data['cellphone'],
            "parcelas" => $data['parcel'],
            "valor" => $data['value'],
            "captura" => $data['capture'],
            "cartao" => [
                "nome" => $data['name'],
                "numero" => $data['number'],
                "cvv" => $data['cvv'],
                "mes" => $data['month'],
                "ano" => $data['year'],
            ]
        ];

        $response = Aprobank::post(self::$url, $payload);
        if(!isset($response['conta_id']))
            return ['Não foi possivel criar o cartão', false];

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

    public static function charge($data)
    {
        $payload = [
            "valor" => $data['value']
        ];

        $response = Aprobank::post(self::$url.'/'.$data['id'], $payload);

        if(!isset($response['id']))
            return ['Não foi possivel cobrar', false];

        return [$response, true];
    }

    public static function chargeback($data)
    {
        $response = Aprobank::post(self::$url.'/'.$data['id']);

        if(!isset($response['success']))
            return ['Não foi possivel extornar a transação', false];

        return [$response, true];
    }
}