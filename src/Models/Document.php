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
            return ApiReturn::ErrorMessage('Não foi possivel criar o documento');

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

    public static function deleteDocument($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluir a assinatura');
        
        return $response;
    } 
}