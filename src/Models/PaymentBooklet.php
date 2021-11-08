<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;
use Caiocesar173\Aprobank\Http\Libraries\Utils;

class PaymentBooklet extends Model
{
    private static $url = 'carne';
    private static $type = 'booklet';

    protected $table = 'booklets';
    protected $primaryKey = 'id';

    protected $fillable = [
    ];


    public static function create($data)
    {
        $payload = [
            'pagador_id' => $data['payerId'],
            'valor' => $data['value'],
            'parcelas' => $data['parcels'],
            'descricao' => $data['description'],
            'instrucao1' => $data['instruction1'],
            'instrucao2' => $data['instruction2'],
            'instrucao3' => $data['instruction3'],
            'data_vencimento' => $data['dueDate'],
        ];

        if(isset($data['dueDate']))
            $payload['data_vencimento'] = $data['dueDate'];

        if(isset($data['penaltyType']))
            $payload['tipo_multa'] = $data['penaltyType'];

        if(isset($data['penltyValue']))
            $payload['valor_multa'] = $data['penltyValue'];

        if(isset($data['feeType']))
            $payload['tipo_juros'] = $data['feeType'];

        if(isset($data['feeValue']))
            $payload['valor_juros'] = $data['feeValue'];

        if(isset($data['discountType']))
            $payload['tipo_desconto'] = $data['discountType'];

        if(isset($data['discountValue']))
            $payload['valor_desconto'] = $data['discountValue'];

        if(isset($data['dueDateDiscount']))
            $payload['data_limite_valor_desconto'] = $data['dueDateDiscount'];

        
        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['conta_id']))
            return ['Não foi possivel criar o carnê', false];

        $slips = self::list($response['id']);
        if(is_string($slips[0]))
            throw new \Exception($slips[0], 1);

        $booklet = [];
        foreach ($slips['boleto'] as $slip) 
        {
            $slip = [Utils::formatResponse($slip, self::$type), true];
            array_push($booklet, $slip);
        }

        return $booklet;

    }

    public static function list($id = null)
    {
        $url = ($id != null) ? self::$url."/$id" : self::$url;
        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', false];
    }

    public static function edit($PaymentBookletId, $data)
    {
    }

    public static function deletePaymentBooklet($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ['Não foi possivel excluir o carne', false];
        
        return [$response, true];
    } 
}