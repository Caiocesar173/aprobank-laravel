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
            return ApiReturn::ErrorMessage('Não foi possivel criar o usuario');

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
            return ApiReturn::ErrorMessage('Não foi possivel criar a senha');

        return $response;
    }

    public static function changePassword($userId, $data)
    {
        $payload = [
            'password' => $data['password'],
            'password_confirmation ' => $data['passwordConfirmation']
        ];

        $response = Aprobank::put(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel trocar de senha');

        return $response;
    }

}