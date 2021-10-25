<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class Withdraw extends Model
{
    private static $url = 'saque';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            'conta_bancaria_id' => $data['bankAccountId'],
            'valor' => $data['value'],
            'descricao' => $data['description']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ['Não foi possivel criar o saque', false];

        return [$response, true];
    }

    public static function list()
    {
        $response = Aprobank::get(self::$url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', false];
    }
}