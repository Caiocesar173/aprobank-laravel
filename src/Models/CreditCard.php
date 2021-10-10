<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CreditCard extends Model
{
    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function create($data)
    {
    }

    public static function list($id = null)
    {
    }

    public static function edit($CreditCardId, $data)
    {
    }

    public static function deleteCreditCard($id)
    {
    } 

    public static function charge($data)
    {
    }

    public static function chargeback($data)
    {
    }
}