<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Http\Libraries\Utils;

use Caiocesar173\Aprobank\Classes\Aprobank;
use Caiocesar173\Aprobank\Events\BankSlipHookEvent;

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
        ];


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

        if(isset($response['errors']))
            return [Utils::ArrayFlatten($response['errors']), false];

        return [Utils::formatResponse($response, self::$type), true];
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
        
        if(isset($response['errors']))
            return [Utils::ArrayFlatten($response['errors']), false];

        return [Utils::formatResponse($response, self::$type), true];
    }  

    public function edit($id, $data, string $type = 'id') 
    {
        $bankslip = $this->select('*')->where("$type", '=', "$id")->first();

        if(is_null($bankslip))
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
 
        return $bankslip->save() ? ['Boleto editado com sucesso', true] : ['Não foi possivel editar o Boleto', false];
    }

    public static function list($id = null)
    {
        $url = ($id != null) ? self::$url."/$id" : self::$url;
        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return ['Não foi possivel listar', false];
    }

    public static function deleteBankSlip($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ['Não foi possivel excluir o boleto', false];
        
        return ['Boleto excluido com sucesso', true];
    }  

    public function BankSlipHook($request)
    {
        if(isset($request['conteudo']))
        {   
            $uuid_external = $request['conteudo']['id'];
            $bankslip = self::select('*')->where("uuid_external", '=', "$uuid_external")->first();
            
            if($bankslip == null)
                return ['bankslip not found', false];

            $response = self::list($bankslip->id);
            $response = self::FormatHook($response);

            return $this->edit($bankslip->id, $response)[1] ? event(new BankSlipHookEvent( $bankslip )) : false;
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