<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class Document extends Model
{
    private static $url = 'documento';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        
        $payload = [
            "categoria" => $data['category'],
            "arquivo" => $data['file'],
            "descricao" => $data['description'],
            "meta_dados" => $data['meta']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ['Não foi possivel criar o documento', true];

        return [$response, true];
    }

    public static function list($id = null)
    {
        $url = ($id != null) ? self::$url."/$id" : self::$url;
        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', true];
    }

    public static function deleteDocument($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ['Não foi possivel excluir a assinatura', true];
        
        return [$response, true];
    } 
}