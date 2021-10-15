<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Caiocesar173\Aprobank\Http\Libraries\ApiReturn;
use Caiocesar173\Aprobank\Classes\Aprobank;


class PaymentSplit extends Model
{
    protected $table = 'split';
    protected $primaryKey = 'id';

    protected $fillable = [
        'description'
    ];


    public static function create($data)
    {

    }

    public static function list($id = null)
    {
       
    }

    public static function deletePaymentSplit($id)
    {

    } 
}