<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class Profile extends Model
{
    private static $url = 'perfil';
    
    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function list()
    {
        $response = Aprobank::get(self::$url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', false];
    }

    public static function edit($data)
    {
        if(isset($data['name']))
            $payload['nome'] = $data['name'];
        if(isset($data['celphone']))
            $payload['celphone'] = $data['celphone'];
        if(isset($data['corporateName']))
            $payload['razao_social'] = $data['corporateName'];
        if(isset($data['email']))
            $payload['email'] = $data['email'];
        if(isset($data['site']))
            $payload['site'] = $data['site'];
        if(isset($data['address']['zip']))
            $payload["endereco"]["cep"] = $data['address']['zip'];
        if(isset($data['address']['street']))
            $payload["endereco"]["rua"] = $data['address']['street'];
        if(isset($data['address']['number']))
            $payload["endereco"]["numero"] = $data['address']['number'];
        if(isset($data['address']['complement']))
            $payload["endereco"]["complemento"] = $data['address']['complement'];
        if(isset($data['address']['district']))
            $payload["endereco"]["bairro"] = $data['address']['district'];
        if(isset($data['address']['city']))
            $payload["endereco"]["cidade"] = $data['address']['city'];
        if(isset($data['address']['state']))
            $payload["endereco"]["estado"] = $data['address']['state'];

        $response = Aprobank::put(self::$url, $payload);

        if(!isset($response['id']))
            return ['Não foi possivel editar o perfil', false];
            
        return [$response, true];
    }
}