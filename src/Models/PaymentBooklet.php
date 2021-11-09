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

        if(!isset($response['id']))
            return [ ['Não foi possivel criar o carnê'], false];
        
        $repeat = 0;

        a:
        sleep(5);
        $slips = self::list($response['id']);
        if(!$slips[1])
            throw new \Exception(implode('\\n', $slips[0]), 1);

        $slips = $slips[0];
        if(!isset($slips['boleto']))
            throw new \Exception('Não foi possivel econtrar o carnê de pagamento', 1);

        $id = $slips['id'];
        if(empty($slips['boleto']))
        {
            if($repeat === 3)
                throw new \Exception("Não foi possivel econtrar os boletos para o carnê: $id ", 1);
            $repeat += 1;
            goto a;
        }

        $booklet = [];
        foreach ($slips['boleto'] as $slip) 
        {
            $slip = Utils::formatResponse($slip, self::$type);
            array_push($booklet, $slip);
        }

        return [$booklet, true];
    }

    public static function list($id = null)
    {
        $url = ($id != null) ? self::$url."/$id" : self::$url;
        $response = Aprobank::get($url);

        if(isset($response['data']) || isset($response['id']))
            return [$response, true];
        
        return [ ['Não foi possivel listar'], false];
    }

    public static function edit($PaymentBookletId, $data)
    {
    }

    public static function deletePaymentBooklet($id)
    {
        $response = Aprobank::delete( self::$url.'/'.$id );

        if(!isset($response['success']))
            return [['Não foi possivel excluir o carne'], false];
        
        return [$response, true];
    } 
}