<?php

namespace Caiocesar173\Aprobank\Classes;

use Illuminate\Support\Facades\Http;

class Aprobank
{
    private static $headers = [];
    private static $BaseUrl = 'https://aprobank.codfint.com.br/api';
    private static $ApiVersion = 'v1';
    private static $token;


    public function __construct()
    {
        self::$token = env('APROBANK_TOKEN');

        $headers = [
            'Accept' =>  'application/json',
            'Content-Type' =>  'application/json',
            'Authorization' =>  self::$token
        ];
    }

    public static function get($route, $payload = null)
    {
        return Http::withHeaders(self::$headers)->get(self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route, $payload);
    }

    public static function post($route, $payload = null)
    {
        return Http::withHeaders(self::$headers)->post(self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route, $payload);
    }

    public static function put($route, $payload = null)
    {
        return Http::withHeaders(self::$headers)->put(self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route, $payload);
    }

    public static function delete($route, $payload = null)
    {
        return Http::withHeaders(self::$headers)->delete(self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route);
    }
}