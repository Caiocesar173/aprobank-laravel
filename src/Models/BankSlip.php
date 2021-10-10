<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class BankSlip extends Model
{
    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
    }
    
    public static function createPayer($data)
    {
    }  

    public static function list($id = null)
    {
    }

    public static function edit($BankSlipId, $data)
    {
    }

    public static function deleteBankSlip($id)
    {
    } 
}