<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Finance extends Model
{
    protected $table = '';
    protected $primaryKey = '';

    protected $fillable = [
    ];


    public static function extract($data)
    {
    }

    public static function future($data)
    {
    }

    public static function history($data)
    {
    }

    public static function transaction($data)
    {
    }
}