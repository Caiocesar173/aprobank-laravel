<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Payer extends Model
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

    public static function edit($payerId, $data)
    {
    }

    public static function deletePayer($id)
    {
    } 

    public static function associate($data)
    {
    }
}