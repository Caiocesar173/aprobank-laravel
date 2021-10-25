<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;


class Split extends Model
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