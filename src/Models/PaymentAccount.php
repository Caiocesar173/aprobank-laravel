<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class PaymentAccount extends Model
{
    private static $url = 'contas';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            "documento" => $data['document'],
            "nome" => $data['name'],
            "razao_social" => $data['coporateName'],
            "cnpj" => $data['cnpj'],

            "celular" => $data['celphone'],
            "data_nascimento" => $data['birthday'],
            "email" => $data['email'],
            "site" => $data['site'],
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
            return ApiReturn::ErrorMessage('Não foi possivel criar a conta');

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


    public static function edit($PaymentAccountId, $data)
    {
        $payload = [
            "nome" => $data['name'],
            "razao_social" => $data['coporateName'],
            "celular" => $data['celphone'],
            "email" => $data['email'],
            "site" => $data['site'],
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

        $response = Aprobank::put(self::$url.'/'.$PaymentAccountId, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel editar a conta');

        return $response;
    }

    public static function deletePaymentAccount($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluir a conta');
        
        return $response;
    } 
}