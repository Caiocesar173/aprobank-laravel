<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class PaymentSplit extends Model
{
    private static $url = 'split';

    protected $table = 'payment_split';
    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid_external',
        'bank_user_id',
        'account_id',
        'value',
        'type_user',
        'type_value',
        'type_partition',
    ];


    public static function create($data)
    {
        $payload = [
            'cobranca_boleto_ou_cartao_id' => $data['billingId'],
            'conta_id' => $data['accountId'],
            'porcentagem' => $data['percentage'],
            'valor' => $data['value'],
            'responsavel_pelo_prejuizo' => $data['responsable'],
            'usar_valor_liquido' => $data['liquidValue']
        ];

        $response = Aprobank::post(self::$url, $payload);
        
        if(!isset($response['conta_id']))
            return ['Não foi possivel criar o split', false];
        
        return [$response, true];
    }

    public static function list($id = null)
    {
        $response = Aprobank::get( self::$url.'/'.$id );

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', false];
    }

    public static function deletePaymentSplit($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ['Não foi possivel excluir o split', false];
        
        return [$response, true];
    } 
}