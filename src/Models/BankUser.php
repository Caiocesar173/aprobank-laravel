<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Caiocesar173\Aprobank\Classes\UuidKey;


class BankUser extends Model
{
    use UuidKey;

    protected $table = 'bank_user';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'uuid_external',
    ];

    public static function create($data)
    {
        $bank_user = new self();
        $bank_user->user_id = $data['user_id'];
        $bank_user->uuid_external = $data['uuid_external'];
        
        return $bank_user->save() ? true : false;
    }
    
    public static function list($id = null)
    {
        if($id != null)
            $bank_user = self::where('id', $id)->first();
        else
            $bank_user = self::all();
        
        return  $bank_user;
    }
   
    public static function deleteBankUser($id)
    {
        $deleteBankUser = self::find($id);

        if($deleteBankUser != null)
            return $bank_user->save() ? true : false;

        return "BankUser não encontrado";
    } 
}