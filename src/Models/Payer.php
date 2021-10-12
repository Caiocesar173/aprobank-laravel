<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class Payer extends Model
{
    private static $url = 'pagador';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            "nome" => $data['name'],
            "documento" => $data['document'],
            "celular" => $data['celphone'],
            "data_nascimento" => $data['birthday'],
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

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o pagador');

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
            return ApiReturn::ErrorMessage('Não foi possivel editar o pagador');

        return $response;
    }

    public static function deletePayer($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluir o pagador');
        
        return $response;
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
            return ApiReturn::ErrorMessage('Não foi possivel editar o pagador');

        return $response;
    }
}