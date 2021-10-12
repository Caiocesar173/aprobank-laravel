<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;

class BankSlip extends Model
{
    private static $url = 'boleto';

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

        if(!isset($response['transaction_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o Boleto');

        return $response;
    }
    
    public static function createPayer($data)
    {
        $payload = [
            "pagador" => [
                "documento" => $data['document'],
                "nome" => $data['name'],
                "celular" => $data['celphone'],
                "data_nascimento" => $data['birthday'],
                "email" => $data['email'],
                "endereco" => [
                    "cep" => $data['zip'],
                    "rua" => $data['street'],
                    "numero" => $data['number'],
                    "complemento" => $data['complement'],
                    "bairro" => $data['district'],
                    "cidade" => $data['city'],
                    "estado" => $data['state']
                ]
            ],
            "valor" => $data['value'],
            "descricao" => $data['description'],
            "instrucao1" => $data['instruction1'],
            "instrucao2" => $data['instruction2'],
            "instrucao3" => $data['instruction3'],
            "data_vencimento" => $data['dueDate']
        ];

        $response = Aprobank::post(self::$url, $payload);

        if(!isset($response['transaction_id']))
            return ApiReturn::ErrorMessage('Não foi possivel criar o boleto');

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

    public static function deleteBankSlip($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return ApiReturn::ErrorMessage('Não foi possivel excluir o boleto');
        
        return $response;
    } 
}