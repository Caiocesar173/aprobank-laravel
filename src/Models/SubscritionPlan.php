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
            return ['Não foi possivel criar o plano', false];

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
            return [$response, true];
        
        return ['Não foi possivel editar', false];
    }

    public static function deleteSubscrition($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ['Não foi possivel excluir o plano', false];
        
        return [$response, true];
    } 
}