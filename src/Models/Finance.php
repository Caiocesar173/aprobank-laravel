<?php

namespace Caiocesar173\Aprobank\Models;

use Caiocesar173\Aprobank\Classes\Aprobank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class Finance extends Model
{
    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function extract()
    {
        $response = Aprobank::get('extrato');

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel pegar o extrato', false];
    }

    public static function future()
    {
        $response = Aprobank::get('lancamento-futuro');

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar os lançamentos futuros', false];
    }

    public static function history()
    {
        $response = Aprobank::get('transacao');

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel ver o historico', false];
    }

    public static function transaction($id)
    {
        $url = ($id != null) ? "transacao/$id" : "transacao";
        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar as transações', false];
    }
}