<?php 

namespace Caiocesar173\Aprobank\Http\Libraries;


class Utils
{

    public static function clean($string) 
    {
        $string = str_replace('-', '', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    public static function ArrayFlatten(array $array) {
        $flatten = array();
        array_walk_recursive($array, function($value) use(&$flatten) {
            $flatten[] = $value;
        });
    
        return $flatten;
    }

    public static function Mask($mask,$str){

        if(str_contains($str, '-'))
            return $str;

        $str = str_replace(" ","",$str);
    
        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }
    
        return $mask;
    }

    public static function formatResponse($response, $type)
    {
        if($type === 'bank_slip' || $type === 'booklet')
            return self::formatBankSlip($response);

        if($type === 'payer')
            return self::formatPayer($response);
    }

    private static function formatBankSlip($response)
    {
        $bankSlip = [
            "billetId" => $response['id'],
            "payerId" => $response['pagador_id'],
            "transactionId" => $response['transaction_id'],
            "documentNumber" => $response['numero_documento'],
        
            "value" => $response['valor'],
            "fee" => $response['taxa'],
            
            "dueDate" => $response['data_vencimento'],
            "description" => $response['descricao'],
            "instructions" => [
                "1" => $response['instrucao1'],
                "2" => $response['instrucao2'],
                "3" => $response['instrucao3'],
            ],
        
            "digitableLine" => $response['linha_digitavel'],
            "url" => $response['url'],
            
            "booklet" => isset($response['carne']) ? $response['carne'] : '',
        ];
        
        if(isset($response['carne_id']))
            $bankSlip["bookletId"] = $response['carne_id'];

        return $bankSlip;
    }

    private static function formatPayer($data)
    {
        $payer = [
            'payerId' => $data['id'],
            'accountId' =>$data['conta_id'],
            'buyerId' => $data['buyer_id'],
            'addressId' => $data['endereco_id'],
        ];

        return $payer;
    }
}