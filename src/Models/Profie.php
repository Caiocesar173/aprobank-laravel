<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class Profie extends Model
{
    private static $url = 'perfil';
    
    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function list($id = null)
    {
        $response = Aprobank::get(self::$url);

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }

    public static function createPassword($profileId, $data)
    {
        $payload = [
            "nome" => $data['name'],
            "celular" => $data['celphone'],
            "razao_social" => $data['corporateName'],
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

        if(!isset($response['id']))
            return ApiReturn::ErrorMessage('Não foi possivel editar o perfil');

        return $response;
    }
}