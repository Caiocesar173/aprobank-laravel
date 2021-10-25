<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class Users extends Model
{
    private static $url = 'user';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            'conta_id' => $data['accountId'],
            'email' => $data['email']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['id']))
            return ['Não foi possivel criar o usuario', false];

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

    public static function createPassword($userId, $data)
    {
        $payload = [
            'email' => $data['email'],
            'token' => $data['token'],
            'password' => $data['password'],
            'password_confirmation' => $data['passwordConfirmation'],
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['id']))
            return ['Não foi possivel criar a senha', false];

        return [$response, true];
    }

    public static function changePassword($userId, $data)
    {
        $payload = [
            'password' => $data['password'],
            'password_confirmation ' => $data['passwordConfirmation']
        ];

        $response = Aprobank::put(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ['Não foi possivel trocar de senha', false];

        return [$response, true];
    }

}