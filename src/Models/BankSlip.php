<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Http\Libraries\Utils;

use Caiocesar173\Aprobank\Classes\Aprobank;

class BankSlip extends Model
{
    private static $url = 'boleto';
    private static $type = 'bank_slip';

    protected $table = 'bankslip';
    protected $primaryKey = 'id';

    protected $fillable = [
        'payerId',
        'transactionId',
        'digitableLine',
        'responsable',
        'client_id',
        'url',
        'documentNumber',
        'value',
        'description',
        'instruction1',
        'instruction2',
        'instruction3',
        'dueDate',
        'penaltyType',
        'penltyValue',
        'feeType',
        'feeValue',
        'discountType',
        'discountValue',
        'dueDateDiscount',
        'payed_at'
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
        return $response->json();

        if(!isset($response['transaction_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o Boleto');

        return Utils::formatResponse($response, self::$type);
    }
    
    public static function createPayer($data)
    {
        $payload = [
            "pagador" => [
                "documento" => Utils::clean($data['document']),
                "nome" => $data['name'],
                "celular" => $data['celphone'],
                "data_nascimento" => $data['birthday'],
                "email" => $data['email'],
                "endereco" => [
                    "cep" =>         Utils::Mask("#####-###", $data['address']['zip']),
                    "rua" =>         $data['address']['street'],
                    "numero" =>      $data['address']['number'],
                    "complemento" => $data['address']['complement'],
                    "bairro" =>      $data['address']['district'],
                    "cidade" =>      $data['address']['city'],
                    "estado" =>      $data['address']['state']
                ]
            ],
            "valor" => $data['value'],
            "descricao" => $data['description'],
            "instrucao1" => $data['instruction1'],
            "instrucao2" => $data['instruction2'],
            "instrucao3" => $data['instruction3'],
            "data_vencimento" => $data['dueDate'],
        ];
        
        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['transaction_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o boleto');

        return Utils::formatResponse($response, self::$type);
    }  

    public static function edit($id, $data) 
    {
        $bankslip = self::find($id);

        if($bankslip == null)
            return 'bankslip not found';

        if(isset($data['status']))
            $bankslip->status = $data['status'];

        if(isset($data['digitableLine']))
            $bankslip->digitableLine = $data['digitableLine'];

        if(isset($data['url']))
            $bankslip->url = $data['url'];

        if(isset($data['documentNumber']))
            $bankslip->documentNumber = $data['documentNumber'];

        if(isset($data['value']))
            $bankslip->value = $data['value'];

        if(isset($data['description']))
            $bankslip->description = $data['description'];

        if(isset($data['instruction1']))
            $bankslip->instruction1 = $data['instruction1'];

        if(isset($data['instruction2']))
            $bankslip->instruction2 = $data['instruction2'];

        if(isset($data['instruction3']))
            $bankslip->instruction3 = $data['instruction3'];

        if(isset($data['dueDate']))
            $bankslip->dueDate = $data['dueDate'];

        if(isset($data['penaltyType']))
            $bankslip->penaltyType = $data['penaltyType'];

        if(isset($data['penltyValue']))
            $bankslip->penltyValue = $data['penltyValue'];

        if(isset($data['feeType']))
            $bankslip->feeType = $data['feeType'];

        if(isset($data['feeValue']))
            $bankslip->feeValue = $data['feeValue'];

        if(isset($data['discountType']))
            $bankslip->discountType = $data['discountType'];

        if(isset($data['discountValue']))
            $bankslip->discountValue = $data['discountValue'];

        if(isset($data['dueDateDiscount']))
            $bankslip->dueDateDiscount = $data['dueDateDiscount'];

        if(isset($data['payed_at']))
            $bankslip->payed_at = $data['payed_at'];
 
        return $bankslip->save();
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

    public static function deleteBankSlip($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluir o boleto');
        
        return $response;
    }  

    public static function BankSlipHook($request)
    {
        if(isset($request['conteudo']))
        {
            $id = $request['conteudo']['id'];
            $response = self::list($id);
            $response = self::FormatHook($response);
            return self::edit($id, $response, 'bank_slip');
        }            
    }

    public static function FormatHook($response)
    {
        return [
            'status'         => isset($response['status']) ? $response['status'] : null,
            'digitableLine'  => isset($response['linha_digitavel']) ? $response['linha_digitavel'] : null,
            'url'            => isset($response['url']) ? $response['url'] : null,
            'documentNumber' => isset($response['numero_documento']) ? $response['numero_documento'] : null,
            'value'          => isset($response['valor']) ? $response['valor'] : null,
            'description'    => isset($response['descricao']) ? $response['descricao'] : null,
            'instruction1'   => isset($response['instrucao1']) ? $response['instrucao1'] : null,
            'instruction2'   => isset($response['instrucao2']) ? $response['instrucao2'] : null,
            'instruction3'   => isset($response['instrucao3']) ? $response['instrucao3'] : null,
            'dueDate'        => isset($response['data_vencimento']) ? $response['data_vencimento'] : null,
            'penaltyType'    => isset($response['tipo_multa']) ? $response['tipo_multa'] : null,
            'penltyValue'    => isset($response['valor_multa']) ? $response['valor_multa'] : null,
            'feeType'        => isset($response['tipo_juros']) ? $response['tipo_juros'] : null,
            'feeValue'       => isset($response['valor_juros']) ? $response['valor_juros'] : null,
            'discountType'   => isset($response['tipo_desconto']) ? $response['tipo_desconto'] : null,
            'discountValue'  => isset($response['valor_desconto']) ? $response['valor_desconto'] : null,
            'dueDateDiscount'=> isset($response['data_limite_valor_desconto']) ? $response['data_limite_valor_desconto'] : null,
            'payed_at'       => isset($response['data_pagamento']) ? $response['data_pagamento'] : null,
        ];      
    }
}