<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;

class BankAccount extends Model
{
    private static $url = 'conta-bancaria';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            "banco" => $data['bankCode'],
            "agencia" => $data['agency'],
            "tipo" => $data['type'],
            "conta" => $data['account'],
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar a Conta Bancaria');

        return $response;
    }

    public static function list($id = null)
    {
        if($id != null)
            self::$url = self::$url.'/'.$id;

        $response = Aprobank::get(self::$url);

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }

    public static function deleteBankAccount($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel listar');
        
        return $response;
    } 
}