<?php

namespace Caiocesar173\Aprobank\Classes;

use Illuminate\Support\Facades\Http;

class Aprobank
{
    private static $BaseUrl = 'https://aprobank.codfint.com.br/api';
    private static $ApiVersion = 'v1';

    private static function getHeaders()
    {
        return [
            'Accept' =>  'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.env('APROBANK_TOKEN')
        ];
    }

    public static function get($route, $payload = null)
    {
        return Http::withHeaders(self::getHeaders())->get(self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route, $payload);
    }

    public static function post($route, $payload = null)
    {
        return Http::withHeaders(self::getHeaders())->post(self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route, $payload);
    }

    public static function put($route, $payload = null)
    {
        return Http::withHeaders(self::getHeaders())->put(self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route, $payload);
    }

    public static function delete($route, $payload = null)
    {
        return Http::withHeaders(self::getHeaders())->delete(self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route);
    }
}