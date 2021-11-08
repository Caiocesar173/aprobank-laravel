<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Caiocesar173\Aprobank\Classes\Aprobank;
use Caiocesar173\Aprobank\Http\Libraries\Utils;

class Payer extends Model
{
    private static $url = 'pagador';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data, $model)
    {
        $payload = [
            "nome" => $data['name'],
            "documento" => Utils::clean($data['document']),
            "celular" => $data['celphone'],
            "data_nascimento" => $data['birthday'],
            "email" => $data['email'],
            "endereco" => [
                "cep" => $data['address']['zip'],
                "rua" => $data['address']['street'],
                "numero" => $data['address']['number'],
                "complemento" => $data['address']['complement'],
                "bairro" => $data['address']['district'],
                "cidade" => $data['address']['city'],
                "estado" => $data['address']['state']
            ]
        ];

        $response = Aprobank::post(self::$url, $payload);
        
        if(isset($response['errors']))
            return [Utils::ArrayFlatten($response['errors']), false];
        
        return BankUser::create(Utils::formatResponse($response, 'payer'), $model);
    }

    public static function list($id = null, $payload = null)
    {
        $url = ($id != null) ? self::$url."/$id" : self::$url;
        $response = Aprobank::get($url, $payload);

        if(isset($response['errors']))
            return [Utils::ArrayFlatten($response['errors']), false];
        
        return [$response, true];
    }

    public static function listAll()
    {
        $curentPage = 1;
        $payload = null;
        $response = Aprobank::get(self::$url, $payload);
        
        if(isset($response['data']))
        {
            $list = [];
            $pages = $response['last_page'];
            for ($curentPage; $curentPage <= $pages; $curentPage++) 
            { 
                $payload = ["page" => $curentPage];
                $response = Aprobank::get(self::$url, $payload);
                if(isset($response['data']))
                    foreach ($response['data'] as $data)
                        array_push($list, $data);

            }
            return $list;
        }
        return [];
    }

    public static function edit($payerId, $data)
    {
        $payload = [
            "nome" => $data['name'],
            "celular" => $data['celphone'],
            "email" => $data['email'],
            "endereco" => [
                "cep" => $data['zip'],
                "rua" => $data['street'],
                "numero" => $data['number'],
                "complemento" => $data['complement'],
                "bairro" => $data['district'],
                "cidade" => $data['city'],
                "estado" => $data['state']
            ]
        ];

        $response = Aprobank::put(self::$url.'/'.$payerId, $payload);

        if(isset($response['errors']))
            return [Utils::ArrayFlatten($response['errors']), false];

        return [$response, true];
    }

    public static function deletePayer($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(isset($response['errors']))
            return [Utils::ArrayFlatten($response['errors']), false];

        return [$response, true];
    } 

    public static function associate($data)
    {       
        $id = $data['payerId'];

        $payload = [
            "nome" => $data['name'],
            "numero" => $data['number'],
            "cvv" => $data['cvv'],
            "mes" => $data['month'],
            "ano" => $data['year']
        ];

        $response = Aprobank::post(self::$url.'/'.$id, $payload);

        if(isset($response['errors']))
            return [Utils::ArrayFlatten($response['errors']), false];

        return [$response, true];
    }
}