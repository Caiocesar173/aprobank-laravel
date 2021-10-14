<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Finance extends Model
{
    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function extract($data)
    {
        $response = Aprobank::get('extrato');

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }

    public static function future($data)
    {
        $response = Aprobank::get('lancamento-futuro');

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }

    public static function history($data)
    {
        $response = Aprobank::get('transacao');

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }

    public static function transaction($id)
    {
        $response = Aprobank::get('transacao'.'/'.$id);

        if(isset($response['data']) || isset($response['id']))
            return $response;
        
        return ApiReturn::ErrorMessage('Não foi possivel listar');
    }
}