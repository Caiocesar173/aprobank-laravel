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
                    "cep" =>         self::Mask("#####-###", $data['address']['zip']),
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

    function Mask($mask,$str){

        $str = str_replace(" ","",$str);
    
        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }
    
        return $mask;
    
    }
}