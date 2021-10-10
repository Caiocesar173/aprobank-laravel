<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class PaymentLink extends Model
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

    public static function edit($PaymentLinkId, $data)
    {
    }

    public static function deletePaymentLink($id)
    {
    } 

    public static function checkPassword($data)
    {
    }

    public static function pay($data)
    {
    }
}