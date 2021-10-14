<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;

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
            return ApiReturn::ErrorMessage('Não foi possivel criar o Cartão');

        return $response;
    }

    public static function createSimple($data)
    {
        $payload = [
            "documento" => Utils::clean($date['document']),
            "celular" => $date['cellphone'],
            "parcelas" => $date['parcel'],
            "valor" => $date['value'],
            "captura" => $date['capture'],
            "cartao" => [
                "nome" => $date['name'],
                "numero" => $date['number'],
                "cvv" => $date['cvv'],
                "mes" => $date['month'],
                "ano" => $date['year'],
            ]
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o Cartão');

        return $response;
    }

    public static function list($id = null)
    {
        $url = self::$url;
        if($id != null)
            $url = (self::$url.'/'.$id);

        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }

    public static function charge($data)
    {
        $payload = [
            "valor" => $data['value']
        ];

        $response = Aprobank::post(self::$url.'/'.$data['id'], $payload);

        if(!isset($response['id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o Cartão');

        return $response;
    }

    public static function chargeback($data)
    {
        $response = Aprobank::post(self::$url.'/'.$data['id']);

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o Cartão');

        return $response;
    }
}