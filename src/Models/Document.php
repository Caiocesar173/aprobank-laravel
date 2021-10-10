<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Document extends Model
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

    public static function edit($DocumentId, $data)
    {
    }

    public static function deleteDocument($id)
    {
    } 
}