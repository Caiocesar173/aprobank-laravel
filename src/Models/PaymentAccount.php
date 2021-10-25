<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\Utils;
use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class PaymentAccount extends Model
{
    private static $url = 'conta';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            "documento" => Utils::clean($data['document']),
            "nome" => $data['name'],
            "celular" => $data['celphone'],
            "data_nascimento" => $data['birthday'],
            "endereco" => [
                "cep" =>         $data['address']['zip'],
                "rua" =>         $data['address']['street'],
                "numero" =>      $data['address']['number'],
                "complemento" => $data['address']['complement'],
                "bairro" =>      $data['address']['district'],
                "cidade" =>      $data['address']['city'],
                "estado" =>      $data['address']['state']
            ]
        ];

        if(isset($data['coporateName']))
            $payload['razao_social'] = $data['coporateName'];
        if(isset($data['cnpj']))
            $payload['cnpj'] = $data['cnpj'];
        if(isset($data['email']))
            $payload['email'] = $data['email'];
        if(isset($data['site']))
            $payload['site'] = $data['site'];

        $response = Aprobank::post(self::$url, $payload);
        return $response->json();

        if(!isset($response['conta_id']))
            return ['Não foi possivel criar a conta', false];

        return [$response, true];
    }

    public static function list($id = null)
    {
        $url = 'contas';
        if($id != null)
            $url = self::$url.'/'.$id;

        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', false];
    }

    public static function edit($PaymentAccountId, $data)
    {
        if(isset($data['document']))
        $payload['documento'] = $data['document'];

        if(isset($data['name']))
            $payload['nome'] = $data['name'];

        if(isset($data['celphone']))
            $payload['celular'] = $data['celphone'];

        if(isset($data['birthday']))
            $payload['data_nascimento'] = $data['birthday'];

        if(isset($data['coporateName']))
            $payload['razao_social'] = $data['coporateName'];
            
        if(isset($data['cnpj']))
            $payload['cnpj'] = $data['cnpj'];

        if(isset($data['email']))
            $payload['email'] = $data['email'];
            
        if(isset($data['site']))
            $payload['site'] = $data['site'];

        if(isset($data['address']['zip']))
            $payload["cep"] = $data['address']['zip'];

        if(isset($data['address']['street']))
            $payload["rua"] = $data['address']['street'];

        if(isset($data['address']['number']))
            $payload["numero"] = $data['address']['number'];

        if(isset($data['address']['complement']))
            $payload["complemento"] = $data['address']['complement'];

        if(isset($data['address']['district']))
            $payload["bairro"] = $data['address']['district'];

        if(isset($data['address']['city']))
            $payload["cidade"] = $data['address']['city'];

        if(isset($data['address']['state']))
            $payload["estado"] = $data['address']['state'];


        $response = Aprobank::put(self::$url.'/'.$PaymentAccountId, $payload);

        if(!isset($response['conta_id']))
            return ['Não foi possivel editar a conta', false];

        return [$response, true];
    }

    public static function deletePaymentAccount($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ['Não foi possivel excluir a conta', false];
        
        return [$response, true];
    } 
}