<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;

class BankAccount extends Model
{
    private static $url = 'conta-bancaria';

    protected $table = 'account';
    protected $primaryKey = 'id';

    protected $fillable = [
        'accountId',
        'bankCode',
        'agency',
        'type',
        'account',
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
            return ApiReturn::ErrorMessage('Não foi possivel criar a conta bancaria');

        return $response->json();
    }

    public static function list($id = null)
    {
        $url = self::$url;
        if($id != null)
            $url = (self::$url.'/'.$id);

        $response = Aprobank::get($url);

        if(is_array($response->json()))
            return $response->json();
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }

    public static function deleteBankAccount($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluir a conta bancaria');
        
        return $response->json();
    }
}