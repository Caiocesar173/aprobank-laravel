<?php

namespace Aprobank\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class Validation
{
    public static function validate($request, $fields = [], $rules = 'required'){
        $data = $request->all();

        $validator = Validator::make(
            $data,
            self::createDataValidate($fields, $rules)
        );
        
        if ($validator->fails())
            return false;

        return true;
    }

    public static function validateArray($data, $fields = [], $rules = 'required')
    {   
        $validator = Validator::make(
            $data,
            self::createDataValidate($fields, $rules)
        );
    
        if ($validator->fails())
            return false;

        return true;
    }

    private static function createDataValidate($fields, $rules){
        $data = [];

        foreach($fields as $field){
           $data[$field] = $rules; 
        }

        return $data;
    }

    public static function validateCPF_CNPJ($cpf_cnpj)
    {
        if(empty($cpf_cnpj))
            return false;

        $cpf_cnpj = preg_replace('/[^0-9]/', '', $cpf_cnpj);
        
        #dd($cpf_cnpj);
        //Caso seja CNPJ
        if(strlen($cpf_cnpj) > 11) 
            return self::validateCNPJ($cpf_cnpj);

        //Caso seja CPF
        return self::validateCPF($cpf_cnpj);
    }

    public static function checkCPF_CNPJ($cpf_cnpj)
    {
        if(empty($cpf_cnpj))
            return false;

        $cpf_cnpj = preg_replace('/[^0-9]/', '', $cpf_cnpj);
        
        //Caso seja CNPJ
        if(strlen($cpf_cnpj) > 11) 
            return 'CNPJ';

        //Caso seja CPF
        return 'CPF';
    }

    // Validar numero de cpf
    public static function validateCPF($cpf) 
    {
        // Verificar se foi informado
        if(empty($cpf))
            return false;

        // Remover caracteres especias
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o numero de digitos informados
        if (strlen($cpf) != 11)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf))
            return false;

        // Calcula os digitos verificadores para verificar se o
        // CPF é válido
        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d)
                return false;
        }
            
        return true;
    }

    // Validar numero de CNPJ
    public static function validateCNPJ($cnpj) 
    {
        // Verificar se foi informado
        if(empty($cnpj))
            return false;

        // Remover caracteres especias
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Verifica se o numero de digitos informados
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0, $n = 0; $i < 12; $n += $cnpj[$i] * $b[++$i]);

        if ($cnpj[12] != ((($n %= 11) < 2) ? 0 : 11 - $n))
            return false;

        for ($i = 0, $n = 0; $i <= 12; $n += $cnpj[$i] * $b[$i++]);

        if ($cnpj[13] != ((($n %= 11) < 2) ? 0 : 11 - $n))
            return false;

        return true;
    }
}