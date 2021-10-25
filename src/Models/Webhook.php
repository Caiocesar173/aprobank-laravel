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
            return ['Não foi possivel criar o webhook', false];

        return [$response, true];
    }

    public static function list()
    {
        #Aprobank doesn't support searching by Id.
        $response = Aprobank::get(self::$url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', false];
    }

    public static function deleteWebhook($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ['Não foi possivel excluir o webhook', false];
        
        return [$response, true];
    } 
}