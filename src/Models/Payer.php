<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;
use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Spatie\Ray\Payloads\Payload;

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

        if(!isset($response['id']))
            return ['Não foi possivel criar o pagador', false];
        
        return BankUser::create(Utils::formatResponse($response, 'payer'), $model);
    }

    public static function list($id = null)
    {
        $url = ($id != null) ? self::$url."/$id" : self::$url;
        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', false];
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

        if(!isset($response['conta_id']))
            return ['Não foi possivel editar o pagador', false];

        return [$response, true];
    }

    public static function deletePayer($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ['Não foi possivel excluir o pagador', false];
        
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

        if(!isset($response['conta_id']))
            return ['Não foi possivel editar o pagador', false];

        return [$response, true];
    }
}