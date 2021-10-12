<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class SubscritionPlan extends Model
{
    private static $url = 'plano-assinatura';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            "nome" => $data['name'],
            "valor" => $data['value'],
            "frequencia" => $data['frequency'],
            "descricao" => $data['description']
        ];
        
        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o plano');

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

    public static function edit($id, $data)
    {
        $payload = [
            "nome" => $data['name'],
            "valor" => $data['value'],
            "frequencia" => $data['frequency'],
            "descricao" => $data['description']
        ];

        $response = Aprobank::put(self::$url.'/'.$id);

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel editar');
    }

    public static function deleteSubscrition($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluir o plano');
        
        return $response;
    } 
}