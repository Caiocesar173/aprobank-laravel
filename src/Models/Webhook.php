<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class Webhook extends Model
{
    private static $url = 'webhook/configuracao';
    
    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            'conta_id' => $data['accountId'],
            'url' => $data['url'],
            'descricao' => $data['description']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar a transferencia');

        return $response;
    }

    public static function list($id = null)
    {
        $response = Aprobank::get(self::$url);

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }

    public static function deleteWebhook($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluir o plano');
        
        return $response;
    } 
}