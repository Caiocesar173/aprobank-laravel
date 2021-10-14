<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class PaymentBooklet extends Model
{
    private static $url = 'carne';

    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            'pagador_id' => $data['payerId'],
            'valor' => $data['value'],
            'descricao' => $data['description'],
            'instrucao1' => $data['instruction1'],
            'instrucao2' => $data['instruction2'],
            'instrucao3' => $data['instruction3'],
            'data_vencimento' => $data['dueDate'],
            'tipo_multa' => $data['penaltyType'],
            'valor_multa' => $data['penltyValue'],
            'tipo_juros' => $data['feeType'],
            'valor_juros' => $data['feeValue'],
            'tipo_desconto' => $data['discountType'],
            'valor_desconto' => $data['discountValue'],
            'data_limite_valor_desconto' => $data['dueDateDiscount']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o carnê');

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

    public static function edit($PaymentBookletId, $data)
    {
    }

    public static function deletePaymentBooklet($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluir a conta');
        
        return $response;
    } 
}