<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Caiocesar173\Aprobank\Classes\UuidKey;


class BankUser extends Model
{
    use UuidKey;

    protected $table = 'bank_user';
    protected $primaryKey = 'id';

    protected $fillable = [
        'responsable_id',
        'responsable_type',
        'account_id',
        'buyer_id',
        'payer_id',
        'address_id',
    ];



    public static function create($data, $model)
    {
        $bank_user = new self();
        $bank_user->responsable_type = get_class($model);
        $bank_user->responsable_id = $model->id;

        if(isset($data['account_id']))
            $bank_user->account_id = $data['accountId'];
        if(isset($data['buyer_id']))
            $bank_user->buyer_id = $data['buyerId'];
        if(isset($data['payer_id']))
            $bank_user->payer_id = $data['payerId'];
        if(isset($data['address_id']))
            $bank_user->address_id = $data['addressId'];
        
        return $bank_user->save() ? [$bank_user, true] : ['Não foi possivel criar o usuario', false];
    }
    
    public static function list($id = null)
    {
        if(!is_null($id))
            $bank_user = self::where('id', $id)->first();
        else
            $bank_user = self::all();
        
        return ( !empty($bank_user) || !isset($bank_user) ) ? [$bank_user, true] : ['Não foi possivel listar', false];
    }
   
    public static function deleteBankUser($id)
    {
        $deleteBankUser = self::find($id);
        if(!is_null($deleteBankUser))
            return $deleteBankUser->delete() ? ['Usuario excluido com sucesso', true] : ['Não foi possivel excluir o usuario', false];

        return ['Usuario não encontrado', false];
    } 

    public static function hasUser($id, $model)
    {
        $bank_user = self::select('*')
            ->where('responsable_type', get_class($model))
            ->where('responsable_id', $id)
            ->first();

        return !is_null($bank_user) ? [$bank_user, true] : ['Não foi possivel encontrar o usuario', false];
    }
}