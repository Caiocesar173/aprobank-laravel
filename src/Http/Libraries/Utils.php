<?php 

namespace Caiocesar173\Aprobank\Http\Libraries;


class Utils{

    public static function clean($string) 
    {
        $string = str_replace('-', '', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    public static function formatResponse($response, $type)
    {
        if($type === 'bank_slip' )
            return self::formatBankSlip($response);
    }

    public static function Mask($mask,$str){

        $str = str_replace(" ","",$str);
    
        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }
    
        return $mask;
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
            
            "booklet" => $response['carne']
        ];

        return $bankSlip;
    }

    private static function formatPayer($data)
    {

    }

    
}