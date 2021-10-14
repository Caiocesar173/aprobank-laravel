<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class Transfers extends Model
{
    private static $url = 'transferencia';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            "conta_destino_id" => $data['destinationAccountId'],
            "valor" => $data['value'],
            "descricao" => $data['discription']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar a transferencia');

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
}