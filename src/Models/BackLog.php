<?php

namespace Caiocesar173\Aprobank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Caiocesar173\Aprobank\Classes\UuidKey;


class BackLog extends Model
{
    use UuidKey;

    protected $table = 'backlog';
    protected $primaryKey = 'id';

    protected $fillable = [
        'url',
        'type',
        'token',
        'payload',
        'headers',
        'response',
        'status',
        'code',
    ];

    public static function create($data)
    {
        $backlog = new self();
        $backlog->url = $data['url'];
        $backlog->status = $data['status'];
        $backlog->code = $data['code'];
        $backlog->token = $data['token'];
        $backlog->type = $data['type'];
        $backlog->headers = json_encode( $data['headers'] );
        $backlog->response = json_encode( $data['response'] );
        
        if(isset($data['payload']))
            $backlog->payload = json_encode( $data['payload'] );

        return $backlog->save() ? true : false;
    }
    
    public static function list($id = null)
    {
        if($id != null)
            $backlog = self::where('id', $id)->first();
        else
            $backlog = self::all();
        
        return  $backlog;
    }

    public static function edit($id)
    {
        $backlog = self::find($id);

        if(!isset($backlog))
            return "Nao foi possivel encontrar o BackLog";
        
        if(isset($data['url']))            
            $backlog->url = $data['url'];
        if(isset($data['token']))        
            $backlog->token = $data['token'];
        if(isset($data['payload']))        
            $backlog->payload = $data['payload'];
        if(isset($data['headers']))            
            $backlog->headers = $data['headers'];
        if(isset($data['response']))        
            $backlog->response = $data['response'];

            return $backlog->save() ? true : false;
    }

    public static function deleteBackLog($id)
    {
        $deleteBackLog = self::find($id);

        if($deleteBackLog != null)
            return $backlog->save() ? true : false;

        return "BackLog não encontrado";
    } 
}